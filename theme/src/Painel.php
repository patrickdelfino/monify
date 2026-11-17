<?php
namespace STCode;
class Painel {
    private $options;
    #===============================================
    # Construtor da Classe
    #===============================================
    public function __construct($options) {
        $this->options = $options;
        add_action('admin_menu',array( &$this, 'add_menu') );
    }

    #===============================================
    # Menu
    #===============================================
    public function add_menu() {
        add_menu_page(
            __( 'Opções do Tema', 'stcodes' ),
            __( 'Stcodes', 'stcodes' ),
            'manage_options',
            'stcodes-options',
            array( &$this,'menu_display_page' ),
            'dashicons-admin-stcodes' , 82
        );
    }

    #===============================================
    # Mostrar HTML
    #===============================================
    public function menu_display_page() {

        $this->save_options();
        $menusect = get_option('menu_framework_secion');
        if ($menusect) {
            $msection = ( $menusect['ssection'] ) ? $menusect['ssection'] : 'general';
            $ssection = ( $menusect['msection'] ) ? $menusect['msection'] : 'general';
        } else {
            $msection = 'general';
            $ssection = 'general';
        }
        add_thickbox();
        echo '<form id="stcodes-settings" method="post">';
        wp_nonce_field('monify-save-options', 'monify_options_nonce');
        echo '<div id="stcodes-sidebar" class="stcodes-side-nav-content">
        <div class="h-100" id="leftside-menu-container" data-simplebar>
        <div class="simplebar-wrapper">
        <div class="simplebar-mask">
        <div class="simplebar-offset">
        <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%;">
        <div class="simplebar-content">';
        echo '<ul class="stcodes-side-nav">';
        // Seção
        $li = '';
        foreach ($this->options as $option) {
            if ($option['type'] == "section") {
                $section    = $option['id'];
                $expanded   = ( $option['id'] == $msection ) ? ' aria-expanded="true"' : '';
                $expanded2   = ( $option['id'] == $msection ) ? ' show' : '';
                $li .= '<li class="stcodes-side-nav-item">
                    <a href="#sidebar'.$option['id'].'" data-bs-toggle="collapse" class="stcodes-side-nav-link"'.$expanded.'>
                        <i class="bx '.$option['icon'].'"></i>
                        <span>'.$option['title'].'</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="component-list_body collapse'.$expanded2.'" id="sidebar'.$option['id'].'" data-bs-parent=".stcodes-side-nav">
                        <ul class="stcodes-side-nav-second-level">';
                        foreach ($this->options as $sections) {
                            if ( isset( $sections['section'] ) && ($sections['section'] == $section) && (($sections['type'] == "heading") || ($sections['type'] == "html")) ) {
                                $toctos = ( $sections['id'] == $ssection ) ? 'defaulttab selected' : 'normalizer';
                                $li .= '<li class="stcodes-side-subnav-item '.$toctos.'">
                                    <a class="stcodes-side-subnav-link" href="#'.$sections['id'].'" rel="'.$sections['id'].'" data-parent="'.$sections['section'].'" data-child="'.$sections['id'].'">'.$sections['title'].'</a>
                                </li>';
                            }
                        }
                $li .= '</ul></div></li>';
            }
        }
        echo $li.'</ul></div></div></div></div></div></div></div>';
        echo '<div id="stcodes-content" class="stcodes-panel-content">';

        #===============================================
        # Conteudo
        #===============================================
        foreach ($this->options as $option) {
            if ($option['type'] == "heading") {
                $under_section = $option['id'];
                echo '<div class="tab-content" id="'. $option['id']. '">';
                echo '<div class="row-title">';
                echo isset($option['html']) ? $option['html'] : '<h2>'.$option['title'].'</h2>';
                echo '<input name="publish" class="mpanel-submit button button-primary button-large men_save_framework" type="submit" value="Salvar alterações" /></div>';

                // Under Section
                foreach ($this->options as $item) {
                    if (isset( $item['under_section'] ) && $item['under_section'] == $under_section) {
                        switch ($item['type']) {
                            case "text":
                                $this->display_text($item);
                            break;

                            case "textarea":
                                $this->display_textarea($item);
                            break;

                            case "editor":
                                $this->display_editor($item);
                            break;

                            case "small_heading":
                                $this->display_small_heading($item);
                            break;

                            case "image":
                                $this->display_image($item);
                            break;

                            case "checkbox":
                                $this->display_checkbox($item);
                            break;

                            case "radio":
                                $this->display_radio($item);
                            break;

                            case "select":
                                $this->display_select($item);
                            break;

                            case "pages":
                                $this->display_pages($item);
                            break;

                            case "email":
                                $this->display_email($item);
                            break;

                            case "tips":
                                $this->display_tips($item);
                            break;
                        }
                    }
                }
                echo '</div>';
            }
            if ($option['type'] == "html") {
                echo '<div class="tab-content" id="'. $option['id']. '">';
                echo $option['source'];
                echo '</div>';
            }
        }

        echo '<div class="alert"></div><div class="footer-i">';
        echo '<input name="save" class="mpanel-submit button button-primary button-large men_save_framework" type="submit" value="Salvar alterações" />';
        echo '</div>';
        echo '<input type="hidden" name="action" id="action" value="stcodes_save_options" /></form>';
    }

    #===============================================
    # Salvar Opções
    #===============================================
    public function save_options() {
        if (($_POST['action'] ?? '') !== 'stcodes_save_options') {
            return;
        }
        if (!current_user_can('manage_options')) {
            wp_die('Acesso negado.', '', ['response' => 403]);
        }
        check_admin_referer('monify-save-options', 'monify_options_nonce');
        $submitted = isset($_POST[STCODE_OPTIONS]) && is_array($_POST[STCODE_OPTIONS])
            ? wp_unslash($_POST[STCODE_OPTIONS]) : [];
        foreach ($this->options as $field) {
            $type = $field['type'] ?? '';
            $id = $field['id'] ?? null;
            if ($type === 'checkbox') {
                foreach ((array) $id as $key) {
                    stcode_set_option($key, isset($_POST[$key]) ? 'true' : 'false');
                }
                continue;
            }
            if (!is_string($id) || !isset($submitted[$id]) || !is_scalar($submitted[$id])) {
                continue;
            }
            $value = (string) $submitted[$id];
            switch ($type) {
                case 'image':
                    $value = esc_url_raw($value);
                    break;
                case 'email':
                    $value = sanitize_email($value);
                    break;
                case 'select':
                case 'radio':
                    if (!array_key_exists($value, $field['options'] ?? [])) {
                        continue 2;
                    }
                    break;
                case 'textarea':
                case 'editor':
                    $value = current_user_can('unfiltered_html') ? $value : wp_kses_post($value);
                    break;
                case 'text':
                case 'pages':
                    $value = sanitize_text_field($value);
                    break;
                default:
                    continue 2;
            }
            stcode_set_option($id, $value);
        }
    }

    #===============================================
    # Tips
    #===============================================
    public function display_tips($value) {
        
        echo '<div class="info">';
        echo isset( $value['text'] ) ? '<p class="stcodes_f_tips">'. $value['text']. '</p>' :  null;
        echo isset( $value['code'] ) ? '<pre class="stcodes_f_code">'. $value['code']. '</pre>' : null;
        echo '</div>';
    }

    #===============================================
    # Text
    #===============================================
    public function display_text($value) {

        // DATA
        $default        = isset( $value['default'] ) ? $value['default'] : null;
        $placeholder    = isset( $value['placeholder'] ) ? ' placeholder="'. $value['placeholder'] .'"' : null;
        $extra          = isset( $value['extra'] ) ? $value['extra'] : null;
        $option         = ( stcode_get_option( $value['id'] ) ) ? stripslashes( stcode_get_option( $value['id'] ) ) : $default;
        $descr          = isset( $value['desc'] ) ? $value['desc'] : null;
        
        // HTML
        echo '<div class="container"><div class="row">';
        echo '<div class="col-sm-5"><div class="label"><label for="stcodes_options['.$value['id'].']">'.$value['name'].'</label><p class="description">'. $descr. '</p></div></div>';
        echo '<div class="col-sm"><div class="boxes-content">';
        echo '<input '.$placeholder.' class="form-control" id="stcodes_options_'.$value['id'].'" name="stcodes_options['.$value['id'].']" type="text" value="'.$option.'" '.$extra.'/>';
        echo isset( $value['preview'] ) ? '<a href="'. $value['preview']. '" class="button open_preview" target="_blank">Visualizar <i class="bx bx-low-vision"></i></a>' : null;
        echo '</div></div>';
        echo '</div></div>';
    }

    #===============================================
    # Color
    #===============================================
    public function display_color($value) {

        // DATA
        $option = ( stcode_get_option( $value['id'] ) ) ? stripslashes( stcode_get_option( $value['id'] ) ) : '';

        // HTML
        echo '<div class="container"><div class="row">';
        echo '<div class="col-sm-5"><div class="label"><label for="stcodes_options['.$value['id'].']">'.$value['name'].'</label><p class="description">'. $value['desc']. '</p></div></div>';
        echo '<div class="col-sm"><div class="boxes-content">';
        echo isset( $value['img_desc'] ) ? '<div class="stcodes_image_preview"><img src="'. $value['img_desc']. '" /></div>' : null;
        echo '<input class="stms-color-picker" type="text" maxlength="7" data-default-color="'.$value['default'].'" style="display:inline-block" id="stcodes_options_'.$value['id'].'" name="stcodes_options['.$value['id'].']" value="'.$option.'">';
        echo '</div></div>';
        echo '</div></div>';
    }

    #===============================================
    # Image
    #===============================================
    public function display_image($value) {

        // DATA
        $default        = isset( $value['default'] ) ? $value['default'] : null;
        $placeholder    = isset( $value['placeholder'] ) ? ' placeholder ="'. $value['placeholder'] .'"' : null;
        $option         = ( stcode_get_option( $value['id'] ) ) ? stripslashes( stcode_get_option( $value['id'] ) ) : $default;
        $option2        = stcode_get_option( $value['id'] );

        // HTML
        echo '<div class="container"><div class="row">';
        echo '<div class="col-sm-5"><div class="label"><label for="stcodes_options['.$value['id'].']">'.$value['name'].'</label><p class="description">'. $value['desc']. '</p></div></div>';
        echo '<div class="col-sm"><div class="boxes-content">';
        echo '<input'.$placeholder.' id="stcodes_options_'.$value['id'].'" class="form-control stcodes_upload" type="text" value="'.$option.'" name="stcodes_options['.$value['id'].']" />';
        echo '<span class="upload stcodes_upload button button-small doobtn" data-id="'.$value['id'].'">Subir</span>';

        // Delete buttom
        if ( $option2 ) {
            echo '<span type="button" class="stcodes_remove button button-small doobtn" id="remove_'.$value['id'].'" data-id="'.$value['id'].'">Remover</span>';
        } else {
            echo '<span type="button" class="stcodes_remove hiddenex button button-small doobtn" id="remove_'. $value['id']. '" data-id="'.$value['id']. '">Remover</span>';
        }
        echo '<div id="preview_'.$value['id'].'" class="stcodes_image_preview">';

        // Define Image preview
        if($option2) {
            echo '<img src="'.$option2.'" />';
        } elseif( $default != null ) {
            echo '<img src="'.$value['default'].'" />';
        }
        echo '</div>';
        echo '</div></div>';
        echo '</div></div>';
    }

    #===============================================
    # Textarea
    #===============================================
    public function display_textarea($value) {

        $desc = isset( $value['desc'] ) ? $value['desc'] : null;
        // DATA
        
        $pch = isset( $value['placeholder'] ) ? ' placeholder ="'. $value['placeholder'] .'"' : null;
        $opt = ( stcode_get_option( $value['id'] ) ) ? stripslashes( stcode_get_option( $value['id'] ) ) : '';
        $cod = isset( $value['code'] ) ? $value['code'] : null;
        $seo = isset( $value['seo'] ) ? $value['seo'] : false;
        // HTML
        echo '<div class="container"><div class="row">';
        echo '<div class="col-sm-5"><div class="label"><label for="stcodes_options['.$value['id'].']">'.$value['name'].'</label><p class="description">'.$desc.'</p><pre class="stcodes_f_code">'.$cod.'</pre></div></div>';
        echo '<div class="col-sm"><div class="boxes-content">';
        echo isset( $value['img_desc'] ) ? '<div class="stcodes_image_preview"><img src="'. $value['img_desc']. '" /></div>' : null;
        echo $seo ? '<div class="seo-relative"><div class="progressBar"><div class="progressBarcontainer"><div class="speech-bubble">0%</div><div class="progressBarValue"></div></div></div>' : null;
        echo '<textarea'.$pch.' id="stcodes_options_'.$value['id'].'" class="form-control" name="stcodes_options['.$value['id'].']" cols="70" rows="'.$value['rows'].'">'.$opt.'</textarea>';
        echo $seo ? '<div class="chars_count"><span class="current">0</span><span class="maximum">/ 160</span></div></div>' : null;
        echo '</div></div>';
        echo '</div></div>';
    }

    #===============================================
    # Editor CSS
    #===============================================
    public function display_editor($value) {

        $desc = isset( $value['desc'] ) ? $value['desc'] : null;
        // DATA
        $pch = isset( $value['placeholder'] ) ? ' placeholder ="'. $value['placeholder'] .'"' : null;
        $opt = ( stcode_get_option( $value['id'] ) ) ? stripslashes( stcode_get_option( $value['id'] ) ) : '';
        $cod = isset( $value['code'] ) ? $value['code'] : null;

        $editor_default = [
            'theme' => 'default',
            'cdnURL' => 'https://cdn.jsdelivr.net/npm/codemirror@5.60.0',
            'tabSize' => 4,
            'lineNumbers' => true,
            'mode' => 'htmlmixed'
        ];

        $editor = isset( $value['editor'] ) ? $value['editor'] : array();
        $editor = wp_parse_args( $editor, $editor_default );

        // HTML
        echo '<div class="container"><div class="full-r">';
        echo '<div class="col-sm-5"><div class="label"><label for="stcodes_options['.$value['id'].']">'.$value['name'].'</label><p class="description">'.$desc.'</p><pre class="stcodes_f_code">'.$cod.'</pre></div></div>';
        echo '<div class="col-sm"><div class="boxes-content codemirror_editor">';
        echo '<textarea'.$pch.' id="stcodes_options_'.$value['id'].'" class="form-control" data-editor="'.esc_attr( json_encode( $editor ) ).'" name="stcodes_options['.$value['id'].']">'.$opt.'</textarea>';
        echo '</div></div>';
        echo '</div></div>';
    }

    #===============================================
    # Select
    #===============================================
    public function display_select($value) {

        // DATA
        $got = ( stcode_get_option( $value['id'] ) ) ? stripslashes( stcode_get_option( $value['id'] ) ) : '';

        // HTML
        echo '<div class="container"><div class="row">';
        echo '<div class="col-sm-5"><div class="label"><label for="stcodes_options['.$value['id'].']">'.$value['name'].'</label><p class="description">'. $value['desc']. '</p></div></div>';
        echo '<div class="col-sm"><div class="boxes-content">';
        echo isset( $value['img_desc'] ) ? '<div class="stcodes_image_preview"><img src="'. $value['img_desc']. '" /></div>' : null;
        echo '<select class="form-control" name="stcodes_options['.$value['id'].']" id="stcodes_options_'.$value['id'].'">';
        foreach ($value['options'] as $valor => $option) {
            echo '<option value="'.$valor.'" '. selected( $valor, $got, false ) .'>'.$option.'</option>';
        }
        echo '</select>';
        echo '</div></div>';
        echo '</div></div>';
    }

    #===============================================
    # Pages
    #===============================================
    public function display_pages($value) {

        // DATA
        
        $opt = stcode_get_option( $value['id'] );
        $pag = get_pages();

        // HTML
        echo '<div class="container"><div class="row">';
        echo '<div class="col-sm-5"><div class="label"><label for="stcodes_options['.$value['id'].']">'.$value['name'].'</label><p class="description">'. $value['desc']. '</p></div></div>';
        echo '<div class="col-sm"><div class="boxes-content">';
        echo isset( $value['img_desc'] ) ? '<div class="stcodes_image_preview"><img src="'. $value['img_desc']. '" /></div>' : null;
        echo '<select class="form-control" name="stcodes_options['.$value['id'].']" id="stcodes_options_'.$value['id'].'">';
        echo '<option value="" '.selected( $opt, '', false ).'>--Escolha a Pagina--</option>';
        foreach ($pag as $page) {
            echo '<option value="'.$page->ID.'" ' . selected( $opt, $page->ID, false ) . '>'. $page->post_title. '</option>';
        }
        echo '</select>';
        echo '</div></div>';
        echo '</div></div>';
    }

    #===============================================
    # CheckBox
    #===============================================
    public function display_checkbox($value) {

        // DATA
        $desc = isset( $value['desc'] ) ? $value['desc'] : null;
        // HTML
        echo '<div class="container"><div class="row">';
        echo '<div class="col-sm-5"><div class="label"><label>'.$value['name'].'</label><p class="description">'. $desc. '</p></div></div>';
        echo '<div class="col-sm"><div class="boxes-content">';
        echo isset( $value['img_desc'] ) ? '<div class="stcodes_image_preview"><img src="'. $value['img_desc']. '" /></div>' : null;
        $i = 0;
        foreach ($value['options'] as $box) {
            $checked = '';
            if (stcode_get_option($value['id'][$i]) == 'true') {
                $checked = ' checked="checked"';
            } else {
                if ($value['default'][$i] == "checked") {
                    $checked = ' checked="checked"';
                }
            }
            echo '<div class="form-check form-switch"><input class="form-check-input" type="checkbox"'. $checked. ' name="'.$value['id'][$i].'" id="'.$value['id'][$i].'"><label class="form-check-label" for="'.$value['id'][$i].'">'.$box.'</label></div>';
            $i++;
        }
        echo '</div></div>';
        echo '</div></div>';
    }

    #===============================================
    # Radio
    #===============================================
    public function display_radio($value) {

        // DATA
        
        $dfl = ( stcode_get_option( $value['id'] ) ) ? stcode_get_option( $value['id'] ) : $value['default'];

        // HTML
        echo '<div class="container"><div class="row">';
        echo '<div class="col-sm-5"><div class="label"><label for="stcodes_options['.$value['id'].']">'.$value['name'].'</label><p class="description">'. $value['desc']. '</p></div></div>';
        echo '<div class="col-sm"><div class="boxes-content">';
        echo isset( $value['img_desc'] ) ? '<div class="stcodes_image_preview"><img src="'. $value['img_desc']. '" /></div>' : null;
        $i = 0;
        foreach ($value['options'] as $valor => $option) {
            $checked = ($valor == $dfl) ? ' checked="checked"' : null;
            echo '<div class="form-check form-check-inline"><input class="form-check-input" type="radio" id="stcodes_options['.$value['id'].'_'.$i.']" name="stcodes_options['.$value['id'].']" value="'.$valor.'" '.$checked.'><label class="form-check-label" for="stcodes_options['.$value['id'].'_'.$i.']">'.$option.'</label></div>';
            $i++;
        }
        echo '</div></div>';
        echo '</div></div>';
    }

    #===============================================
    # Head Small
    #===============================================
    public function display_small_heading($value) {

        // DATA
        $desc = isset( $value['desc'] ) ? $value['desc'] : null;
        $title = isset( $value['title'] ) ? '<h2>'.$value['title'].'</h2>' : null;

        // HTML
        echo '<div class="container"><div class="title-header">'.$title.$desc.'</div></div>';
    }
} // End Class