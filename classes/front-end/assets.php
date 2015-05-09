<?php
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/resources.php');
class Assets {
    
    private $style;
    private $script;
    private $pageSlug;

    public function __construct($slug) {
        $this->pageSlug = $slug;
        $this->addScript(Resources::$script);
        $this->addStyle(Resources::$style);
        add_action('current_screen',array($this,'theme_enqueue_styles'));
    }
    
    public function addScript($asset) {
        if(is_array($asset)) {
            $this->script = $asset;
        }
    }
    public function addStyle($asset) {
       if(is_array($asset)) {
            $this->style = $asset;
        }
    }    
    public function theme_enqueue_styles($current_screen) {
    	wp_enqueue_script('jquery');
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_media();
        $name = explode("_",$current_screen->base);
        if(is_array($this->pageSlug) && in_array(end($name),$this->pageSlug)) {
            if(!empty($this->style)) {
                foreach($this->style as $key => $style) {
                    $depth = array();
                    $url = ENTIRE_FRAMEWORK_URL.$style['link'];
                    if(isset($style['external']) && $style['external']) {
                        $url = $style['link'];
                    }
                    if(isset($style['depth'])) {
                        $depth = $style['depth'];
                    }
                    wp_enqueue_style($key,$url,$depth);
                }
            }
            if(!empty($this->script)) {
                foreach($this->script as $key => $script) {
                    $depth = array();
                    $url = ENTIRE_FRAMEWORK_URL.$script['link'];
                    if(isset($script['external']) && $script['external']) {
                        $url = $script['link'];
                    }
                    if(isset($script['depth'])) {
                        $depth = $script['depth'];
                    }
                    wp_enqueue_script($key,$url,$depth,'',true);
                }
            }
       }
    }    
}

