<?php

/**
 * Description of OriggamiWpPostType
 *
 * @author Pablo Pacheco <pablo.pacheco@origgami.com.br>
 */
if (!class_exists('OriggamiWpPostType')) {

    class OriggamiWpPostType {

        private $postType;
        private $args;
        private $labels;
        private $theme;

        public function __construct($postType, $args = null) {
            $this->postType = $postType;
            $postTypeStr = $postType;

            $labels = array(
                'name' => $postTypeStr . 's',
                'singular_name' => $postTypeStr . 's',
                'add_new' => 'Adicionar',
                'add_new_item' => 'Adicionar ' . $postTypeStr,
                'edit_item' => 'Editar ' . $postTypeStr,
                'new_item' => 'Nova ' . $postTypeStr,
                'all_items' => $postTypeStr . 's',
                'view_item' => 'Ver ' . $postTypeStr,
                'search_items' => 'Buscar ' . $postTypeStr . 's',
                'not_found' => 'Nada encontrado',
                'not_found_in_trash' => 'Nada encontrado na lixeira',
                'parent_item_colon' => '',
                'menu_name' => $postTypeStr . 's'
            );
            $this->setLabels($labels);

            $defaults = array(                
                'exclude_from_search' => false,
                'labels' => $this->getLabels(),
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                //'rewrite' => array('slug' => 'duvidas'),
                'capability_type' => 'post',
                'has_archive' => false,
                'hierarchical' => false,
                'menu_position' => null,
                //'supports' => array('title','thumbnail','editor')
                'supports' => array('title', 'editor', 'thumbnail')
                    //'rewrite' => array('slug' => 'julg', 'with_front' => false)
                    //'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
            );

            $args = wp_parse_args($args, $defaults);
            $this->setArgs($args);
        }

        /**
         * Add a metabox on a post type
         * @param OriggamiWpCMB $metabox
         * @param type|array $showOn
         */
        public function addMetabox(OriggamiWpCMB $metabox,$showOn='always') {
            $metabox->connectToPostType($this,$showOn);
        }
        
        public function connectToTax(OriggamiWpTax $tax){
            $tax->setTheme($this);
            $tax->connectToPostType($this);            
        }

        /* public function registerRwMetaBox($meta_boxes){

          } */

        /**
         * 
         * @param string $value
         * @param string $iconMode Any Constant from class "OriggamiPostTypeIconMode"
         */
        public function setIcon($value, $iconMode='dashicons') {
            $args = $this->getArgs();
            switch ($iconMode) {
                case OriggamiPostTypeIconMode::DASHICONS:
                    $args['menu_icon'] = $value;
                    break;
            }
            $this->setArgs($args);
        }

        public function registerPostType() {
            register_post_type($this->getPostType(), $this->getArgs());
        }

        public function register() {
            add_action('init', array($this, 'registerPostType'));
        }

        /* private $type;

          public function __con

          public function getType() {
          return $this->type;
          }

          public function setType($type) {
          $this->type = $type;
          } */

        public function getPostType() {
            return $this->postType;
        }

        public function setPostType($postType) {
            $this->postType = $postType;
        }

        public function getArgs() {
            return $this->args;
        }

        public function setArgs($args) {
            $this->args = $args;
        }

        public function getLabels() {
            return $this->labels;
        }

        public function setLabels($labels) {
            $this->labels = $labels;
        }

        /**
         * 
         * @return OriggamiWpOopTheme
         */
        public function getTheme() {
            return $this->theme;
        }

        public function setTheme(OriggamiWpOopTheme $theme) {
            $this->theme = $theme;
        }

    }

}

if (!class_exists('OriggamiPostTypeIconMode')) {

    class OriggamiPostTypeIconMode {

        const DASHICONS = 'dashicons';

    }

}