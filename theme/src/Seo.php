<?php
/**
 * Sistema Sitemap
 *
 * Para usar esta classe, você deve passar a ela um array de parâmetros.
 *
 * eg.: $popular_posts = new Query(['range' => 'last7days', 'order_by' => 'views', 'limit' => 5]);
 *
 * @since             0.0.1
 * @author            Sarthemes
 * @package           STCode
 */

namespace STCode;

class SEO {
    private $title,$fb_title,$tw_title,$description,$tw_description,$fb_description,$fb_url,$tw_image,$fb_image,$image,$canonical,$sitename;

    public function set_title($title) {
        $this->title = $title;
    }

    public function fb_title($title) {
        $this->fb_title = $title;
    }

     public function tw_title($title) {
        $this->tw_title = $title;
    }

    public function set_description($description) {
        $this->description = $description;
    }

    public function tw_description($description) {
        $this->tw_description = $description;
    }

    public function fb_description($description) {
        $this->fb_description = $description;
    }

    public function fb_url($url) {
        $this->fb_url = $url;
    }

    public function set_canonical($canonical) {
        $this->canonical = $canonical;
    }

    public function set_blogname($sitename) {
        $this->sitename = $sitename;
    }

    public function set_image($image) {
        $this->image = $image;
    }

    public function fb_image($image) {
        $this->fb_image = $image;
    }

    public function tw_image($image) {
        $this->tw_image = $image;
    }

    public function render() {
        $html = "";

        if ($this->description) $html .= "<meta name='description' content='$this->description'/>\n";
        if ($this->canonical) $html .= "<link rel='canonical' href='$this->canonical' />\n";
        if ($this->image) $html .= "<link rel='image_src' href='$this->image' />\n";
        if ($this->fb_title && $this->fb_description) {
            $html .= "<meta property='og:locale' content='pt_BR' />\n";
            $html .= "<meta property='og:type' content='website' />\n";
            $html .= "<meta property='og:title' content='$this->fb_title' />\n";
            $html .= "<meta property='og:description' content='$this->fb_description' />\n";
            if ($this->fb_url) $html .= "<meta property='og:url' content='$this->fb_url' />\n";
            $html .= "<meta property='og:site_name' content='$this->fb_title' />\n";
            if ($this->fb_image) $html .= "<meta property='og:image' content='$this->fb_image' />\n";
        }
        if ($this->tw_description && $this->tw_title) {
            $html .= "<meta name='twitter:card' content='summary' />\n";
            $html .= "<meta name='twitter:description' content='$this->tw_description' />\n";
            $html .= "<meta name='twitter:title' content='$this->tw_title' />\n";
            if ($this->tw_image) $html .= "<meta name='twitter:image' content='$this->tw_image' />\n";
        }

        return $html;
    }
}