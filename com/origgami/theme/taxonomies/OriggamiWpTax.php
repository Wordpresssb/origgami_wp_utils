<?php

/**
 * Description of OriggamiWpTax
 *
 * Pablo Pacheco <pablo.pacheco@origgami.com.br>
 */
if (!class_exists('OriggamiWpTax')) {

    class OriggamiWpTax {

        //put your code here

        private $taxonomy;
        
        private $postTypes = array();
        private $args;
        private $labels;
        private $theme;
        private $domain;
        
        public function connectToPostType(OriggamiWpPostType $postType) {
            $postTypes = $this->getPostTypes();
            $postTypes[$postType->getPostType()] = $postType;
            $this->setPostTypes($postTypes);            
            $this->setDomain($postType->getTheme()->getDomain());
            $this->register();
        }

        function __construct($taxonomy, $args=null) {
            $this->setTaxonomy($taxonomy);
            //var_dump($this);

            /* $this->taxonomy = $taxonomy;
              $this->object_type = $object_type;
              $this->args = $args; */

            // Add new taxonomy, NOT hierarchical (like tags)

            $postTypeStr = $taxonomy;

            $labels = array(
                'name' => _x($postTypeStr . 's', 'taxonomy general name'),
                'singular_name' => _x($postTypeStr, 'taxonomy singular name'),
                'search_items' => __('Buscar ' . $postTypeStr . 's'),
                'popular_items' => __($postTypeStr . 's' . ' populares'),
                'all_items' => __($postTypeStr . 's'),
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => __('Editar ' . $postTypeStr),
                'update_item' => __('Atualizar ' . $postTypeStr),
                'add_new_item' => __('Adicionar ' . $postTypeStr),
                'new_item_name' => __('Novo ' . $postTypeStr),
                'separate_items_with_commas' => __('Separar ' . $postTypeStr . 's por vírgulas'),
                'add_or_remove_items' => __('Adiciona ou remove ' . $postTypeStr . 's'),
                'choose_from_most_used' => __('Escolha um ' . $postTypeStr . ' dentre os mais usados'),
                'not_found' => __('Nada encontrado'),
                'menu_name' => __($postTypeStr . 's'),
            );
            $this->setLabels($labels);

            $defaults = array(
                'hierarchical' => true,
                'public'=>true,
                'labels' => $this->getLabels(),
                'show_ui' => true,
                'show_admin_column' => true,
                'update_count_callback' => '_update_post_term_count',
                'query_var' => false,
                    //'rewrite' => array('slug' => 'writer'),
            );

            $args = wp_parse_args($args, $defaults);
            $this->setArgs($args);
        }

        public function getTaxonomy() {
            return $this->taxonomy;
        }

        public function register() {            
            remove_filter('init', array($this, 'registerTaxonomy'));
            add_action( 'init', array($this,'registerTaxonomy'));
        }
        
        public function registerTaxonomy(){
            register_taxonomy($this->getTaxonomy(), array_keys($this->getPostTypes()), $this->getArgs() );
        }        

        public function getArgs() {
            return $this->args;
        }

        public function setTaxonomy($taxonomy) {
            $this->taxonomy = $taxonomy;
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
        
        public function getPostTypes() {
            return $this->postTypes;
        }

        public function setPostTypes($postTypes) {
            $this->postTypes = $postTypes;
        }
        
        public function getTheme() {
            return $this->theme;
        }

        public function setTheme($theme) {
            $this->theme = $theme;
        }

        public function getDomain() {
            return $this->domain;
        }

        public function setDomain($domain) {
            $this->domain = $domain;
        }

        
    }

}
?>
