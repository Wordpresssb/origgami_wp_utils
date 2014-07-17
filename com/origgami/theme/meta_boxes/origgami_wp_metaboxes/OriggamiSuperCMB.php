<?php

/**
 * Description of OriggamiSuperCMB
 *
 * Pablo Pacheco <pablo.pacheco@origgami.com.br>
 */
if (!class_exists('OriggamiSuperCMB')) {

    class OriggamiSuperCMB extends OriggamiWpCMB {

        //put your code here

        private $fields;
        private $superCustomPostMetas = array();

        public function __construct($id, $title, $args = null) {
            $fields = array();
            $this->setFields($fields);
            parent::__construct($id, $title, $args);
        }
        
        public function connectToPostType(OriggamiWpPostType $postType, $showOn = 'always') {
            parent::connectToPostType($postType, $showOn);
            $scpms = $this->getSuperCustomPostMetas();
            $scpms[$postType->getPostType()] = new Super_Custom_Post_Meta($postType->getPostType());
            $this->setSuperCustomPostMetas($scpms);
            $this->register();
        }

        /*public function connectToPostType(OriggamiWpPostType $postType) {
            parent::connectToPostType($postType);
            $scpms = $this->getSuperCustomPostMetas();
            $scpms[$postType->getPostType()] = new Super_Custom_Post_Meta($postType->getPostType());
            $this->setSuperCustomPostMetas($scpms);
            $this->register();
        }*/

        /* public function connectToPostType(OriggamiWpPostType $postType) {
          parent::connectToPostType($postType);
          $postTypes = $this->getPostTypes();
          $this->register();
          } */

        public function register() {            
            parent::register();
            foreach ($this->getSuperCustomPostMetas() as $key => $scpm) {                    
                $scpm->add_meta_box($this->getArgs());
            }
        }

        public function setArgs($args) {
            $defaults = array(
                'id' => $this->getId(),
                'title' => __($this->getTitle(), $this->getDomain()),
                'context' => 'normal',
                'priority' => 'default',
                'fields' => $this->getFields()
            );

            $args = wp_parse_args($args, $defaults);
            parent::setArgs($args);
        }

        public function getFields() {
            return $this->fields;
        }

        public function setFields($fields) {
            $this->fields = $fields;
        }

        public function getSuperCustomPostMetas() {
            return $this->superCustomPostMetas;
        }

        public function setSuperCustomPostMetas($superCustomPostMetas) {
            $this->superCustomPostMetas = $superCustomPostMetas;
        }

    }

}
?>
