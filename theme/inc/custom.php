<?php
/**
 * Codigo Personalizado
 *
 * @link              https://sarthemes.com/
 * @since             0.0.1
 * @package           monify/inc
 *
 */

function header_output(){

    $custom = stcode_get_option('css_code');

    echo "\n<style type='text/css'>\n";
    // custom CSS
    if($custom) echo "\n$custom\n";
    echo "</style>\n";
}
add_action('wp_head','header_output');

function footer_output(){

    $custom = stcode_get_option('javascript_code');

    echo "\n<script type='text/javascript'>\n";
    if (is_stcode_template()) {
        echo "(function ($) {
            $('.accordion-item').on('click', function(event){
                event.preventDefault();
                // Verifica se a div clicada já está aberta
                var isOpen = $(this).hasClass('is-active');

                // Fecha todos os itens
                $('.accordion-item').removeClass('is-active');
                $('.accordion-content').slideUp();

                // Se a div clicada não estava aberta, abre
                if (!isOpen) {
                    $(this).addClass('is-active');
                    $(this).find('.accordion-content').slideDown();
                }
            });
        })(jQuery);";
    }
    // custom CSS
    if($custom) echo "\n$custom\n";
    echo "</script>\n";
}
add_action( 'wp_footer', 'footer_output' );

/*
* Generate CSS Line
* Tanks to Doothemes
*/
function stcode_compose_css($class, $type, $val) {
    echo sprintf('%s{%s:%s;}', $class, $type, $val)."\n";
}