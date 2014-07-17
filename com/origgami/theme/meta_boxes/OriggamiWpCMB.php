<?php

/**
 * Description of OriggamiWpMetabox
 *
 * @author Pablo Pacheco <pablo.pacheco@origgami.com.br>
 */
if (!class_exists('OriggamiWpCMB')) {

    class OriggamiWpCMB {

        private $id;
        private $title;
        private $args;
        private $postTypes = array();
        private $domain='cmb';
        private $postTypeShowOnRelation=array();

        public function register() {
            
        }

        /**
         * 
         * @param OriggamiWpPostType $postType
         * @param string|array $showOn
         */
        public function connectToPostType(OriggamiWpPostType $postType,$showOn='always') {
            $postTypes = $this->getPostTypes();
            $postTypes[$postType->getPostType()] = $postType;
            $postTypeShowOnRelation[$postType->getPostType()]=$showOn;
            $this->setPostTypeShowOnRelation($postTypeShowOnRelation);
            $this->setPostTypes($postTypes);               
            $this->setDomain($postType->getTheme()->getDomain());
        }

        function __construct($id, $title, $args = null) {
            $this->setId($id);
            $this->setTitle($title);
            $this->setArgs($args);
        }

        /* public function register(){

          } */

        public function getId() {
            return $this->id;
        }

        public function getTitle() {
            return $this->title;
        }

        public function getArgs() {
            return $this->args;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setTitle($title) {
            $this->title = $title;
        }

        public function setArgs($args) {
            $this->args = $args;
        }

        public function getPostTypes() {
            return $this->postTypes;
        }

        public function setPostTypes($postTypes) {
            $this->postTypes = $postTypes;
        }
        
        public function getDomain() {
            return $this->domain;
        }

        public function setDomain($domain) {
            $this->domain = $domain;
        }
        
        public function getPostTypeShowOnRelation() {
            return $this->postTypeShowOnRelation;
        }

        public function setPostTypeShowOnRelation($postTypeShowOnRelation) {
            $this->postTypeShowOnRelation = $postTypeShowOnRelation;
        }

    
    
    }

}