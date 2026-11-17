<?php
/**
 * Sistema Postagem Anime 
 *
 * @author Sarthemes <sarthemes@gmail.com>
 * @link https://sarthemes.com/
 * @copyright 2020-2021 Sarthemes
 */
use STCode\Seo;

class CustomPost_SEO {

    private static $instance;
    private function __construct() {
        if (stcode_get_option('ativar_seo','false') !== 'false') {
            if (stcode_get_option('seo_articles','false') !== 'false') {
                add_action('add_meta_boxes', [$this,'adicionar_campos_customizados_cartao_credito']);
                add_action('save_post', [$this,'salvar_campos_customizados_cartao_credito']);
            }
            add_filter('pre_get_document_title', [$this,'custom_wp_title']);
            add_action('wp_head', [$this,'google_tagmeta']);
            add_action('wp_head', [$this,'adicionar_meta_tags']);
        }
        add_action('wp_head', function() { echo stripslashes(stcode_get_option('php_header_code')); });
        add_action('wp_footer', function() { echo stripslashes(stcode_get_option('php_footer_code')); });
    }

    public static function get_instance() 
    {
        if ( null == self::$instance ) {
            self::$instance = new CustomPost_SEO();
        }
        return self::$instance;
    }

    public function adicionar_meta_tags() {
        global $post,$wp;
        $seo = new SEO();
        // Verifica se é uma página de postagem única
        if (is_home()) {
            // Obtém os dados específicos, substitua conforme necessário
            $titulo = stcode_change_tags((stcode_get_option('seo_home_title','false') !== 'false') ? stcode_get_option('seo_home_title') : get_bloginfo('name').' - '.get_bloginfo('description'));
            $descricao = stcode_change_tags((stcode_get_option('seo_home_desc','false') !== 'false') ? stcode_get_option('seo_home_desc') : stcode_get_option('seo_geral_desc'));
            
            $seo->set_title($titulo);
            $seo->set_description($descricao);
            $seo->set_canonical(get_home_url());
            $seo->fb_title($titulo);
            $seo->fb_description($descricao);
            $seo->tw_title($titulo);
            $seo->tw_description($descricao);
            
        } else if (is_single()) {
            // Obtém os dados específicos, substitua conforme necessário
            $titulo = stcode_change_tags((get_post_meta(get_the_ID(),'seo_title',true) !== '') ? get_post_meta(get_the_ID(),'seo_title',true) : ((stcode_get_option('seo_video_title','false') !== 'false') ? stcode_get_option('seo_video_title') : get_the_title().' - '.get_bloginfo('name')));
            $descricao = stcode_change_tags((get_post_meta(get_the_ID(),'seo_description',true) !== '') ? get_post_meta(get_the_ID(),'seo_description',true) : ((stcode_get_option('seo_video_desc','false') !== 'false') ? stcode_get_option('seo_video_desc') : stcode_get_option('seo_geral_desc')));
            $fb_titulo = stcode_change_tags((get_post_meta(get_the_ID(),'seo_facebook_title',true) !== '') ? get_post_meta(get_the_ID(),'seo_facebook_title',true) : ((stcode_get_option('seo_video_title','false') !== 'false') ? stcode_get_option('seo_video_title') : get_the_title().' - '.get_bloginfo('name')));
            $fb_descricao = stcode_change_tags((get_post_meta(get_the_ID(),'seo_facebook_description',true) !== '') ? get_post_meta(get_the_ID(),'seo_facebook_description',true) : ((stcode_get_option('seo_video_desc','false') !== 'false') ? stcode_get_option('seo_video_desc') : stcode_get_option('seo_geral_desc')));
            $tw_titulo = stcode_change_tags((get_post_meta(get_the_ID(),'seo_twitter_title',true) !== '') ? get_post_meta(get_the_ID(),'seo_twitter_title',true) : ((stcode_get_option('seo_video_title','false') !== 'false') ? stcode_get_option('seo_video_title') : get_the_title().' - '.get_bloginfo('name')));
            $tw_descricao = stcode_change_tags((get_post_meta(get_the_ID(),'seo_twitter_description',true) !== '') ? get_post_meta(get_the_ID(),'seo_twitter_description',true) : ((stcode_get_option('seo_video_desc','false') !== 'false') ? stcode_get_option('seo_video_desc') : stcode_get_option('seo_geral_desc')));
            $permalink = (get_post_meta(get_the_ID(),'seo_canonical',true) !== '') ? get_post_meta(get_the_ID(),'seo_canonical',true) : get_the_permalink();
            $image = get_the_post_thumbnail_url($post->ID, 'post-thumbnail');
            $fb_image = (get_post_meta(get_the_ID(),'sseo_fb_image',true) !== '') ? get_post_meta(get_the_ID(),'sseo_fb_image',true) : get_the_post_thumbnail_url($post->ID, 'post-thumbnail');
            $tw_image = (get_post_meta(get_the_ID(),'sseo_tw_image',true) !== '') ? get_post_meta(get_the_ID(),'sseo_tw_image',true) : get_the_post_thumbnail_url($post->ID, 'post-thumbnail');

            $seo->set_title($titulo);
            $seo->set_description($descricao);
            $seo->set_image($image);
            $seo->set_canonical($permalink);
            $seo->fb_title($fb_titulo);
            $seo->fb_description($fb_descricao);
            $seo->fb_image($fb_image);
            $seo->fb_url($permalink);
            $seo->tw_title($tw_titulo);
            $seo->tw_description($tw_descricao);
            $seo->tw_image($tw_image);
        } else if (is_page()) {
            // Obtém os dados específicos, substitua conforme necessário
            $titulo = stcode_change_tags((get_post_meta(get_the_ID(),'seo_title',true) !== '') ? get_post_meta(get_the_ID(),'seo_title',true) : ((stcode_get_option('seo_page_title','false') !== 'false') ? stcode_get_option('seo_page_title') : get_the_title().' - '.get_bloginfo('name')));
            $descricao = stcode_change_tags((get_post_meta(get_the_ID(),'seo_description',true) !== '') ? get_post_meta(get_the_ID(),'seo_description',true) : ((stcode_get_option('seo_page_desc','false') !== 'false') ? stcode_get_option('seo_page_desc') : stcode_get_option('seo_geral_desc')));
            $fb_titulo = (stcode_change_tags(get_post_meta(get_the_ID(),'seo_facebook_title',true) !== '') ? get_post_meta(get_the_ID(),'seo_facebook_title',true) : ((stcode_get_option('seo_page_title','false') !== 'false') ? stcode_get_option('seo_page_title') : get_the_title().' - '.get_bloginfo('name')));
            $fb_descricao = stcode_change_tags((get_post_meta(get_the_ID(),'seo_facebook_description',true) !== '') ? get_post_meta(get_the_ID(),'seo_facebook_description',true) : ((stcode_get_option('seo_page_desc','false') !== 'false') ? stcode_get_option('seo_page_desc') : stcode_get_option('seo_geral_desc')));
            $tw_titulo = stcode_change_tags((get_post_meta(get_the_ID(),'seo_twitter_title',true) !== '') ? get_post_meta(get_the_ID(),'seo_twitter_title',true) : ((stcode_get_option('seo_page_title','false') !== 'false') ? stcode_get_option('seo_page_title') : get_the_title().' - '.get_bloginfo('name')));
            $tw_descricao = stcode_change_tags((get_post_meta(get_the_ID(),'seo_twitter_description',true) !== '') ? get_post_meta(get_the_ID(),'seo_twitter_description',true) : ((stcode_get_option('seo_page_desc','false') !== 'false') ? stcode_get_option('seo_page_desc') : stcode_get_option('seo_geral_desc')));
            $permalink = (get_post_meta(get_the_ID(),'seo_canonical',true) !== '') ? get_post_meta(get_the_ID(),'seo_canonical',true) : get_the_permalink();
            $image = get_the_post_thumbnail_url($post->ID, 'post-thumbnail');
            $fb_image = (get_post_meta(get_the_ID(),'sseo_fb_image',true) !== '') ? get_post_meta(get_the_ID(),'sseo_fb_image',true) : get_the_post_thumbnail_url($post->ID, 'post-thumbnail');
            $tw_image = (get_post_meta(get_the_ID(),'sseo_tw_image',true) !== '') ? get_post_meta(get_the_ID(),'sseo_tw_image',true) : get_the_post_thumbnail_url($post->ID, 'post-thumbnail');

            $seo->set_title($titulo);
            $seo->set_description($descricao);
            $seo->set_image($image);
            $seo->set_canonical($permalink);
            $seo->fb_title($fb_titulo);
            $seo->fb_description($fb_descricao);
            $seo->fb_image($fb_image);
            $seo->fb_url($permalink);
            $seo->tw_title($tw_titulo);
            $seo->tw_description($tw_descricao);
            $seo->tw_image($tw_image);
        } else if (is_singular('stcode_seguimentos')) {
            // Obtém os dados específicos, substitua conforme necessário
            $titulo = stcode_change_tags((get_post_meta(get_the_ID(),'seo_title',true) !== '') ? get_post_meta(get_the_ID(),'seo_title',true) : ((stcode_get_option('seo_seguimento_title','false') !== 'false') ? stcode_get_option('seo_seguimento_title') : get_the_title().' - '.get_bloginfo('name')));
            $descricao = stcode_change_tags((get_post_meta(get_the_ID(),'seo_description',true) !== '') ? get_post_meta(get_the_ID(),'seo_description',true) : ((stcode_get_option('seo_seguimento_desc','false') !== 'false') ? stcode_get_option('seo_seguimento_desc') : stcode_get_option('seo_geral_desc')));
            $fb_titulo = (stcode_change_tags(get_post_meta(get_the_ID(),'seo_facebook_title',true) !== '') ? get_post_meta(get_the_ID(),'seo_facebook_title',true) : ((stcode_get_option('seo_seguimento_title','false') !== 'false') ? stcode_get_option('seo_seguimento_title') : get_the_title().' - '.get_bloginfo('name')));
            $fb_descricao = stcode_change_tags((get_post_meta(get_the_ID(),'seo_facebook_description',true) !== '') ? get_post_meta(get_the_ID(),'seo_facebook_description',true) : ((stcode_get_option('seo_seguimento_desc','false') !== 'false') ? stcode_get_option('seo_seguimento_desc') : stcode_get_option('seo_geral_desc')));
            $tw_titulo = stcode_change_tags((get_post_meta(get_the_ID(),'seo_twitter_title',true) !== '') ? get_post_meta(get_the_ID(),'seo_twitter_title',true) : ((stcode_get_option('seo_seguimento_title','false') !== 'false') ? stcode_get_option('seo_seguimento_title') : get_the_title().' - '.get_bloginfo('name')));
            $tw_descricao = stcode_change_tags((get_post_meta(get_the_ID(),'seo_twitter_description',true) !== '') ? get_post_meta(get_the_ID(),'seo_twitter_description',true) : ((stcode_get_option('seo_seguimento_desc','false') !== 'false') ? stcode_get_option('seo_seguimento_desc') : stcode_get_option('seo_geral_desc')));
            $permalink = (get_post_meta(get_the_ID(),'seo_canonical',true) !== '') ? get_post_meta(get_the_ID(),'seo_canonical',true) : get_the_permalink();
            $image = get_the_post_thumbnail_url($post->ID, 'post-thumbnail');
            $fb_image = (get_post_meta(get_the_ID(),'sseo_fb_image',true) !== '') ? get_post_meta(get_the_ID(),'sseo_fb_image',true) : get_the_post_thumbnail_url($post->ID, 'post-thumbnail');
            $tw_image = (get_post_meta(get_the_ID(),'sseo_tw_image',true) !== '') ? get_post_meta(get_the_ID(),'sseo_tw_image',true) : get_the_post_thumbnail_url($post->ID, 'post-thumbnail');

            $seo->set_title($titulo);
            $seo->set_description($descricao);
            $seo->set_image($image);
            $seo->set_canonical($permalink);
            $seo->fb_title($fb_titulo);
            $seo->fb_description($fb_descricao);
            $seo->fb_image($fb_image);
            $seo->fb_url($permalink);
            $seo->tw_title($tw_titulo);
            $seo->tw_description($tw_descricao);
            $seo->tw_image($tw_image);
        } else if (is_singular('stcode_cartao')) {
            // Obtém os dados específicos, substitua conforme necessário
            $titulo = stcode_change_tags((get_post_meta(get_the_ID(),'seo_title',true) !== '') ? get_post_meta(get_the_ID(),'seo_title',true) : ((stcode_get_option('seo_cartao_title','false') !== 'false') ? stcode_get_option('seo_cartao_title') : get_the_title().' - '.get_bloginfo('name')));
            $descricao = stcode_change_tags((get_post_meta(get_the_ID(),'seo_description',true) !== '') ? get_post_meta(get_the_ID(),'seo_description',true) : ((stcode_get_option('seo_cartao_desc','false') !== 'false') ? stcode_get_option('seo_cartao_desc') : stcode_get_option('seo_geral_desc')));
            $fb_titulo = (stcode_change_tags(get_post_meta(get_the_ID(),'seo_facebook_title',true) !== '') ? get_post_meta(get_the_ID(),'seo_facebook_title',true) : ((stcode_get_option('seo_cartao_title','false') !== 'false') ? stcode_get_option('seo_cartao_title') : get_the_title().' - '.get_bloginfo('name')));
            $fb_descricao = stcode_change_tags((get_post_meta(get_the_ID(),'seo_facebook_description',true) !== '') ? get_post_meta(get_the_ID(),'seo_facebook_description',true) : ((stcode_get_option('seo_cartao_desc','false') !== 'false') ? stcode_get_option('seo_cartao_desc') : stcode_get_option('seo_geral_desc')));
            $tw_titulo = stcode_change_tags((get_post_meta(get_the_ID(),'seo_twitter_title',true) !== '') ? get_post_meta(get_the_ID(),'seo_twitter_title',true) : ((stcode_get_option('seo_cartao_title','false') !== 'false') ? stcode_get_option('seo_cartao_title') : get_the_title().' - '.get_bloginfo('name')));
            $tw_descricao = stcode_change_tags((get_post_meta(get_the_ID(),'seo_twitter_description',true) !== '') ? get_post_meta(get_the_ID(),'seo_twitter_description',true) : ((stcode_get_option('seo_cartao_desc','false') !== 'false') ? stcode_get_option('seo_cartao_desc') : stcode_get_option('seo_geral_desc')));
            $permalink = (get_post_meta(get_the_ID(),'seo_canonical',true) !== '') ? get_post_meta(get_the_ID(),'seo_canonical',true) : get_the_permalink();
            $image = get_the_post_thumbnail_url($post->ID, 'post-thumbnail');
            $fb_image = (get_post_meta(get_the_ID(),'sseo_fb_image',true) !== '') ? get_post_meta(get_the_ID(),'sseo_fb_image',true) : get_the_post_thumbnail_url($post->ID, 'post-thumbnail');
            $tw_image = (get_post_meta(get_the_ID(),'sseo_tw_image',true) !== '') ? get_post_meta(get_the_ID(),'sseo_tw_image',true) : get_the_post_thumbnail_url($post->ID, 'post-thumbnail');

            $seo->set_title($titulo);
            $seo->set_description($descricao);
            $seo->set_image($image);
            $seo->set_canonical($permalink);
            $seo->fb_title($fb_titulo);
            $seo->fb_description($fb_descricao);
            $seo->fb_image($fb_image);
            $seo->fb_url($permalink);
            $seo->tw_title($tw_titulo);
            $seo->tw_description($tw_descricao);
            $seo->tw_image($tw_image);
        } else if (is_singular('stcode_conta_digital')) {
            // Obtém os dados específicos, substitua conforme necessário
            $titulo = stcode_change_tags((get_post_meta(get_the_ID(),'seo_title',true) !== '') ? get_post_meta(get_the_ID(),'seo_title',true) : ((stcode_get_option('seo_banco_title','false') !== 'false') ? stcode_get_option('seo_banco_title') : get_the_title().' - '.get_bloginfo('name')));
            $descricao = stcode_change_tags((get_post_meta(get_the_ID(),'seo_description',true) !== '') ? get_post_meta(get_the_ID(),'seo_description',true) : ((stcode_get_option('seo_banco_desc','false') !== 'false') ? stcode_get_option('seo_banco_desc') : stcode_get_option('seo_geral_desc')));
            $fb_titulo = (stcode_change_tags(get_post_meta(get_the_ID(),'seo_facebook_title',true) !== '') ? get_post_meta(get_the_ID(),'seo_facebook_title',true) : ((stcode_get_option('seo_banco_title','false') !== 'false') ? stcode_get_option('seo_banco_title') : get_the_title().' - '.get_bloginfo('name')));
            $fb_descricao = stcode_change_tags((get_post_meta(get_the_ID(),'seo_facebook_description',true) !== '') ? get_post_meta(get_the_ID(),'seo_facebook_description',true) : ((stcode_get_option('seo_banco_desc','false') !== 'false') ? stcode_get_option('seo_banco_desc') : stcode_get_option('seo_geral_desc')));
            $tw_titulo = stcode_change_tags((get_post_meta(get_the_ID(),'seo_twitter_title',true) !== '') ? get_post_meta(get_the_ID(),'seo_twitter_title',true) : ((stcode_get_option('seo_banco_title','false') !== 'false') ? stcode_get_option('seo_banco_title') : get_the_title().' - '.get_bloginfo('name')));
            $tw_descricao = stcode_change_tags((get_post_meta(get_the_ID(),'seo_twitter_description',true) !== '') ? get_post_meta(get_the_ID(),'seo_twitter_description',true) : ((stcode_get_option('seo_banco_desc','false') !== 'false') ? stcode_get_option('seo_banco_desc') : stcode_get_option('seo_geral_desc')));
            $permalink = (get_post_meta(get_the_ID(),'seo_canonical',true) !== '') ? get_post_meta(get_the_ID(),'seo_canonical',true) : get_the_permalink();
            $image = get_the_post_thumbnail_url($post->ID, 'post-thumbnail');
            $fb_image = (get_post_meta(get_the_ID(),'sseo_fb_image',true) !== '') ? get_post_meta(get_the_ID(),'sseo_fb_image',true) : get_the_post_thumbnail_url($post->ID, 'post-thumbnail');
            $tw_image = (get_post_meta(get_the_ID(),'sseo_tw_image',true) !== '') ? get_post_meta(get_the_ID(),'sseo_tw_image',true) : get_the_post_thumbnail_url($post->ID, 'post-thumbnail');

            $seo->set_title($titulo);
            $seo->set_description($descricao);
            $seo->set_image($image);
            $seo->set_canonical($permalink);
            $seo->fb_title($fb_titulo);
            $seo->fb_description($fb_descricao);
            $seo->fb_image($fb_image);
            $seo->fb_url($permalink);
            $seo->tw_title($tw_titulo);
            $seo->tw_description($tw_descricao);
            $seo->tw_image($tw_image);
        } else if (is_singular('stcode_emprestimo')) {
            // Obtém os dados específicos, substitua conforme necessário
            $titulo = stcode_change_tags((get_post_meta(get_the_ID(),'seo_title',true) !== '') ? get_post_meta(get_the_ID(),'seo_title',true) : ((stcode_get_option('seo_emprestimo_title','false') !== 'false') ? stcode_get_option('seo_emprestimo_title') : get_the_title().' - '.get_bloginfo('name')));
            $descricao = stcode_change_tags((get_post_meta(get_the_ID(),'seo_description',true) !== '') ? get_post_meta(get_the_ID(),'seo_description',true) : ((stcode_get_option('seo_emprestimo_desc','false') !== 'false') ? stcode_get_option('seo_emprestimo_desc') : stcode_get_option('seo_geral_desc')));
            $fb_titulo = (stcode_change_tags(get_post_meta(get_the_ID(),'seo_facebook_title',true) !== '') ? get_post_meta(get_the_ID(),'seo_facebook_title',true) : ((stcode_get_option('seo_emprestimo_title','false') !== 'false') ? stcode_get_option('seo_emprestimo_title') : get_the_title().' - '.get_bloginfo('name')));
            $fb_descricao = stcode_change_tags((get_post_meta(get_the_ID(),'seo_facebook_description',true) !== '') ? get_post_meta(get_the_ID(),'seo_facebook_description',true) : ((stcode_get_option('seo_emprestimo_desc','false') !== 'false') ? stcode_get_option('seo_emprestimo_desc') : stcode_get_option('seo_geral_desc')));
            $tw_titulo = stcode_change_tags((get_post_meta(get_the_ID(),'seo_twitter_title',true) !== '') ? get_post_meta(get_the_ID(),'seo_twitter_title',true) : ((stcode_get_option('seo_emprestimo_title','false') !== 'false') ? stcode_get_option('seo_emprestimo_title') : get_the_title().' - '.get_bloginfo('name')));
            $tw_descricao = stcode_change_tags((get_post_meta(get_the_ID(),'seo_twitter_description',true) !== '') ? get_post_meta(get_the_ID(),'seo_twitter_description',true) : ((stcode_get_option('seo_emprestimo_desc','false') !== 'false') ? stcode_get_option('seo_emprestimo_desc') : stcode_get_option('seo_geral_desc')));
            $permalink = (get_post_meta(get_the_ID(),'seo_canonical',true) !== '') ? get_post_meta(get_the_ID(),'seo_canonical',true) : get_the_permalink();
            $image = get_the_post_thumbnail_url($post->ID, 'post-thumbnail');
            $fb_image = (get_post_meta(get_the_ID(),'sseo_fb_image',true) !== '') ? get_post_meta(get_the_ID(),'sseo_fb_image',true) : get_the_post_thumbnail_url($post->ID, 'post-thumbnail');
            $tw_image = (get_post_meta(get_the_ID(),'sseo_tw_image',true) !== '') ? get_post_meta(get_the_ID(),'sseo_tw_image',true) : get_the_post_thumbnail_url($post->ID, 'post-thumbnail');

            $seo->set_title($titulo);
            $seo->set_description($descricao);
            $seo->set_image($image);
            $seo->set_canonical($permalink);
            $seo->fb_title($fb_titulo);
            $seo->fb_description($fb_descricao);
            $seo->fb_image($fb_image);
            $seo->fb_url($permalink);
            $seo->tw_title($tw_titulo);
            $seo->tw_description($tw_descricao);
            $seo->tw_image($tw_image);
        } else if (is_stcode_quiz_page()) {
            // Obtém os dados específicos, substitua conforme necessário
            $titulo = stcode_change_tags((get_post_meta(get_the_ID(),'seo_title',true) !== '') ? get_post_meta(get_the_ID(),'seo_title',true) : ((stcode_get_option('seo_quiz_title','false') !== 'false') ? stcode_get_option('seo_quiz_title') : get_the_title().' - '.get_bloginfo('name')));
            $descricao = stcode_change_tags((get_post_meta(get_the_ID(),'seo_description',true) !== '') ? get_post_meta(get_the_ID(),'seo_description',true) : ((stcode_get_option('seo_quiz_desc','false') !== 'false') ? stcode_get_option('seo_quiz_desc') : stcode_get_option('seo_geral_desc')));
            $fb_titulo = (stcode_change_tags(get_post_meta(get_the_ID(),'seo_facebook_title',true) !== '') ? get_post_meta(get_the_ID(),'seo_facebook_title',true) : ((stcode_get_option('seo_quiz_title','false') !== 'false') ? stcode_get_option('seo_quiz_title') : get_the_title().' - '.get_bloginfo('name')));
            $fb_descricao = stcode_change_tags((get_post_meta(get_the_ID(),'seo_facebook_description',true) !== '') ? get_post_meta(get_the_ID(),'seo_facebook_description',true) : ((stcode_get_option('seo_quiz_desc','false') !== 'false') ? stcode_get_option('seo_quiz_desc') : stcode_get_option('seo_geral_desc')));
            $tw_titulo = stcode_change_tags((get_post_meta(get_the_ID(),'seo_twitter_title',true) !== '') ? get_post_meta(get_the_ID(),'seo_twitter_title',true) : ((stcode_get_option('seo_quiz_title','false') !== 'false') ? stcode_get_option('seo_quiz_title') : get_the_title().' - '.get_bloginfo('name')));
            $tw_descricao = stcode_change_tags((get_post_meta(get_the_ID(),'seo_twitter_description',true) !== '') ? get_post_meta(get_the_ID(),'seo_twitter_description',true) : ((stcode_get_option('seo_quiz_desc','false') !== 'false') ? stcode_get_option('seo_quiz_desc') : stcode_get_option('seo_geral_desc')));
            $permalink = (get_post_meta(get_the_ID(),'seo_canonical',true) !== '') ? get_post_meta(get_the_ID(),'seo_canonical',true) : get_the_permalink();

            $seo->set_title($titulo);
            $seo->set_description($descricao);
            $seo->set_canonical($permalink);
            $seo->fb_title($fb_titulo);
            $seo->fb_description($fb_descricao);
            $seo->fb_url($permalink);
            $seo->tw_title($tw_titulo);
            $seo->tw_description($tw_descricao);
        } else if(is_stcode_archive_list()) {
            // Obtém os dados específicos, substitua conforme necessário
            $titulo = (stcode_get_option('seo_comparador_title','false') !== 'false') ?  stcode_change_tags(stcode_get_option('seo_comparador_title')) : wp_title('',false);
            $descricao = (stcode_get_option('seo_comparador_desc','false') !== 'false') ?  stcode_change_tags(stcode_get_option('seo_comparador_desc')) :  stcode_change_tags(stcode_get_option('seo_geral_desc'));
            $permalink = home_url( $wp->request );

            $seo->set_title($titulo);
            $seo->set_description($descricao);
            $seo->set_canonical($permalink);

            $seo->fb_title($titulo);
            $seo->fb_description($descricao);
            $seo->fb_url($permalink);

            $seo->tw_title($titulo);
            $seo->tw_description($descricao);
        }  else {
            // Obtém os dados específicos, substitua conforme necessário
            $titulo = wp_title('',false);
            $descricao = stcode_change_tags(stcode_get_option('seo_geral_desc'));
            $permalink = home_url( $wp->request );

            $seo->set_title($titulo);
            $seo->set_description($descricao);
            $seo->set_canonical($permalink);

            $seo->fb_title($titulo);
            $seo->fb_description($descricao);
            $seo->fb_url($permalink);

            $seo->tw_title($titulo);
            $seo->tw_description($descricao);
        }

        echo $seo->render();
    }

    public function google_tagmeta() {
        $html = '';
        if (stcode_get_option('google_console') != '') {
            $html .= '<meta name="google-site-verification" content="'.stcode_get_option('google_console').'" />';
        } if (stcode_get_option('google_analytics') != '') { 
            $html .= "<!-- Global site tag (gtag.js) - Google Analytics -->\n
            <script async src=\"https://www.googletagmanager.com/gtag/js?id=".stcode_get_option('google_analytics')."\"></script>\n
            <script>\n
                window.dataLayer = window.dataLayer || [];\n
                function gtag() { dataLayer.push(arguments); }\n
                gtag('js', new Date());\n
                gtag('config', '<?php echo stcode_get_option('google_analytics '); ?>');\n
            </script>";
        }

        echo $html;
    }

    public function custom_wp_title($title) {
        global $wp;
        $current_url = add_query_arg(array(), $wp->request);

        // Verifica se é uma postagem única
        if (is_home()) {
            // Lógica para postagens individuais
            $title = (stcode_get_option('seo_home_title','false') !== 'false') ? stcode_get_option('seo_home_title') : $title;
        }

        if (is_single()) {
            $title = (stcode_get_option('seo_article_title','false') !== 'false') ? stcode_get_option('seo_article_title') : $title;
        }

        if (is_page()) {
            $title = (stcode_get_option('seo_page_title','false') !== 'false') ? stcode_get_option('seo_page_title') : $title;
        }

        if (is_singular('stcode_seguimentos')) {
            $title = (stcode_get_option('seo_seguimento_title','false') !== 'false') ? stcode_get_option('seo_seguimento_title') : $title;
        }

        if (is_singular('stcode_cartao')) {
            $title = (stcode_get_option('seo_cartao_title','false') !== 'false') ? stcode_get_option('seo_cartao_title') : $title;
        }

        if (is_singular('stcode_conta_digital')) {
            $title = (stcode_get_option('seo_banco_title','false') !== 'false') ? stcode_get_option('seo_banco_title') : $title;
        }

        if (is_singular('stcode_emprestimo')) {
            $title = (stcode_get_option('seo_emprestimo_title','false') !== 'false') ? stcode_get_option('seo_emprestimo_title') : $title;
        }

        if (is_stcode_quiz_page()) {
            $title = (stcode_get_option('seo_quiz_title','false') !== 'false') ? stcode_get_option('seo_quiz_title') : $title;
        }

        if(preg_match('/comparador-de-cartao-de-credito?$/', $current_url)) {
            $title = (stcode_get_option('seo_comparador_title','false') !== 'false') ? stcode_get_option('seo_comparador_title') : 'Comparador de Cartão de Crédito';
        }

        if(preg_match('/blog?$/', $current_url, $matches)) {
            $title = 'Últimos Artigos - '.get_bloginfo('name');
        }

        return stcode_change_tags($title);
    }

    // Adicionar campos customizados ao Cartão de Crédito
    function adicionar_campos_customizados_cartao_credito() {
        add_meta_box('campos_seo_post','STCodes SEO',[$this,'mostrar_campos_customizados_seo'],'post','normal','default');
        add_meta_box('campos_seo_page','STCodes SEO',[$this,'mostrar_campos_customizados_seo'],'page','normal','default');
        add_meta_box('campos_seo_cartao','STCodes SEO',[$this,'mostrar_campos_customizados_seo'],'stcode_cartao','normal','default');
        add_meta_box('campos_seo_banco','STCodes SEO',[$this,'mostrar_campos_customizados_seo'],'stcode_conta_digital','normal','default');
        add_meta_box('campos_seo_emprestimo','STCodes SEO',[$this,'mostrar_campos_customizados_seo'],'stcode_emprestimo','normal','default');
        add_meta_box('campos_cartao_credito','STCodes SEO',[$this,'mostrar_campos_customizados_seo'],'stcode_questionarios','normal','default');
    }

    public function mostrar_campos_customizados_seo($post) {
        // Nonce security
        wp_nonce_field('_post_nonce', 'post_nonce');
        $max_upload_size = wp_max_upload_size();
        $max_upload_size_mb = $max_upload_size / ( 1024 * 1024 );
        ?>
        <div class="stcode-tabs-container">
            <ul class="stcode-tabs">
                <li>
                    <a id="tab1" title="SEO" href="#tab1">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" 
                             fill="none" stroke-linecap="round" stroke-linejoin="round"
                        >
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                          <path d="M3 3v18h18"></path>
                            <path d="M20 18v3"></path>
                            <path d="M16 16v5"></path>
                            <path d="M12 13v8"></path>
                            <path d="M8 16v5"></path>
                            <path d="M3 11c6 0 5 -5 9 -5s3 5 9 5"></path>
                        </svg>
                        SEO
                    </a>
                </li>
                <li>
                    <a id="tab2" title="Facebook" href="#tab2">
                        <svg xmlns="http://www.w3.org/2000/svg"  width="24" height="24" viewBox="0 0 320 512" fill="currentColor"><path d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z"/></svg>
                        Facebook
                    </a>
                </li>

                <li>
                    <a id="tab3" title="Twitter" href="#tab3">
                        <svg xmlns="http://www.w3.org/2000/svg"  width="24" height="24" viewBox="0 0 512 512" fill="currentColor"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg>
                        Twitter
                    </a>
                </li>
                <li>
                    <a id="tab4" title="Avançado" href="#tab4">
                        <svg xmlns="http://www.w3.org/2000/svg"  width="24" height="24" viewBox="0 0 512 512" fill="currentColor"><path d="M0 416c0 17.7 14.3 32 32 32l54.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48L480 448c17.7 0 32-14.3 32-32s-14.3-32-32-32l-246.7 0c-12.3-28.3-40.5-48-73.3-48s-61 19.7-73.3 48L32 384c-17.7 0-32 14.3-32 32zm128 0a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zM320 256a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm32-80c-32.8 0-61 19.7-73.3 48L32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l246.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48l54.7 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-54.7 0c-12.3-28.3-40.5-48-73.3-48zM192 128a32 32 0 1 1 0-64 32 32 0 1 1 0 64zm73.3-64C253 35.7 224.8 16 192 16s-61 19.7-73.3 48L32 64C14.3 64 0 78.3 0 96s14.3 32 32 32l86.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48L480 128c17.7 0 32-14.3 32-32s-14.3-32-32-32L265.3 64z"/></svg>         
                        Avançado
                    </a>
                </li>
            </ul>
            <div class="stcode-tab-content-wrapper">
                <section id="tab1-content" class="stcode-tab-content">
                    <div class="stcode-result">
                        <h3>Preview</h3>
                        <div class="stcode-result-title"><?php echo get_post_meta(get_the_ID(),'seo_title',true) !== '' ? get_post_meta(get_the_ID(),'seo_title',true) : 'Example Result Title'; ?></div>
                        <div class="stcode-result-url"><?php echo get_the_permalink() ? get_the_permalink() : 'www.example.com'; ?></div>
                        <div class="stcode-result-description"><?php echo get_post_meta(get_the_ID(),'seo_description',true) !== '' ? get_post_meta(get_the_ID(),'seo_description',true) : 'Example Result Title'; ?></div>
                    </div>
                    <div class="stcode-seo-section">
                        <h3>SEO</h3>
                        <div class="stcode_contends_seo" id="seo_title_box">
                            <div class="label">
                                <label for="seo_title">Titulo</label>
                                <div class="field"><input type="text" name="seo_title" id="seo_title" value="<?php echo get_post_meta(get_the_ID(),'seo_title',true); ?>"></div>
                                <p class="description"><span id="sseo_title_count"><strong>0</strong></span> caracteres. A maioria dos mecanismos de pesquisa usa no máximo 60 caracteres para o título.</p>
                            </div>
                        </div>
                        <div class="stcode_contends_seo" id="seo_description_box">
                            <div class="label">
                                <label for="seo_description">Descrição</label>
                                <div class="field"><textarea name="seo_description" id="seo_description" rows="5"><?php echo get_post_meta(get_the_ID(),'seo_description',true); ?></textarea></div>
                                <p class="description"><span id="sseo_desc_count"><strong>0</strong></span> caracteres. A maioria dos mecanismos de pesquisa usa no máximo 160 caracteres para a descrição.</p>
                            </div>
                        </div>
                    </div>
                </section>
                <section id="tab2-content" class="stcode-tab-content">
                    <h3>Facebook</h3>
                    <div class="stcode_contends_seo" id="seo_facebook_title_box">
                        <div class="label">
                            <label for="seo_facebook_title">Título do Facebook</label>
                            <div class="field"><input type="text" name="seo_facebook_title" id="seo_facebook_title" value="<?php echo get_post_meta(get_the_ID(),'seo_facebook_title',true); ?>"></div>
                            <p class="description">Este é o título compartilhado no Facebook, se deixado em branco será usado o título padrão da postagem.</p>
                        </div>
                    </div>
                    <div class="stcode_contends_seo" id="seo_facebook_description_box">
                        <div class="label">
                            <label for="seo_facebook_description">Descrição do Facebook</label>
                            <div class="field"><textarea name="seo_facebook_description" id="seo_facebook_description" rows="5"><?php echo get_post_meta(get_the_ID(),'seo_facebook_description',true); ?></textarea></div>
                            <p class="description">Esta é a descrição compartilhada no Facebook, se deixada em branco será usada a descrição padrão da postagem.</p>
                        </div>
                    </div>
                    <input type="hidden" name="sseo_fb_image" value="<?php echo get_post_meta(get_the_ID(),'sseo_fb_image',true); ?>" id="sseo-fb-image">
                    <input type="button" class="button-primary sseo-media-button" value="Selecione uma imagem" id="sseo_fb_media_manager">
                    <input type="button" class="button-primary sseo-media-button" value="Remover imagem" id="sseo-fb-media-remove" style="display: none;">
                    <p>Se você deseja substituir a imagem usada no Facebook para esta postagem, carregue/escolha uma imagem aqui. O tamanho do arquivo de imagem não deve exceder <?php echo $max_upload_size_mb; ?> MB. Use imagens com pelo menos 1200 x 630 pixels para obter a melhor exibição em dispositivos de alta resolução. No mínimo, você deve usar imagens de 600 x 315 pixels para exibir postagens de páginas de links com imagens maiores.</p>
                </section> 
                <section id="tab3-content" class="stcode-tab-content">
                    <h3>Twitter</h3>
                    <div class="stcode_contends_seo" id="seo_twitter_title_box">
                        <div class="label">
                            <label for="seo_twitter_title">Título do Twitter</label>
                            <div class="field"><input type="text" name="seo_twitter_title" id="seo_twitter_title" value="<?php echo get_post_meta(get_the_ID(),'seo_twitter_title',true); ?>"></div>
                            <p class="description">Este é o título compartilhado no Twitter, se deixado em branco será usado o título padrão da postagem.</p>
                        </div>
                    </div>
                    <div class="stcode_contends_seo" id="seo_twitter_description_box">
                        <div class="label">
                            <label for="seo_twitter_description">Descrição do Twitter</label>
                            <div class="field"><textarea name="seo_twitter_description" id="seo_twitter_description" rows="5"><?php echo get_post_meta(get_the_ID(),'seo_twitter_description',true); ?></textarea></div>
                            <p class="description">Esta é a descrição compartilhada no Twitter, se deixada em branco será usada a descrição padrão da postagem.</p>
                        </div>
                    </div>
                    <input type="hidden" name="sseo_tw_image" value="<?php echo get_post_meta(get_the_ID(),'sseo_tw_image',true); ?>" id="sseo-tw-image">
                    <input type="button" class="button-primary sseo-media-button" value="Selecione uma imagem" id="sseo_tw_media_manager">
                    <input type="button" class="button-primary sseo-media-button" value="Remover imagem" id="sseo-tw-media-remove" style="display: none;">
                    <p>Se você deseja substituir a imagem usada no Twitter para esta postagem, carregue/escolha uma imagem aqui. O tamanho de imagem recomendado para o Twitter é 1.024 por 512 pixels.</p>
                </section>
                <section id="tab4-content" class="stcode-tab-content">
                    <h3>Avançado</h3>
                    <div class="stcode_contends_seo" id="seo_canonical_box">
                        <div class="label">
                            <label for="seo_canonical">Canonical URL</label>
                            <div class="field"><input type="text" name="seo_canonical" id="seo_canonical" value="<?php echo get_post_meta(get_the_ID(),'seo_canonical',true); ?>"></div>
                        </div>
                    </div>
                </section>
            </div>
        </div><?php
    }

    function salvar_campos_customizados_cartao_credito($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
        if (!isset( $_POST['post_nonce'] ) || ! wp_verify_nonce( $_POST['post_nonce'], '_post_nonce') ) return;
        if (!current_user_can('edit_post', $post_id ) ) return;

        // Array Post-meta
        $update_post_meta = array(
            'seo_title_box',
            'seo_description',
            'seo_facebook_title',
            'seo_facebook_description',
            'seo_twitter_title',
            'seo_twitter_description',
            'sseo_fb_image',
            'sseo_tw_image',
            'seo_canonical'
        );

        // Generate POST @since 2.1.3
        foreach ($update_post_meta as $i => $key) {
            if ( isset( $_POST[$key] ) ) update_post_meta( $post_id, $key, esc_attr( $_POST[$key] ) ); else delete_post_meta( $post_id, $key );
        }
    }
}

CustomPost_SEO::get_instance();