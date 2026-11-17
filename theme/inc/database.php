<?php
/**
 * Cria tabelas na database do server 
 *
 * @author    Sarthemes
 * @link      https://sarthemes.com
 * @version      1.0.0
 *
 */
add_action("after_switch_theme", "stcode_create_tables");

/**
* Cria/atualiza as tabelas do banco de dados.
*
* @since    1.0.0
* @param    string   $prefix
* @global   object   $wpdb
*/
function stcode_create_tables(){
    global $wpdb;

    if ( !empty($wpdb->charset) )
        $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} ";
    if ( !empty($wpdb->collate) )
        $charset_collate .= "COLLATE {$wpdb->collate}";

    $prefix = $wpdb->prefix."stcode_";

    $sql = "
    CREATE TABLE {$prefix}post_views (
        postid bigint(20) NOT NULL,
        view_day datetime NOT NULL,
        view_date date NOT NULL,
        view_datetime datetime NOT NULL,
        pageviews bigint(20) NOT NULL DEFAULT 1,
        PRIMARY KEY  (postid),
        KEY view_date (view_date),
        KEY view_datetime (view_datetime)
    ) {$charset_collate} ENGINE=InnoDB;
    CREATE TABLE {$prefix}posts_permalink(
        permalink_id BIGINT(20) NOT NULL AUTO_INCREMENT,
        post_id BIGINT(20) NOT NULL,
        permalink VARCHAR(255),
        last_update datetime NOT NULL,
        PRIMARY KEY (permalink_id),
        UNIQUE KEY unique_permalink_post_id (permalink, post_id)
    ) {$charset_collate} ENGINE=InnoDB;
    CREATE TABLE {$prefix}questionario(
        question_id BIGINT(20) NOT NULL AUTO_INCREMENT,
        post_id BIGINT(20) NOT NULL,
        question_title VARCHAR(255),
        answer LONGTEXT NOT NULL,
        question_type char(1) NOT NULL,
        PRIMARY KEY (question_id)
    ) {$charset_collate} ENGINE=InnoDB;
    CREATE TABLE {$prefix}quiz_registros(
        quiz_id BIGINT(20) NOT NULL AUTO_INCREMENT,
        quiz_tipo VARCHAR(50) NOT NULL,
        questionario_id BIGINT(20) NOT NULL,
        nome VARCHAR(255),
        email VARCHAR(255) NOT NULL,
        respostas LONGTEXT,
        PRIMARY KEY (quiz_id)
    ) {$charset_collate} ENGINE=InnoDB;
    ";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    dbDelta( $sql );
    update_option('stcode_db', 'true');
}