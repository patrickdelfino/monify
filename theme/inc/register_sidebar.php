<?php
/**
 * Sidebar
 *
 * @author Sarthemes <sarthemes@gmail.com>
 * @link https://sarthemes.com/
 * @copyright 2020-2024 Sarthemes
 */

class SidebarRegister {

    private static $instance;
    private function __construct() {
        add_action( 'widgets_init', [$this,'registrar_sidebar']);
    }

    public static function get_instance() 
    {
        if ( null == self::$instance ) {
            self::$instance = new SidebarRegister();
        }
        return self::$instance;
    }

    // Registro da primeira sidebar
    function registrar_sidebar() {
        register_sidebar( array(
            'name'          => __( 'Blog', STCODE_OPTIONS ),
            'id'            => 'sidebar-blog',
            'description'   => __( 'Esta é a primeira sidebar.', STCODE_OPTIONS ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));

        register_sidebar( array(
            'name'          => __( 'Seguimento', STCODE_OPTIONS ),
            'id'            => 'sidebar-seguimento',
            'description'   => __( 'Esta é a segunda sidebar.', STCODE_OPTIONS ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));
    }
}

SidebarRegister::get_instance();