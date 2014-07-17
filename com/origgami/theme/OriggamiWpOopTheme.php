<?php

require dirname(__FILE__) ."/../validator/OriggamiWpAdminContextValidator.php";
require dirname(__FILE__) . "/taxonomies/OriggamiWpTax.php";
require dirname(__FILE__) . "/meta_boxes/OriggamiWpCMB.php";
require dirname(__FILE__) . "/meta_boxes/origgami_wp_metaboxes/OriggamiSuperCMB.php";
require dirname(__FILE__) . "/meta_boxes/origgami_wp_metaboxes/OriggamiRwCMB.php";
require dirname(__FILE__) . "/meta_boxes/origgami_wp_metaboxes/OriggamiWebdevCMB.php";
require dirname(__FILE__) . "/post_types/OriggamiWpPostType.php";
require dirname(__FILE__) . "/../design_patterns/OriggamiWpSingleton.php";

/**
 * Description of OriggamiWpOopTheme
 *
 * @author Pablo Pacheco <pablo.pacheco@origgami.com.br>
 */
if (!class_exists('OriggamiWpOopTheme')) {


    class OriggamiWpOopTheme extends OriggamiWpSingleton {

        private $pieCssClasses = '.pie';
        private $imgResizer;
        private $hooksClass;
        private $postTypes = array();
        private $domain;
        private $scriptsManager;
        private $router;

        protected function __construct() {
            $this->handleImgResizer();
            $this->handleHooksClass();
            $this->handleScriptsManager();
            $this->handleRouter();
            add_action('after_setup_theme', array($this, 'init'));
            parent::__construct();
        }

        /**
         * Get 
         * @param string $postType
         * @return OriggamiWpPostType
         */
        public function getPostType($postType) {
            $postTypes = $this->getPostTypes();
            if (array_key_exists($postType, $postTypes)) {
                return $postTypes[$postType];
            }
            
            $nativePostType = get_post_type_object($postType);
            if ($nativePostType != null) {
                $origgamiPostType = new OriggamiWpPostType($postType, $nativePostType);                
                $this->addPostType($origgamiPostType,false);
                return $origgamiPostType;
            }else{
                return new WP_Error( 'post_type_not_found', __( "Post Type not found. Add it first or get any native post type, like 'post' or 'page'. ", $this->getDomain() ) );
            }
        }

        protected function handleRouter() {
            require dirname(__FILE__) . "/../mvc/OriggamiWpRouter.php";
            $origgamiWpRouter = new OriggamiWpRouter($this);
            $this->setRouter($origgamiWpRouter);
        }

        protected function handleScriptsManager() {
            require dirname(__FILE__) . "/OriggamiScriptsManager.php";
            $scriptsManager = new OriggamiScriptsManager();
            $this->setScriptsManager($scriptsManager);
        }

        public function addPostType(OriggamiWpPostType $postType, $registerPostType = true) {
            $postTypes = $this->getPostTypes();
            $postTypes[$postType->getPostType()] = $postType;
            $this->setPostTypes($postTypes);
            $postType->setTheme($this);
            if ($registerPostType) {
                $postType->register();
            }
        }

        private function handleHooksClass() {
            require dirname(__FILE__) . "/hooks/OriggamiWpOopThemeHooks.php";
            $hooks = new OriggamiWpOopThemeHooks($this);
            $this->setHooksClass($hooks);
        }

        protected function handleImgResizer() {
            require dirname(__FILE__) . "/../wp_img_manager/OriggamiImgResizer.php";
            $imgResizer = new OriggamiImgResizer();
            $imgResizer->setImgResizerSourceClass(OriggamiImgResizerSourceClass::MR_IMAGE_RESIZE);
            $this->imgResizer = $imgResizer;
        }

        public function init() {
            
        }

        public function addCssPie($cssClasses = '.pie') {
            $hooks = $this->getHooksClass();
            $this->setPieCssClasses($cssClasses);
            add_action('wp_head', array($hooks, 'addPie'));
        }

        public function addThumbnailsToColumns() {
            $hooks = $this->getHooksClass();
            add_filter('manage_posts_columns', array($hooks, 'mr_thumb_posts_columns'), 5);
            add_filter('manage_pages_columns', array($hooks, 'mr_thumb_posts_columns'), 5);
            add_action('manage_posts_custom_column', array($hooks, 'mr_thumb_posts_custom_columns'), 5, 2);
            add_action('manage_pages_custom_column', array($hooks, 'mr_thumb_posts_custom_columns'), 5, 2);
            add_action('admin_head', array($hooks, 'my_column_width'));
        }

        /**
         * 
         * @return OriggamiImgResizer
         */
        public function getImgResizer() {
            return $this->imgResizer;
        }

        public function getHooksClass() {
            return $this->hooksClass;
        }

        public function setHooksClass($hooksClass) {
            $this->hooksClass = $hooksClass;
        }

        public function getPieCssClasses() {
            return $this->pieCssClasses;
        }

        public function setPieCssClasses($pieCssClasses) {
            $this->pieCssClasses = $pieCssClasses;
        }

        public function getDomain() {
            return $this->domain;
        }

        public function setDomain($domain) {
            $this->domain = $domain;
        }

        /**
         * 
         * @return OriggamiScriptsManager
         */
        public function getScriptsManager() {
            return $this->scriptsManager;
        }

        public function setScriptsManager(OriggamiScriptsManager $scriptsManager) {
            $this->scriptsManager = $scriptsManager;
        }

        /**
         * 
         * @return OriggamiWpRouter
         */
        public function getRouter() {
            return $this->router;
        }

        public function setRouter(OriggamiWpRouter $router) {
            $this->router = $router;
        }
        
        public function getPostTypes() {
            return $this->postTypes;
        }

        public function setPostTypes($postTypes) {
            $this->postTypes = $postTypes;
        }

    
    }

}