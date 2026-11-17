<?php
/**
 * Cria uma base de metadados
 *
 * Para usar esta classe, você deve passar a ela um array de parâmetros.
 *
 * eg.: $meta = ['type' => 'meta'];
 *
 * @since             2.0.0
 * @package           STCode
 */

namespace STCode;
#------------------------------------------------------------
# - Definindo a classe
#------------------------------------------------------------
class MetafieldsPosts {
    // Atribuidos
    public $args = null;

    #------------------------------------------------------------
    # - Construtor
    #------------------------------------------------------------
    public function __construct($args = null) {
        // Gerar fields
        foreach($args as $item ){
            $this->fields_html($item);
        }
    }

    #------------------------------------------------------------
    # - Obter post-meta
    #------------------------------------------------------------
    public function meta($value,$id = null) {
        global $post;
        $field = get_post_meta( $post->ID, $value, true );
        if (!is_null($id)) {
            $field = get_post_meta( $id, $value, true );
        }
        if ( ! empty( $field ) ) {
            return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
        } else {
            return false;
        }
    }

    #------------------------------------------------------------
    # - Obeter Fields
    #------------------------------------------------------------
    public function fields_html( $item ) {
        switch ( $item['type'] ) {
            case 'text':
                return $this->text($item);
            break;

            case 'textarea':
                return $this->textarea($item);
            break;

            case 'number':
                return $this->number($item);
            break;

            case 'date':
                return $this->tdate($item);
            break;

            case 'generator':
                return $this->generator($item);
            break;

            case 'checkbox':
                return $this->checkbox($item);
            break;

            case 'generos':
                return $this->generos($item);
            break;

            case "radio":
                $this->display_radio($item);
            break;

            case "select":
                $this->display_select($item);
            break;

            case "post":
                $this->selectID($item);
            break;

            case 'upload':
                return $this->upload($item);
            break;

            case "color":
                $this->display_color($item);
            break;

            case 'heading':
                return $this->heading($item);
            break;

        }
    }

    #------------------------------------------------------------
    # - Field Texto
    #------------------------------------------------------------
    public function text($args) {
        // Parametros
        $label          = isset( $args['label'] ) ? $args['label'] : null;
        $id             = isset( $args['id'] ) ? $args['id']       : null;
        $id2            = isset( $args['id2'] ) ? $args['id2']     : null;
        $class          = isset( $args['class'] ) ? $args['class'] : 'w100';
        $fdesc          = isset( $args['fdesc'] ) ? $args['fdesc'] : null;
        $desc           = isset( $args['desc'] ) ? $args['desc']   : null;
        $doubl          = isset( $args['double'] ) ? $args['double'] : null;
        $requi          = isset( $args['require'] ) ? 'required' : null;
        $disable        = isset( $args['disable'] ) ? $args['disable'] : null;
        $placeholder    = isset( $args['placeholder'] ) ? $args['placeholder'] : null;
        $value          = $this->meta( $id ) != '' ? $this->meta( $id ) : $this->meta($id);
        $value2         = $this->meta( $id2 ) != '' ? $this->meta( $id2 ) : $this->meta($id2);
        // Visualizações
        echo '<div class="stcode_contends" id="'.$id.'_box"><div class="label"><label for="'.$id.'">'.$label.'</label>';
        echo '<p class="description">'.$desc.'</p></div>';
        echo '<div class="field">';
        if( $doubl != null ) {
            echo '<div class="'.$class.'"><input class="extra-small-text" type="text" name="'.$id.'" id="'.$id.'" value="'.$value.'" '.$requi.'> - ';
            echo '<input class="extra-small-text" type="text" name="'.$id2.'" id="'.$id2.'" value="'.$value2.'" '.$requi.'></div>';
        } else {
            echo '<input type="text" placeholder="'.$placeholder.'" name="'.$id.'" id="'.$id.'" value="'.$value.'" '.$requi.' '.($disable == true ? 'disabled="disabled"' : null).'>';
        }
        if( $fdesc != null ) {
            echo '<p class="description">'.$fdesc.'</p>';
        }
        echo '</div></div>';
    }
    #------------------------------------------------------------
    # - Field texarea
    #------------------------------------------------------------
    public function textarea($args) {
        // Parametros
        $id         = isset( $args['id'] ) ? $args['id'] : null;
        $desc       = isset( $args['desc'] ) ? $args['desc'] : null;
        $upload     = isset( $args['upload'] ) ? $args['upload'] : null;
        $aid        = isset( $args['aid'] ) ? $args['aid'] : null;
        $label      = isset( $args['label'] ) ? $args['label'] : null;
        $rows       = isset( $args['rows'] ) ? $args['rows'] : null;
        $requi      = isset( $args['require'] ) == 'yes' ? 'required' : null;
        $placeholder    = isset( $args['placeholder'] ) ? $args['placeholder'] : null;
        $value      = $this->meta( $id ) != '' ? $this->meta( $id ) : $this->meta($id);
        // Visualizações
        echo '<div class="stcode_contends" id="'.$id.'_box"><div class="label"><label for="'.$id.'">'.$label.'</label>';
        echo '<p class="description">'.$desc.'</p></div>';
        echo '<div class="field"><textarea name="'.$id.'" id="'.$id.'" rows="'.$rows.'" '.$requi.' placeholder="'.$placeholder.'">'.$value.'</textarea>';
        if( $upload != null ) {
            echo '<input class="'.$aid.' button-secondary" type="button" value="Upload" />';
        }
        echo '</div></div>';
    }
    #------------------------------------------------------------
    # - Field Numero
    #------------------------------------------------------------
    public function number($args) {
        // Parametros
        $label      = isset( $args['label'] ) ? $args['label'] : null;
        $id         = isset( $args['id'] ) ? $args['id']       : null;
        $class      = isset( $args['class'] ) ? $args['class'] : null;
        $fdesc      = isset( $args['fdesc'] ) ? $args['fdesc'] : null;
        $desc       = isset( $args['desc'] ) ? $args['desc']   : null;
        $requi      = isset( $args['require'] ) ? 'required' : null;
        $value      = $this->meta( $id ) != '' ? $this->meta( $id ) : $this->meta($id);
        // Visualizações
        echo '<div class="stcode_contends" id="'.$id.'_box"><div class="label"><label for="'.$id.'">'.$label.'</label>';
        echo '<p class="description">'.$desc.'</p></div>';
        echo '<div class="field">';
        echo '<input class="'.$class.'" type="number" name="'.$id.'" id="'.$id.'" value="'.$value.'" '.$requi.'>';
        if( $fdesc != null ) {
            echo '<p class="description">'.$fdesc.'</p>';
        }
        echo '</div></div>';
    }
    #------------------------------------------------------------
    # - Field Data
    #------------------------------------------------------------
    public function tdate($args) {
        // Parametros
        $id         = isset( $args['id'] ) ? $args['id'] : null;
        $label      = isset( $args['label'] ) ? $args['label'] : null;
        $fdesc      = isset( $args['fdesc'] ) ? $args['fdesc'] : null;
        $requi      = isset( $args['require'] ) == 'yes' ? 'required' : null;
        $value      = $this->meta( $id ) != '' ? $this->meta( $id ) : $this->meta($id);
        // Visualizações
        echo '<div class="stcode_contends" id="'.$id.'_box">';
        echo '<div class="label"><label for="'.$id.'">'.$label.'</label></div>';
        echo '<div class="field">';
        echo '<input class="small-text" type="date" name="'.$id.'" id="'.$id.'" value="'.$value.'" '.$requi.'>';
        if( $fdesc != null ) {
            echo '<p class="description">'.$fdesc.'</p>';
        }
        echo '</div></div>';
    }
    #------------------------------------------------------------
    # - Field Gerador
    #------------------------------------------------------------
    public function generator($args) {
        // Parâmetros
        $infos        = isset( $args['infos'] ) ? $args['infos'] : array();
        $label        = isset( $args['label'] ) ? $args['label'] : null;
        $desc         = isset( $args['desc'] ) ? $args['desc'] : null;
        $style        = isset( $args['style'] ) ? $args['style'] : null;
        $name         = isset( $args['name'] ) ? $args['name'] : null;
        $class        = isset( $args['class'] ) ? $args['class'] : null;
        $placeholder  = isset( $args['placeholder'] ) ? $args['placeholder'] : null;
        $text_buttom  = ( $this->meta( $infos[0]['id'] ) ) ? 'Atualizar' : 'Importar';

        // Visualizações
        echo '<div class="stcode_contends" id="generador_box"><div class="label">';
        echo '<label for="generador">'.$label.'</label>';
        echo '<p class="description">'.$desc.'</p></div>';
        echo '<div class="field">';
        echo '<div class="b_flex" '.$style.'>';
        echo '<div '.$style.' >';
            if ($infos) {
                foreach ($infos as $k => $info ) {
                    $value  = $this->meta( $info['id'] ) != '' ? $this->meta( $info['id'] ) : null;
                    echo '<input class="'.$class.'" type="text" name="'.$info['id'].'" id="'.$info['id'].'" placeholder="'.$info['placeholder'].'" value="'.$value.'">';
                }
            }
        echo '</div>';
        echo '<input type="button" class="button button-primary" name="'.$name.'" id="'.$name.'" value="'.$text_buttom.'"></div>';
        echo '<p id="verificador" style="display:none"><a class="button button-secundary" id="comprovate">Verificar se a conteudos iguais</a></p>';
        echo '</div></div>';
    }
    #------------------------------------------------------------
    # - Field Checkbox
    #------------------------------------------------------------
    public function checkbox($args) {
        // Parâmetros
        $id         = isset( $args['id'] ) ? $args['id'] : null;
        $label      = isset( $args['label'] ) ? $args['label'] : null;
        $desc       = isset( $args['desc'] ) ? $args['desc'] : null;
        $clabel     = isset( $args['clabel'] ) ? $args['clabel'] : null;
        $id2        = isset( $args['id2'] ) ? $args['id2'] : null;
        $requi      = isset( $args['require'] ) == 'yes' ? 'required' : null;
        $disable    = isset( $args['disable'] ) == true ? 'disable' : null;
        $checked    = ( $this->meta( $id ) == $id2 ) ? 'checked' : ($this->meta($id) == $id2 ? 'checked' : null);
        $value      = $args['id2'] != '' ? $args['id2'] : null;
        // Visualizações
        echo '<div class="stcode_contends genero_box" id="'.$id.'_box"><div class="label"><label for="'.$id.'">'.$label.'</label>';
        echo '<p class="description">'.$desc.'</p></div>';
        echo '<div class="field"><input type="checkbox" name="'.$id.'" value="'.$value.'" id="'.$id.'_clik" '.$checked.' '.$requi.'> <label for="'.$id.$disable.'_clik">'.$clabel.'</label></div></div>';
    }
    #------------------------------------------------------------
    # - Field Checkbox
    #------------------------------------------------------------
    public function generos($args) {
        global $post;
        // Parâmetros
        $id         = isset( $args['id'] ) ? $args['id'] : null;
        $label      = isset( $args['label'] ) ? $args['label'] : null;
        $desc       = isset( $args['desc'] ) ? $args['desc'] : null;
        $options    = isset( $args['options'] ) ? $args['options'] : null;
        $requi      = isset( $args['require'] ) == 'yes' ? 'required' : null;
        // Visualizações
        echo '<div class="stcode_contends genero_box" id="'.$id.'_box"><div class="label"><label for="'.$id.'">'.$label.'</label>';
        echo '<p class="description">'.$desc.'</p></div><div class="field">';
        $i = 1;
        foreach ($options as $genID => $nome) {
            $value   = $genID != '' ? $genID : null;
            $checked = ( $this->meta($genID,$post->ID) === $genID ) ? 'checked' : '';
            echo '<div class="box"><input type="checkbox" name="'.$genID.'" value="'.$value.'" id="'.$genID.'_clik" '.$checked.' '.$requi.'><label for="'.$genID.'_clik">'.$nome.'</label></div>';
            $i++;
        }
       echo '</div></div>';
    }
    #------------------------------------------------------------
    # - Field Radio
    #------------------------------------------------------------
    public function display_radio($args) {
        global $post;
        // DATA
        $id         = isset( $args['id'] ) ? $args['id'] : null;
        $label      = isset( $args['label'] ) ? $args['label'] : null;
        $desc       = isset( $args['desc'] ) ? $args['desc'] : null;
        $class      = isset( $args['class'] ) ? $args['class'] : null;
        $options    = isset( $args['options'] ) ? $args['options'] : null;
        $requi      = isset( $args['require'] ) == 'yes' ? 'required' : null;
        // HTML
        echo '<div class="stcode_contends '.$class.'" id="'.$id.'">';
        echo '<div class="label"><label for="'.$id.'">'.$label.'</label><p class="description">'.$desc.'</p></div>';
        echo '<div class="field">';
        $i = 0;
        foreach ($options as $valor => $option) {
            $value   = $valor != '' ? $valor : null;
            $checked = ( $this->meta($id,$post->ID) === (string)$valor ) ? 'checked' : '';
            echo '<div class="radio-box num'.$i.'"><input type="radio" id="'.$id.'_'.$i.'" name="'.$id.'" value="'.$value.'" '.$checked.' '.$requi.'/><label for="'.$id.'_'.$i.'"> '.$option.'</label></div>';
            $i++;
        }
        echo '</div></div>';
    }

    #------------------------------------------------------------
    # - Field Select
    #------------------------------------------------------------
    public function display_select($args) {
        global $post;
        // DATA
        $id         = isset( $args['id'] ) ? $args['id'] : null;
        $label      = isset( $args['label'] ) ? $args['label'] : null;
        $type       = isset( $args['tipo'] ) ? $args['tipo'] : null;
        $desc       = isset( $args['desc'] ) ? $args['desc'] : null;
        $width      = isset( $args['width'] ) ? $args['width'] : null;
        $default    = isset( $args['default'] ) == 'yes' ? 'yes' : null;
        $options    = isset( $args['options'] ) ? $args['options'] : null;
        $requi      = isset( $args['require'] ) == 'yes' ? 'required' : null;
        $id_slug    = isset( $args['slug'] ) ? $args['slug'] : false;
        $class      = isset( $args['class'] ) ? 'class="'.$args['class'].'"' : null;
        // HTML
        echo '<div class="stcode_contends" id="'.$id.'">';
        echo '<div class="label"><label for="'.$id.'">'.$label.'</label><p class="description">'.$desc.'</p></div>';
        echo '<div class="field">';
        if ($id_slug == true) {
            echo '<select '.$class.' id="'.$id.'" name="'.$id.'" style="width:'.$width.';" '.$requi.' data-live-search-placeholder="Pesquise o anime" data-live-search="true">';
        } else {
            echo '<select id="'.$id.'" name="'.$id.'" style="width:'.$width.';" '.$requi.'>';
        } if ($default == 'yes') {
            #nada
        } else {
            echo '<option value="" >- Selecionar -</option>';
        }
        if ($id_slug == true) {
            $anime = $this->meta('mang_slug',$post->ID);
            // Global do Banco de Dados
            global $wpdb;
            // Loop
            $database = $wpdb->get_results("SELECT * FROM $wpdb->posts
                WHERE post_status = 'publish' AND post_type = '$type';");
            foreach ($database as $base) {
                $value = $base->ID != '' ? $base->ID : null;
                echo '<option value="'. $base->ID .'" '. (($base->ID == $anime ) ? 'selected' : '') .'>'. $base->post_title .'</option>';
            }
        } else {
            $i = 0;
            foreach ($options as $valor => $option) {
                $checked = selected( $this->meta($id,$post->ID), $valor, true );
                echo '<option value="'.$valor.'" '.$checked.'>'.$option.'</option>';
                $i++;
            }
        }
        echo '</select></div></div>';
    }
    #------------------------------------------------------------
    # - Display Color
    #------------------------------------------------------------
    public function display_color($args) {
        // Parametros
        $label      = isset( $args['label'] ) ? $args['label'] : null;
        $id         = isset( $args['id'] ) ? $args['id']       : null;
        $class      = isset( $args['class'] ) ? $args['class'] : null;
        $default    = isset( $args['default'] ) ? $args['default'] : null;
        $desc       = isset( $args['desc'] ) ? $args['desc']   : null;
        $requi      = isset( $args['require'] ) ? 'required' : null;
        $value      = $this->meta( $id ) != '' ? $this->meta( $id ) : null;
        // Visualizações
        echo '<div class="stcode_contends" id="'.$id.'_box"><div class="label"><label for="'.$id.'">'.$label.'</label>';
        echo '<p class="description">'.$desc.'</p></div>';
        echo '<div class="field">';
        echo '<input class="stms-color-picker '.$class.'" type="text" maxlength="7" data-default-color="'.$value.'" style="display:inline-block" id="'.$id.'" name="'.$id.'" value="'.$value.'">';
        echo '</div></div>';
    }
    #------------------------------------------------------------
    # - Field Select ID Post
    #------------------------------------------------------------
    public function selectID($args) {
        global $post;
        // DATA
        $id         = isset( $args['id'] ) ? $args['id'] : null;
        $label      = isset( $args['label'] ) ? $args['label'] : null;
        $type       = isset( $args['tipo'] ) ? $args['tipo'] : null;
        $desc       = isset( $args['desc'] ) ? $args['desc'] : null;
        $save       = isset( $args['save'] ) ? 'save' : null;
        $width      = isset( $args['width'] ) ? $args['width'] : null;
        $default    = isset( $args['default'] ) == 'yes' ? 'yes' : null;
        $options    = isset( $args['options'] ) ? $args['options'] : null;
        $requi      = isset( $args['require'] ) == 'yes' ? 'required' : null;
        $id_slug    = isset( $args['slug'] ) ? $args['slug'] : false;
        $class      = isset( $args['class'] ) ? 'class="'.$args['class'].'"' : null;
        // HTML
        echo '<div class="stcode_contends" id="'.$id.'">';
        echo '<div class="label"><label for="'.$id.'">'.$label.'</label><p class="description">'.$desc.'</p></div>';
        echo '<div class="field">';
        echo '<select '.$class.' id="'.$id.'" name="'.$id.'" style="width:'.$width.';" '.$requi.' data-live-search-placeholder="Pesquise a postagem" data-live-search="true">';
        if ($default == 'yes') {
            #nada
        } else {
            echo '<option value="" >- Selecionar -</option>';
        }
        $anime = $this->meta($id,$post->ID);
        // Global do Banco de Dados
        global $wpdb;
        // Loop
        $database = $wpdb->get_results("SELECT * FROM $wpdb->posts
            WHERE post_status = 'publish' AND post_type = '$type'
            ORDER BY post_date DESC;");
        foreach ($database as $base) {
            $value = $base->ID != '' ? $base->ID : null;
            echo '<option value="'. $base->ID .'" '. (($base->ID == $anime ) ? 'selected' : '') .'>'. $base->post_title .'</option>';
        }
        echo '</select></div></div>';
    }
    #------------------------------------------------------------
    # - Atualizações de upload
    #------------------------------------------------------------
    public function upload($args) {
        global $post;
        // Parâmetros
        $id      = isset( $args['id'] ) ? $args['id'] : null;
        $class   = isset( $args['class'] ) ? $args['class'] : null;
        $label   = isset( $args['label'] ) ? $args['label'] : null;
        $desc    = isset( $args['desc'] ) ? $args['desc'] : null;
        $ajax    = isset( $args['ajax'] ) ? $args['ajax'] : null;
        $prelink = isset( $args['prelink'] ) ? $args['prelink'] : null;
        $nonce   = wp_create_nonce('stcode-upload-image');
        $value   = $id ? $this->meta($id) : false;
        $btntext = 'Subir Agora';
        $btnuplo = 'Fazer Upload';

        // Visualizações
        echo '<div class="stcode_contends" id="'.$id.'_box"><div class="label"><label for="'.$id.'">'.$label.'</label>';
        echo '<p class="description">'.$desc.'</p></div>';
        echo '<div class="field b_flex">';
        echo '<input type="text" name="'.$id.'" id="'.$id.'" value="'.$value.'">';
        echo '<input class="stcode_upload button-secondary" type="button" data-id="'.$id.'" value="'.$btnuplo.'" />';
        echo '</div></div>';
    }
    #------------------------------------------------------------
    # - Field  Heading
    #------------------------------------------------------------
    public function heading($args) {
        // Parâmetros
        $colspan = isset( $args['colspan'] ) ? $args['colspan'] : null;
        $text    = isset( $args['text'] ) ? $args['text'] : null;

        // Visualizações
        echo '<div class="stcode_contends title_heading"><div colspan="'.$colspan.'"><h3>'.$text.'</h3></div></div>';
    }
}