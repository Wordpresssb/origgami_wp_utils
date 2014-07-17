<?php

/**
 * Description of OriggamiWebdevCMB
 *
 * Pablo Pacheco <pablo.pacheco@origgami.com.br>
 */
if (!class_exists('OriggamiWebdevCMB')) {

    class OriggamiWebdevCMB extends OriggamiWpCMB {

        private $fields;

        public function __construct($id, $title, $args = null) {
            $fields = array();
            $this->setFields($fields);
            parent::__construct($id, $title, $args);
        }

        public function register() {
            parent::register();
            remove_filter('cmb_meta_boxes', array($this, 'registerMetaBox'));
            add_filter('cmb_meta_boxes', array($this, 'registerMetaBox'));
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
                'show_names' => true,
                'fields' => $this->getFields()
            );

            $args = wp_parse_args($args, $defaults);
            parent::setArgs($args);
        }

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

        public function getFields() {
            return $this->fields;
        }

        public function setFields($fields) {
            $this->fields = $fields;
        }

    }

}
?>
