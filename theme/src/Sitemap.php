<?php
/**
 * Sistema Sitemap
 *
 * Para usar esta classe, você deve passar a ela um array de parâmetros.
 *
 * eg.: $popular_posts = new Query(['range' => 'last7days', 'order_by' => 'views', 'limit' => 5]);
 *
 * @since             0.0.1
 * @author 			  Sarthemes
 * @package           STCode
 */

namespace STCode;

class Sitemap {

	public function __construct() {
		if (stcode_get_option('seo_map') === 'true') {
	        
	        add_action('wp_ajax_stcode_sitemap', [$this, 'Create']);
	        // Agende a execução da função a cada uma semana
			add_action('stcode_sitemap_time', [$this, 'Create']);
			add_filter('cron_schedules', [$this, 'stcode_weekly_cron_schedule']);
            $schedules = wp_get_schedules();
            $schedule = stcode_get_option('sitemap_time_update');
            $schedule = isset($schedules[$schedule]) ? $schedule : 'weekly';
            if (!wp_next_scheduled('stcode_sitemap_time')) {
                wp_schedule_event(time(), $schedule, 'stcode_sitemap_time');
            }
			// Cria o tempo do cron
			add_filter( 'cron_schedules', [$this, 'stcode_weekly_cron_schedule']);
			add_action('template_redirect',[$this,'create_permalink']);
		}
    }

    public function create_permalink() {
        global $wp;
        if (in_array(trim($wp->request, '/'), ['sitemap', 'sitemap.xml'], true)) {
            wp_safe_redirect(home_url('/sitemap_index.xml'), 301);
            exit;
        }
    }

    public function Create() {
        if (wp_doing_ajax()) {
            if (!current_user_can('manage_options')) {
                wp_send_json_error(['message' => 'Acesso negado.'], 403);
            }
            check_ajax_referer('monify-admin-options', 'nonce');
        }
    	// RootPath
        $lock = fopen(ABSPATH . '.monify-sitemap.lock', 'c');
        if (!$lock || !flock($lock, LOCK_EX | LOCK_NB)) {
            if (is_resource($lock)) {
                fclose($lock);
            }
            return;
        }
        try {
		$rootPath = untrailingslashit(ABSPATH);

		// Caminho do sitemap primario
		$sitemap_principal = $rootPath . '/sitemap_index.xml';

		// Abre o arquivo
		$primary = fopen($sitemap_principal, 'w');

		// Defina o cabeçalho XML
		$header = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
		$header .= '<?xml-stylesheet type="text/xsl" href="' . get_home_url() . '/main-sitemap.xsl"?>' . "\n";
		$header .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

		fwrite($primary, $header);

		// Home
		foreach ($this->home() as $sitemap) {
		    $this->escreverSitemap($primary, $sitemap);
		}

		// Artigos
		foreach ($this->articles() as $sitemap) {
		    $this->escreverSitemap($primary, $sitemap);
		}

		// Paginas
		foreach ($this->pages() as $sitemap) {
		    $this->escreverSitemap($primary, $sitemap);
		}

		// Categorias
		if ($this->categorys()) {
		    foreach ($this->categorys() as $sitemap) {
		        $this->escreverSitemap($primary, $sitemap);
		    }
		}

		// Cartões de Crédito
		foreach ($this->cartoes() as $sitemap) {
		    $this->escreverSitemap($primary, $sitemap);
		}

		// Bancos
		foreach ($this->bancos() as $sitemap) {
		    $this->escreverSitemap($primary, $sitemap);
		}

		// Emprestimos
		foreach ($this->emprestimos() as $sitemap) {
		    $this->escreverSitemap($primary, $sitemap);
		}

		// Seguimentos
		foreach ($this->seguimentos() as $sitemap) {
		    $this->escreverSitemap($primary, $sitemap);
		}

		// Feche o arquivo
		fwrite($primary, '</sitemapindex>');

		fclose($primary);
        } finally {
            flock($lock, LOCK_UN);
            fclose($lock);
        }

	}

	// Função para escrever cada entrada do sitemap
	public function escreverSitemap($handle, $loc)
	{
	    fwrite($handle, '<sitemap>' . "\n");
	    fwrite($handle, '<loc>' . $loc . '</loc>' . "\n");
	    fwrite($handle, '<lastmod>' . date('c', time()) . '</lastmod>' . "\n");
	    fwrite($handle, '</sitemap>' . "\n");
	}

    public function stcode_weekly_cron_schedule( $schedules ) {
    	$schedules[ 'weekly' ] = array( 
    		'interval' => 60 * 60 * 24 * 7, # 604,800, seconds in a week
    		'display' => __( 'Semanalmente' )
    	);
    	$next_month = strtotime('+1 month');
    	$last_day = strtotime('last day of', $next_month);
    	$schedules[ 'monthly' ] = array( 
    		'interval' => 30 * DAY_IN_SECONDS, # To run a task on the last day of every month at 2:45 AM:
    		'display' => __( 'Mensalmente' )
    	);
		return $schedules;
	}

	private function home() {
		// RootPath
		$rootPath = untrailingslashit(ABSPATH);

		// Caminho do sitemap primario
		$sitemap_principal = $rootPath.'/sitemap_misc.xml';

		// Sitemaps
		$urls[] = get_home_url().'/sitemap_misc.xml';

		$primary = fopen($sitemap_principal, 'w');

		fwrite($primary, '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.get_home_url().'/sub-sitemap.xsl"?>');
		fwrite($primary, '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');

		fwrite($primary, '<url>');
		fwrite($primary, '<loc>'.get_home_url().'</loc>');
		fwrite($primary, '<lastmod>'.date('c',time()).'</lastmod>');
		fwrite($primary, '<changefreq>always</changefreq>');
		fwrite($primary, '<priority>1.0</priority>');
		fwrite($primary, '</url>');
		fwrite($primary, '<url>');
		fwrite($primary, '<loc>'.get_home_url().'/sitemap</loc>');
		fwrite($primary, '<lastmod>'.date('c',time()).'</lastmod>');
		fwrite($primary, '<changefreq>monthly</changefreq>');
		fwrite($primary, '<priority>0.5</priority>');
		fwrite($primary, '</url>');
		
		// Feche o documento XML
		fwrite($primary, '</urlset>');
		

		// Feche o arquivo
		fclose($primary);

		return $urls;
    }

    private function articles() {
    	$limit 		= stcode_get_option('sitemap_limit');
    	$frequency 	= stcode_get_option('sitemap_articles_frequency');
    	$priority 	= stcode_get_option('sitemap_articles_priority');

    	$limit 		= $limit ? $limit : 100;
    	$frequency 	= $frequency ? $frequency : 'weekly';
    	$priority 	= $priority ? $priority : '0.8';

    	// Consulta para obter postagens do banco de dados
    	$postagens = new \WP_Query(array(
    		'fields'				=> 'ids',
            'post_type'             => 'post',
            'order'                 => 'DESC',
            'posts_per_page'        => -1,
            'post_status'           => 'publish',
            'no_found_rows'         => 'true',
            'ignore_sticky_posts'   => 1
        ));

		// Defina o número máximo de URLs por página
		$urlsPorPagina = $limit;

		// Divida as postagens em páginas
		$paginas = array_chunk($postagens->posts, $urlsPorPagina);

		// Número da página atual
		$paginaAtual = 1;

		// RootPath
		$rootPath = untrailingslashit(ABSPATH);

		// Caminho do sitemap primario
		$sitemap_principal = $rootPath.'/sitemap_articles.xml';

		// Sitemaps
		$urls[] = get_home_url().'/sitemap_articles.xml';

		$primary = fopen($sitemap_principal, 'w');

		foreach ($paginas as $pagina) {
			if (count($paginas) > 1) {
			    // Defina o nome do arquivo de sitemap
			    $nomeArquivo = 'sitemap_articles_'.$paginaAtual.'.xml';

			    //Sitemaps
				$urls[] = get_home_url().'/'.$nomeArquivo;

			    // Abra o arquivo sitemap para escrita
			    $handle = fopen($rootPath.'/'.$nomeArquivo, 'w');

			    // Defina o cabeçalho XML
			    fwrite($primary, '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.get_home_url().'/main-sitemap.xsl"?>');
			    fwrite($primary, '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');

			    fwrite($primary, '<sitemap>');
			    fwrite($primary, '<loc>'.get_home_url().$nomeArquivo.'</loc>');
			    fwrite($primary, '<lastmod>'.date('c',time()).'</lastmod>');
			   	fwrite($primary, '</sitemap>');

			   	fwrite($primary, '</sitemapindex>');

			    // Defina o cabeçalho XML
			    fwrite($handle, '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.get_home_url().'/main-sitemap.xsl"?>');
			    fwrite($handle, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">');

			    // Loop pelas postagens e gere as entradas do sitemap
			    foreach ($pagina as $postagem) {
			    	$attachment_id = get_post_thumbnail_id($postagem);
			    	$attachment_title = sanitize_title(get_the_title($postagem));
					$image = get_post_meta($postagem, 'campo_thumb', true);
			    	if (has_post_thumbnail($postagem)) {
						$attachment_title = get_the_title($attachment_id);
						$image = get_custom_image_src($attachment_id);
					}

			        fwrite($handle, '<url>');
			        fwrite($handle, '<loc>'.get_the_permalink($postagem).'</loc>');
			        fwrite($handle, '<lastmod>'.get_the_modified_date('c',$postagem).'</lastmod>');
			        fwrite($handle, '<changefreq>'.$frequency.'</changefreq>');
			        fwrite($handle, '<priority>'.$priority.'</priority>');
			        fwrite($handle, '<image:image>');
				    fwrite($handle, '<image:loc>'.$image.'</image:loc>');
				    fwrite($handle, '<image:title><![CDATA['.$attachment_title.']]></image:title>');
				    fwrite($handle, '</image:image>');
			        fwrite($handle, '</url>');
			    }

			    // Feche o documento XML
			    fwrite($handle, '</urlset>');

			    // Feche o arquivo
			    fclose($handle);

			    // Incrementa o número da página
			    $paginaAtual++;
			} else {
				fwrite($primary, '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.get_home_url().'/main-sitemap.xsl"?>');
			    fwrite($primary, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">');

				foreach ($pagina as $postagem) {
					$attachment_id = get_post_thumbnail_id($postagem);
			    	$attachment_title = sanitize_title(get_the_title($postagem));
					$image = get_post_meta($postagem, 'campo_thumb', true);
			    	if (has_post_thumbnail($postagem)) {
						$attachment_title = get_the_title($attachment_id);
						$image = get_custom_image_src($attachment_id);
					}

			        fwrite($primary, '<url>');
			        fwrite($primary, '<loc>'.get_the_permalink($postagem).'</loc>');
			        fwrite($primary, '<lastmod>'.get_the_modified_date('c',$postagem).'</lastmod>');
			        fwrite($primary, '<changefreq>'.$frequency.'</changefreq>');
			        fwrite($primary, '<priority>'.$priority.'</priority>');
			        fwrite($primary, '<image:image>');
				    fwrite($primary, '<image:loc>'.$image.'</image:loc>');
				    fwrite($primary, '<image:title><![CDATA['.$attachment_title.']]></image:title>');
				    fwrite($primary, '</image:image>');
			        fwrite($primary, '</url>');
			    }

			    // Feche o documento XML
			    fwrite($primary, '</urlset>');
			}
		}

		// Feche o arquivo
		fclose($primary);

		return $urls;
    }

    private function pages() {
    	$limit 		= stcode_get_option('sitemap_limit');
    	$frequency 	= stcode_get_option('sitemap_pages_frequency');
    	$priority 	= stcode_get_option('sitemap_pages_priority');

    	$limit 		= $limit ? $limit : 100;
    	$frequency 	= $frequency ? $frequency : 'weekly';
    	$priority 	= $priority ? $priority : '0.8';

    	// Consulta para obter postagens do banco de dados
    	$postagens = new \WP_Query(array(
    		'fields'				=> 'ids',
            'post_type'             => 'page',
            'order'                 => 'DESC',
            'posts_per_page'        => -1,
            'post_status'           => 'publish',
            'no_found_rows'         => 'true',
            'ignore_sticky_posts'   => 1
        ));

		// Defina o número máximo de URLs por página
		$urlsPorPagina = $limit;

		// Divida as postagens em páginas
		$paginas = array_chunk($postagens->posts, $urlsPorPagina);

		// Número da página atual
		$paginaAtual = 1;

		// RootPath
		$rootPath = untrailingslashit(ABSPATH);

		// Caminho do sitemap primario
		$sitemap_principal = $rootPath.'/sitemap_pages.xml';

		// Sitemaps
		$urls[] = get_home_url().'/sitemap_pages.xml';

		$primary = fopen($sitemap_principal, 'w');

		foreach ($paginas as $pagina) {
			if (count($paginas) > 1) {
			    // Defina o nome do arquivo de sitemap
			    $nomeArquivo = 'sitemap_pages_'.$paginaAtual.'.xml';

			    // Sitemaps
				$urls[] = get_home_url().'/'.$nomeArquivo;

			    // Abra o arquivo sitemap para escrita
			    $handle = fopen($rootPath.'/'.$nomeArquivo, 'w');

			    // Defina o cabeçalho XML
			    fwrite($primary, '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.get_home_url().'/main-sitemap.xsl"?>');
			    fwrite($primary, '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');

			    fwrite($primary, '<sitemap>');
			    fwrite($primary, '<loc>'.get_home_url().$nomeArquivo.'</loc>');
			    fwrite($primary, '<lastmod>'.date('c',time()).'</lastmod>');
			   	fwrite($primary, '</sitemap>');

			   	fwrite($primary, '</sitemapindex>');

			    // Defina o cabeçalho XML
			    fwrite($handle, '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.get_home_url().'/main-sitemap.xsl"?>');
			    fwrite($handle, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');

			    // Loop pelas postagens e gere as entradas do sitemap
			    foreach ($pagina as $postagem) {
			        fwrite($handle, '<url>');
			        fwrite($handle, '<loc>'.get_the_permalink($postagem).'</loc>');
			        fwrite($handle, '<lastmod>'.get_the_modified_date('c',$postagem).'</lastmod>');
			        fwrite($handle, '<changefreq>'.$frequency.'</changefreq>');
			        fwrite($handle, '<priority>'.$priority.'</priority>');
			        fwrite($handle, '</url>');
			    }

			    // Feche o documento XML
			    fwrite($handle, '</urlset>');

			    // Feche o arquivo
			    fclose($handle);

			    // Incrementa o número da página
			    $paginaAtual++;
			} else {
				fwrite($primary, '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.get_home_url().'/main-sitemap.xsl"?>');
			    fwrite($primary, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">');

				foreach ($pagina as $postagem) {
			        fwrite($primary, '<url>');
			        fwrite($primary, '<loc>'.get_the_permalink($postagem).'</loc>');
			        fwrite($primary, '<lastmod>'.get_the_modified_date('c',$postagem).'</lastmod>');
			        fwrite($primary, '<changefreq>'.$frequency.'</changefreq>');
			        fwrite($primary, '<priority>'.$priority.'</priority>');
			        fwrite($primary, '</url>');
			    }

			    // Feche o documento XML
			    fwrite($primary, '</urlset>');
			}
		}

		// Feche o arquivo
		fclose($primary);

		return $urls;
    }

    private function cartoes() {
    	$limit 		= stcode_get_option('sitemap_limit');
    	$frequency 	= stcode_get_option('sitemap_cartoes_frequency');
    	$priority 	= stcode_get_option('sitemap_cartoes_priority');

    	$limit 		= $limit ? $limit : 100;
    	$frequency 	= $frequency ? $frequency : 'weekly';
    	$priority 	= $priority ? $priority : '0.8';

    	// Consulta para obter postagens do banco de dados
    	$postagens = new \WP_Query(array(
    		'fields'				=> 'ids',
            'post_type'             => 'stcode_cartao',
            'order'                 => 'DESC',
            'posts_per_page'        => -1,
            'post_status'           => 'publish',
            'no_found_rows'         => 'true',
            'ignore_sticky_posts'   => 1
        ));

		// Defina o número máximo de URLs por página
		$urlsPorPagina = $limit;

		// Divida as postagens em páginas
		$paginas = array_chunk($postagens->posts, $urlsPorPagina);

		// Número da página atual
		$paginaAtual = 1;

		// RootPath
		$rootPath = untrailingslashit(ABSPATH);

		// Caminho do sitemap primario
		$sitemap_principal = $rootPath.'/sitemap_cartoes.xml';

		// Sitemaps
		$urls[] = get_home_url().'/sitemap_cartoes.xml';

		$primary = fopen($sitemap_principal, 'w');

		foreach ($paginas as $pagina) {
			if (count($paginas) > 1) {
			    // Defina o nome do arquivo de sitemap
			    $nomeArquivo = 'sitemap_cartoes_'.$paginaAtual.'.xml';

			    // Sitemaps
				$urls[] = get_home_url().'/'.$nomeArquivo;

			    // Abra o arquivo sitemap para escrita
			    $handle = fopen($rootPath.'/'.$nomeArquivo, 'w');

			    // Defina o cabeçalho XML
			    fwrite($primary, '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.get_home_url().'/main-sitemap.xsl"?>');
			    fwrite($primary, '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');

			    fwrite($primary, '<sitemap>');
			    fwrite($primary, '<loc>'.get_home_url().$nomeArquivo.'</loc>');
			    fwrite($primary, '<lastmod>'.date('c',time()).'</lastmod>');
			   	fwrite($primary, '</sitemap>');

			   	fwrite($primary, '</sitemapindex>');

			    // Defina o cabeçalho XML
			    fwrite($handle, '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.get_home_url().'/main-sitemap.xsl"?>');
			    fwrite($handle, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');

			    // Loop pelas postagens e gere as entradas do sitemap
			    foreach ($pagina as $postagem) {
			        fwrite($handle, '<url>');
			        fwrite($handle, '<loc>'.get_the_permalink($postagem).'</loc>');
			        fwrite($handle, '<lastmod>'.get_the_modified_date('c',$postagem).'</lastmod>');
			        fwrite($handle, '<changefreq>'.$frequency.'</changefreq>');
			        fwrite($handle, '<priority>'.$priority.'</priority>');
			        fwrite($handle, '</url>');
			    }

			    // Feche o documento XML
			    fwrite($handle, '</urlset>');

			    // Feche o arquivo
			    fclose($handle);

			    // Incrementa o número da página
			    $paginaAtual++;
			} else {
				fwrite($primary, '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.get_home_url().'/main-sitemap.xsl"?>');
			    fwrite($primary, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">');

				foreach ($pagina as $postagem) {
			        fwrite($primary, '<url>');
			        fwrite($primary, '<loc>'.get_the_permalink($postagem).'</loc>');
			        fwrite($primary, '<lastmod>'.get_the_modified_date('c',$postagem).'</lastmod>');
			        fwrite($primary, '<changefreq>'.$frequency.'</changefreq>');
			        fwrite($primary, '<priority>'.$priority.'</priority>');
			        fwrite($primary, '</url>');
			    }

			    // Feche o documento XML
			    fwrite($primary, '</urlset>');
			}
		}

		// Feche o arquivo
		fclose($primary);

		return $urls;
    }

    private function bancos() {
    	$limit 		= stcode_get_option('sitemap_limit');
    	$frequency 	= stcode_get_option('sitemap_bancos_frequency');
    	$priority 	= stcode_get_option('sitemap_bancos_priority');

    	$limit 		= $limit ? $limit : 100;
    	$frequency 	= $frequency ? $frequency : 'weekly';
    	$priority 	= $priority ? $priority : '0.8';

    	// Consulta para obter postagens do banco de dados
    	$postagens = new \WP_Query(array(
    		'fields'				=> 'ids',
            'post_type'             => 'stcode_conta_digital',
            'order'                 => 'DESC',
            'posts_per_page'        => -1,
            'post_status'           => 'publish',
            'no_found_rows'         => 'true',
            'ignore_sticky_posts'   => 1
        ));

		// Defina o número máximo de URLs por página
		$urlsPorPagina = $limit;

		// Divida as postagens em páginas
		$paginas = array_chunk($postagens->posts, $urlsPorPagina);

		// Número da página atual
		$paginaAtual = 1;

		// RootPath
		$rootPath = untrailingslashit(ABSPATH);

		// Caminho do sitemap primario
		$sitemap_principal = $rootPath.'/sitemap_bancos.xml';

		// Sitemaps
		$urls[] = get_home_url().'/sitemap_bancos.xml';

		$primary = fopen($sitemap_principal, 'w');

		foreach ($paginas as $pagina) {
			if (count($paginas) > 1) {
			    // Defina o nome do arquivo de sitemap
			    $nomeArquivo = 'sitemap_bancos_'.$paginaAtual.'.xml';

			    // Sitemaps
				$urls[] = get_home_url().'/'.$nomeArquivo;

			    // Abra o arquivo sitemap para escrita
			    $handle = fopen($rootPath.'/'.$nomeArquivo, 'w');

			    // Defina o cabeçalho XML
			    fwrite($primary, '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.get_home_url().'/main-sitemap.xsl"?>');
			    fwrite($primary, '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');

			    fwrite($primary, '<sitemap>');
			    fwrite($primary, '<loc>'.get_home_url().$nomeArquivo.'</loc>');
			    fwrite($primary, '<lastmod>'.date('c',time()).'</lastmod>');
			   	fwrite($primary, '</sitemap>');

			   	fwrite($primary, '</sitemapindex>');

			    // Defina o cabeçalho XML
			    fwrite($handle, '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.get_home_url().'/main-sitemap.xsl"?>');
			    fwrite($handle, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');

			    // Loop pelas postagens e gere as entradas do sitemap
			    foreach ($pagina as $postagem) {
			        fwrite($handle, '<url>');
			        fwrite($handle, '<loc>'.get_the_permalink($postagem).'</loc>');
			        fwrite($handle, '<lastmod>'.get_the_modified_date('c',$postagem).'</lastmod>');
			        fwrite($handle, '<changefreq>'.$frequency.'</changefreq>');
			        fwrite($handle, '<priority>'.$priority.'</priority>');
			        fwrite($handle, '</url>');
			    }

			    // Feche o documento XML
			    fwrite($handle, '</urlset>');

			    // Feche o arquivo
			    fclose($handle);

			    // Incrementa o número da página
			    $paginaAtual++;
			} else {
				fwrite($primary, '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.get_home_url().'/main-sitemap.xsl"?>');
			    fwrite($primary, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">');

				foreach ($pagina as $postagem) {
			        fwrite($primary, '<url>');
			        fwrite($primary, '<loc>'.get_the_permalink($postagem).'</loc>');
			        fwrite($primary, '<lastmod>'.get_the_modified_date('c',$postagem).'</lastmod>');
			        fwrite($primary, '<changefreq>'.$frequency.'</changefreq>');
			        fwrite($primary, '<priority>'.$priority.'</priority>');
			        fwrite($primary, '</url>');
			    }

			    // Feche o documento XML
			    fwrite($primary, '</urlset>');
			}
		}

		// Feche o arquivo
		fclose($primary);

		return $urls;
    }

    private function emprestimos() {
    	$limit 		= stcode_get_option('sitemap_limit');
    	$frequency 	= stcode_get_option('sitemap_emprestimos_frequency');
    	$priority 	= stcode_get_option('sitemap_emprestimos_priority');

    	$limit 		= $limit ? $limit : 100;
    	$frequency 	= $frequency ? $frequency : 'weekly';
    	$priority 	= $priority ? $priority : '0.8';

    	// Consulta para obter postagens do banco de dados
    	$postagens = new \WP_Query(array(
    		'fields'				=> 'ids',
            'post_type'             => 'stcode_emprestimo',
            'order'                 => 'DESC',
            'posts_per_page'        => -1,
            'post_status'           => 'publish',
            'no_found_rows'         => 'true',
            'ignore_sticky_posts'   => 1
        ));

		// Defina o número máximo de URLs por página
		$urlsPorPagina = $limit;

		// Divida as postagens em páginas
		$paginas = array_chunk($postagens->posts, $urlsPorPagina);

		// Número da página atual
		$paginaAtual = 1;

		// RootPath
		$rootPath = untrailingslashit(ABSPATH);

		// Caminho do sitemap primario
		$sitemap_principal = $rootPath.'/sitemap_emprestimos.xml';

		// Sitemaps
		$urls[] = get_home_url().'/sitemap_emprestimos.xml';

		$primary = fopen($sitemap_principal, 'w');

		foreach ($paginas as $pagina) {
			if (count($paginas) > 1) {
			    // Defina o nome do arquivo de sitemap
			    $nomeArquivo = 'sitemap_emprestimos_'.$paginaAtual.'.xml';

			    // Sitemaps
				$urls[] = get_home_url().'/'.$nomeArquivo;

			    // Abra o arquivo sitemap para escrita
			    $handle = fopen($rootPath.'/'.$nomeArquivo, 'w');

			    // Defina o cabeçalho XML
			    fwrite($primary, '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.get_home_url().'/main-sitemap.xsl"?>');
			    fwrite($primary, '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');

			    fwrite($primary, '<sitemap>');
			    fwrite($primary, '<loc>'.get_home_url().$nomeArquivo.'</loc>');
			    fwrite($primary, '<lastmod>'.date('c',time()).'</lastmod>');
			   	fwrite($primary, '</sitemap>');

			   	fwrite($primary, '</sitemapindex>');

			    // Defina o cabeçalho XML
			    fwrite($handle, '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.get_home_url().'/main-sitemap.xsl"?>');
			    fwrite($handle, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');

			    // Loop pelas postagens e gere as entradas do sitemap
			    foreach ($pagina as $postagem) {
			        fwrite($handle, '<url>');
			        fwrite($handle, '<loc>'.get_the_permalink($postagem).'</loc>');
			        fwrite($handle, '<lastmod>'.get_the_modified_date('c',$postagem).'</lastmod>');
			        fwrite($handle, '<changefreq>'.$frequency.'</changefreq>');
			        fwrite($handle, '<priority>'.$priority.'</priority>');
			        fwrite($handle, '</url>');
			    }

			    // Feche o documento XML
			    fwrite($handle, '</urlset>');

			    // Feche o arquivo
			    fclose($handle);

			    // Incrementa o número da página
			    $paginaAtual++;
			} else {
				fwrite($primary, '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.get_home_url().'/main-sitemap.xsl"?>');
			    fwrite($primary, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">');

				foreach ($pagina as $postagem) {
			        fwrite($primary, '<url>');
			        fwrite($primary, '<loc>'.get_the_permalink($postagem).'</loc>');
			        fwrite($primary, '<lastmod>'.get_the_modified_date('c',$postagem).'</lastmod>');
			        fwrite($primary, '<changefreq>'.$frequency.'</changefreq>');
			        fwrite($primary, '<priority>'.$priority.'</priority>');
			        fwrite($primary, '</url>');
			    }

			    // Feche o documento XML
			    fwrite($primary, '</urlset>');
			}
		}

		// Feche o arquivo
		fclose($primary);

		return $urls;
    }

    private function categorys() {
    	$limit 		= stcode_get_option('sitemap_limit');
    	$limit 		= $limit ? $limit : 100;
    	$urls 		= [];

    	// Consulta para obter postagens do banco de dados
    	$categories = get_categories(array(
	        'orderby' => 'name',
	        'order' => 'ASC',
	        'hide_empty' => 1, // Set to 0 to display empty categories
	    ));

    	if ($categories) {
			// Defina o número máximo de URLs por página
			$urlsPorPagina = $limit;

			// Divida as postagens em páginas
			$paginas = array_chunk($categories, $urlsPorPagina);

			// Número da página atual
			$paginaAtual = 1;

			// RootPath
			$rootPath = untrailingslashit(ABSPATH);

			// Caminho do sitemap primario
			$sitemap_principal = $rootPath.'/sitemap_categorys.xml';

			// Sitemaps
			$urls[] = get_home_url().'/sitemap_categorys.xml';

			$primary = fopen($sitemap_principal, 'w');

			foreach ($paginas as $pagina) {
				if (count($paginas) > 1) {
				    // Defina o nome do arquivo de sitemap
				    $nomeArquivo = 'sitemap_categorys_'.$paginaAtual.'.xml';

				    // Sitemaps
					$urls[] = get_home_url().'/'.$nomeArquivo;

				    // Abra o arquivo sitemap para escrita
				    $handle = fopen($rootPath.'/'.$nomeArquivo, 'w');

				    // Defina o cabeçalho XML
				    fwrite($primary, '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.get_home_url().'/sub-sitemap.xsl"?>');
				    fwrite($primary, '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');

				    fwrite($primary, '<sitemap>');
				    fwrite($primary, '<loc>'.get_home_url().$nomeArquivo.'</loc>');
				    fwrite($primary, '<lastmod>'.date('c',time()).'</lastmod>');
				   	fwrite($primary, '</sitemap>');

				   	fwrite($primary, '</sitemapindex>');

				    // Defina o cabeçalho XML
				    fwrite($handle, '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.get_home_url().'/sub-sitemap.xsl"?>');
				    fwrite($handle, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');

				    // Loop pelas postagens e gere as entradas do sitemap
				    foreach ($pagina as $postagem) {
				        fwrite($handle, '<url>');
				        fwrite($handle, '<loc>'.get_category_link($postagem).'</loc>');
				        fwrite($handle, '<lastmod>'.date('c').'</lastmod>');
				        fwrite($handle, '<changefreq>monthly</changefreq>');
			        	fwrite($handle, '<priority>0.3</priority>');
				        fwrite($handle, '</url>');
				    }

				    // Feche o documento XML
				    fwrite($handle, '</urlset>');

				    // Feche o arquivo
				    fclose($handle);

				    // Incrementa o número da página
				    $paginaAtual++;
				} else {
					fwrite($primary, '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.get_home_url().'/sub-sitemap.xsl"?>');
				    fwrite($primary, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">');

					foreach ($pagina as $postagem) {
				        fwrite($primary, '<url>');
				        fwrite($primary, '<loc>'.get_category_link($postagem).'</loc>');
				        fwrite($primary, '<lastmod>'.date('c').'</lastmod>');
				        fwrite($primary, '<changefreq>monthly</changefreq>');
			        	fwrite($primary, '<priority>0.3</priority>');
				        fwrite($primary, '</url>');
				    }

				    // Feche o documento XML
				    fwrite($primary, '</urlset>');
				}
			}

			// Feche o arquivo
			fclose($primary);
		}

		return $urls;
    }

    private function seguimentos() {
    	$limit 		= stcode_get_option('sitemap_limit');
    	$frequency 	= stcode_get_option('sitemap_seguimentos_frequency');
    	$priority 	= stcode_get_option('sitemap_seguimentos_priority');

    	$limit 		= $limit ? $limit : 100;
    	$frequency 	= $frequency ? $frequency : 'weekly';
    	$priority 	= $priority ? $priority : '0.8';

    	// Consulta para obter postagens do banco de dados
    	$postagens = new \WP_Query(array(
    		'fields'				=> 'ids',
            'post_type'             => 'stcode_seguimentos',
            'order'                 => 'DESC',
            'posts_per_page'        => -1,
            'post_status'           => 'publish',
            'no_found_rows'         => 'true',
            'ignore_sticky_posts'   => 1
        ));

		// Defina o número máximo de URLs por página
		$urlsPorPagina = $limit;

		// Divida as postagens em páginas
		$paginas = array_chunk($postagens->posts, $urlsPorPagina);

		// Número da página atual
		$paginaAtual = 1;

		// RootPath
		$rootPath = untrailingslashit(ABSPATH);

		// Caminho do sitemap primario
		$sitemap_principal = $rootPath.'/sitemap_seguimentos.xml';

		// Sitemaps
		$urls[] = get_home_url().'/sitemap_seguimentos.xml';

		$primary = fopen($sitemap_principal, 'w');

		foreach ($paginas as $pagina) {
			if (count($paginas) > 1) {
			    // Defina o nome do arquivo de sitemap
			    $nomeArquivo = 'sitemap_seguimentos_'.$paginaAtual.'.xml';

			    // Sitemaps
				$urls[] = get_home_url().'/'.$nomeArquivo;

			    // Abra o arquivo sitemap para escrita
			    $handle = fopen($rootPath.'/'.$nomeArquivo, 'w');

			    // Defina o cabeçalho XML
			    fwrite($primary, '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.get_home_url().'/main-sitemap.xsl"?>');
			    fwrite($primary, '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');

			    fwrite($primary, '<sitemap>');
			    fwrite($primary, '<loc>'.get_home_url().$nomeArquivo.'</loc>');
			    fwrite($primary, '<lastmod>'.date('c',time()).'</lastmod>');
			   	fwrite($primary, '</sitemap>');

			   	fwrite($primary, '</sitemapindex>');

			    // Defina o cabeçalho XML
			    fwrite($handle, '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.get_home_url().'/main-sitemap.xsl"?>');
			    fwrite($handle, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');

			    // Loop pelas postagens e gere as entradas do sitemap
			    foreach ($pagina as $postagem) {
			        fwrite($handle, '<url>');
			        fwrite($handle, '<loc>'.get_the_permalink($postagem).'</loc>');
			        fwrite($handle, '<lastmod>'.get_the_modified_date('c',$postagem).'</lastmod>');
			        fwrite($handle, '<changefreq>'.$frequency.'</changefreq>');
			        fwrite($handle, '<priority>'.$priority.'</priority>');
			        fwrite($handle, '</url>');
			    }

			    // Feche o documento XML
			    fwrite($handle, '</urlset>');

			    // Feche o arquivo
			    fclose($handle);

			    // Incrementa o número da página
			    $paginaAtual++;
			} else {
				fwrite($primary, '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.get_home_url().'/main-sitemap.xsl"?>');
			    fwrite($primary, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">');

				foreach ($pagina as $postagem) {
			        fwrite($primary, '<url>');
			        fwrite($primary, '<loc>'.get_the_permalink($postagem).'</loc>');
			        fwrite($primary, '<lastmod>'.get_the_modified_date('c',$postagem).'</lastmod>');
			        fwrite($primary, '<changefreq>'.$frequency.'</changefreq>');
			        fwrite($primary, '<priority>'.$priority.'</priority>');
			        fwrite($primary, '</url>');
			    }

			    // Feche o documento XML
			    fwrite($primary, '</urlset>');
			}
		}

		// Feche o arquivo
		fclose($primary);

		return $urls;
    }
}