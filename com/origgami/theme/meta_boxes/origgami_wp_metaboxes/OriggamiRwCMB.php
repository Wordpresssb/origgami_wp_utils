<?php

/**
 * Description of OriggamiRwMetabox
 *
 * @author Pablo Pacheco <pablo.pacheco@origgami.com.br>
 */
if (!class_exists('OriggamiRwCMB')) {

    class OriggamiRwCMB extends OriggamiWpCMB {

        private $fields;

        public function __construct($id, $title, $args = null) {
            $fields = array();
            $this->setFields($fields);
            parent::__construct($id, $title, $args);
        }

        public function register() {
            parent::register();
            remove_filter('rwmb_meta_boxes', array($this, 'registerMetaBox'));
            add_filter('rwmb_meta_boxes', array($this, 'registerMetaBox'));
        }

        public function connectToPostType(OriggamiWpPostType $postType, $showOn = 'always') {
            parent::connectToPostType($postType, $showOn);
            $this->register();
        }

        /* public function connectToPostType(OriggamiWpPostType $postType) {
          parent::connectToPostType($postType);
          $postTypes = $this->getPostTypes();
          $args = $this->getArgs();
          $defaults = array(
          'pages' => array_keys($postTypes),
          );
          $args = wp_parse_args($args, $defaults);
          $this->setArgs($args);

          $this->register();
          } */

        public function setArgs($args) {
            $postTypes = $this->getPostTypes();

            $defaults = array(
                'id' => $this->getId(),
                'title' => __($this->getTitle(), $this->getDomain()),
                'context' => 'normal',
                'priority' => 'default',
                'autosave' => false,
                'fields' => $this->getFields()
            );

            $args = wp_parse_args($args, $defaults);
            parent::setArgs($args);
        }

        /*public function setPostTypeShowOnRelation($postTypeShowOnRelation) {          
            foreach ($postTypeShowOnRelation as $key => $relation) {
                if (is_array($relation)) {                    
                    if (isset($relation['key'])) {
                        //error_log('asdasdasdaasas');
                        $postTypeShowOnRelation[$key]['template'] = $postTypeShowOnRelation[$key]['key'];
                        $postTypeShowOnRelation[$key]['template'] = $postTypeShowOnRelation[$key]['value'];
                        unset($postTypeShowOnRelation[$key]['key']);
                        unset($postTypeShowOnRelation[$key]['value']);
                    }
                }
            }
            parent::setPostTypeShowOnRelation($postTypeShowOnRelation);
        }*/
        
        public function registerMetaBox($meta_boxes) {            
            $args = $this->getArgs();
            $ptShowOnRelation = $this->getPostTypeShowOnRelation();            
            foreach ($this->getPostTypes() as $key => $postType) {
                if (isset($ptShowOnRelation[$key]) && is_array($ptShowOnRelation[$key])) {
                    $isContextValid = OriggamiWpAdminContextValidator::isValid($ptShowOnRelation[$key]);
                    
                    if($isContextValid){                       
                        $args['pages'] = array($key);
                        $meta_boxes[] = $args;
                    }
                }else{
                    $args['pages'] = array($key);
                    $meta_boxes[] = $args;
                }
                
            }
            return $meta_boxes;
        }

        /*public function registerMetaBox($meta_boxes) {
            $args = $this->getArgs();
            $ptShowOnRelation = $this->getPostTypeShowOnRelation();
            //error_log(print_r($ptShowOnRelation, true));
            foreach ($this->getPostTypes() as $key => $postType) {
                //error_log(print_r($key, true));
                if (is_array($ptShowOnRelation[$key])) {
                    //error_log(print_r($ptShowOnRelation[$key], true));
                    //error_log(print_r(array_keys($this->getPostTypes()),true));
                    $args['only_on'] = $ptShowOnRelation[$key];
                }

                $args['pages'] = array($key);
                $meta_boxes[] = $args;
            }
            return $meta_boxes;
        }*/

        public function getFields() {
            return $this->fields;
        }

        public function setFields($fields) {
            $this->fields = $fields;
        }

    }

}