<?php
/**
 * Sistema Shortcode
 *
 * eg.: [custom_cartao cartao_nome=""];
 *
 * @since             0.0.1
 * @author            Sarthemes
 * @package           STCode
 */

namespace STCode;
class Questionario {

	// Attributes

	public $postmeta;



    /**

     * @since 2.5.0

     * @version 1.0

     */

	public function __construct(){



        // Main postmeta

        $this->postmeta = 'repeatable_fields';



        // Actions

        add_action('save_post', array($this,'save'));

        add_action('admin_init', array($this,'add_metabox'), 1);

	}



	/**

     * @since 2.5.0

     * @version 1.0

     */

	public function types_player_options(){

		// Normal types

		$types['e']   	= 'Embed';

		$types['d']		= 'MP4';

		$types['b'] 	= 'Blogger';

		$types['h']		= 'HLS';

		// Special types

		$types['s'] 	= 'Shortcode ou HTML';

		// Return Types

		return $types;

	}



    /**

     * @since 2.5.0

     * @version 1.0

     */

	public static function type_player(){

		return array(

			'e'	=> 'Embed',

			'd'	=> 'MP4',

			'b'	=> 'Blogger',

			'h'	=> 'HLS',

			's'	=> 'HTML',

		);

	}



    /**

     * @since 2.5.0

     * @version 1.0

     */

	public function add_metabox(){

		add_meta_box('repeatable-fields', 'Video Player', array($this,'view_metabox'), 'episodio', 'normal', 'default');

	}



    /**

     * @since 2.5.0

     * @version 1.0

     */

	public function view_metabox(){

        global $post;

		$postmneta = $this->get_all_players($post->ID);

		wp_nonce_field('player_editor_nonce','player_editor_nonce');

        require get_parent_theme_file_path('/inc/library/players/model.php');

	}



	/**

     * @since 2.5.0

     * @version 1.0

     */

	public function get_players_count($id)

	{

		if ($id != '') {

			// Chama a global do WPDB

			global $wpdb;



			// Salva o prefixo do WP

			$prefix = $wpdb->prefix;



			$query = $wpdb->get_var("

			SELECT COUNT(*) FROM {$prefix}stcode_players

			WHERE ep_id = '{$id}'

			");

			return ($query > 1) ? $query : 1;

		} else {

			return '';

		}

	}



	/**

     * @since 2.5.0

     * @version 1.0

     */

	public function update_player_link($post_id, $player_num, $player_link, $player_type)

	{

		// Chama a Global WPDB

	    global $wpdb;

	    

	    // Guarda o prefixo do WP

	    $prefix = $wpdb->prefix;



	    // Verifica se o link já existe

	    $result = $wpdb->get_results("

	        SELECT player_link, player_type FROM {$prefix}stcode_players

	        WHERE ep_id = '{$post_id}' AND player_num = '{$player_num}'

	    ", ARRAY_A);



	    // Verifica se o dado já existe e se já é igual ao solicitado à ser alterado

	    if ( array_key_exists(0, $result) && $player_link != $result[0]['player_link'] ) {

	        $wpdb->query("

	            UPDATE {$prefix}stcode_players

	            SET player_link = '{$player_link}'

	            WHERE ep_id = '{$post_id}' AND player_num = '{$player_num}'

			");

			// Verifica se o tipo de player foi alterado

			if ( $player_type != $result[0]['player_type'] ) {

				$wpdb->query("

					UPDATE {$prefix}stcode_players

					SET player_type = '{$player_type}'

					WHERE ep_id = '{$post_id}' AND player_num = '{$player_num}'

				");

			}

	    } elseif ( isset($result[0]) AND $player_link == $result[0]['player_link'] ) {

	        // Não faz absolutamente nada, pois os dados são iguais

	    } else {

	        $wpdb->query("

	            INSERT INTO {$prefix}stcode_players(ep_id, player_num, player_link, player_type)

	            VALUES('{$post_id}', '{$player_num}', '{$player_link}', '{$player_type}')

	        ");

	    }

	}



	/**

     * @since 2.5.0

     * @version 1.0

     */

	public function delete_player_link( $post_id, $player_num )

	{

	    // Chama a Global WPDB

	    global $wpdb;

	    

	    // Guarda o prefixo do WP

	    $prefix = $wpdb->prefix;



	    // Verifica se o link já existe

	    $result = $wpdb->get_col("

	        SELECT player_id FROM {$prefix}stcode_players

	        WHERE ep_id = '{$post_id}' AND player_num = '{$player_num}'

	    ");



	    // Se o dado existir, apaga o link

	    if ( count($result) >= 1 ) {

	        $wpdb->query("

	            DELETE FROM {$prefix}stcode_players

	            WHERE ep_id = '{$post_id}' AND player_num = '{$player_num}'

	        ");

	    }

	}



	/**

     * @since 2.5.0

     * @version 1.0

     */

	public function get_player_link( $post_id, $player_num )

	{

	    // Chama as Globais WPDB e post

	    global $wpdb, $post;



	    // Guarda o prefixo do WP

	    $prefix = $wpdb->prefix;



	    // Pega o link da página do capítulo

	    $result = $wpdb->get_results("

	        SELECT player_link, player_type FROM {$prefix}stcode_players

	        WHERE ep_id = '{$post_id}' AND player_num = '{$player_num}'

	    ", ARRAY_A);



		return ( count($result) >= 1 ) ? $result[0] : '';

	}



	/**

     * @since 2.5.0

     * @version 1.0

     */

	public function get_all_players($id)

	{

		if ($id != '') {

			// Chama a global do WPDB

			global $wpdb;



			// Salva o prefixo do WP

			$prefix = $wpdb->prefix;



			$result = $wpdb->get_results("

				SELECT player_link, player_type FROM {$prefix}stcode_players

				WHERE ep_id = '{$id}'

			", ARRAY_A);

			return ( count($result) >= 1 ) ? $result : '';

		} else {

			return '';

		}

	}



	/**

     * @since 2.5.0

     * @version 1.0

     */

    public static function medias($post_id,$players){

    	$home_url = get_home_url();

        if($players){

			

			$html = '<div class="iframe--video">';

			$num = 1;

			if(!empty($players) && is_array($players)){

				foreach($players as $play){

					// Set Source

					$source = verifyData($play,'player_link');

					$encryp = sarthemes_encrypt('encrypt', $source);

					// HTML Player

					$html .="<div id='source-player-{$num}' class='source-box'>";

					switch (verifyData($play,'player_type')) {

						case 'e':

							$html .= "<iframe class='video-iframe metaframe rptss' async src='{$source}' frameborder='0' scrolling='no' allow='encrypted-media' allowfullscreen></iframe>";

							break;

						case 'd':

							$html .= "<iframe class='video-iframe metaframe rptss' async src='{$home_url}/player/{$encryp}/{$post_id}' frameborder='0' scrolling='no' allow='encrypted-media' allowfullscreen></iframe>";

							break;

						case 'b':

							$html .="<iframe class='video-iframe metaframe rptss' async src='{$source}' frameborder='0' scrolling='no' allow='encrypted-media' allowfullscreen></iframe>";

							break;

						case 's':

							$html .= "<div class='pframe'>".do_shortcode($source)."</div>";

							break;

						case 'h':

							$html .="<iframe class='video-iframe metaframe rptss' async src='{$home_url}/player/{$encryp}?hls=true' frameborder='0' scrolling='no' allow='encrypted-media' allowfullscreen></iframe>";

							break; 

					}



					$html .= "</div>";

					$num++;

				}

			}

			$html .= '<div class="player_option">';

            $html .= '<div class="player_option_button">Selecionar um Player</div>';

            $html .= '<div class="player_option_close">Fechar</div>';

            $html .= '<ul id="player_list">';

	        $num = 1;

	        if(!empty($players) && is_array($players)){

	        	foreach($players as $play) {

	        		$html .= '<li data-tab="source-player-'.$num.'">Player '.$num.'</li>';

	        		$num++;

	            }

	        }



            $html .= '</ul></div>';

            $html .= '</div>';



            echo $html;

        }

    }



    public static function players($post_id,$players){

        if($players){

			$num = 1;

			$option = Player::type_player();

			if(!empty($players) && is_array($players)){

				foreach($players as $play){

					$type  = verifyData($play,'player_type');

					echo '<div class="button--opt" data-tab="source-player-'.$num.'">Player '.$num.' <span class="server">'.$option[$type].'</span></div>';

					$num++;

				}

			}

        }

    }



    /**

     * @since 2.5.0

     * @version 1.0

     */

	public function save($post_id){

		if(!isset($_POST['player_editor_nonce']) || !wp_verify_nonce($_POST['player_editor_nonce'], 'player_editor_nonce')) return;

		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

		if(!current_user_can('edit_post',$post_id)) return;

		// Meta data

		if ( isset( $_POST['player_url_'] ) ) {

	        $urls 			= $_POST['player_url_'];

	        $pTypes 		= $_POST['player_type_'];

			$qntd 			= $this->get_players_count( $post_id );

			$deletou 		= false;

			$qntdDeletes 	= 0;

			foreach ($urls as $i => $url) {

	            $pType = (array_key_exists($i, $pTypes)) ? $pTypes[$i] : 'd';

				if ($url != '') {

					if ( $deletou && $i >= $qntdDeletes ) {

						$this->update_player_link( $post_id, $i-$qntdDeletes, esc_attr( $url ), $pType );

						$this->delete_player_link( $post_id, $i, esc_attr( $url ) );

					} else {

						$this->update_player_link( $post_id, $i, esc_attr( $url ), $pType );

					}

				} else {

					$this->delete_player_link( $post_id, $i, esc_attr( $url ) );

					$deletou =  true;

					$qntdDeletes++;

				}

			}

		}

	}



    /**

     * @since 2.5.0

     * @version 1.0

     */

	public function ajax_isset($data, $n, $k){

		return (isset($data[$n][$k])) ? $data[$n][$k] : false;

	}

}