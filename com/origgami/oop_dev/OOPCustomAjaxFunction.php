<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomAjaxFunction
 *
 * @author USUARIO
 */
if (!class_exists('OOPCustomAjaxFunction')) {

    class OOPCustomAjaxFunction {

        //put your code here

        private $id;
        private $public;

        public function __construct($id, $public = true) {
            $this->setID($id);
            $this->setPublic($public);
            
            add_action('init', array($this, "ajaxInit"));
            
        }
        
        public function ajaxInit(){
            $this->addAjaxFunctions($this->getPublic());
        }

        public function addAjaxFunctions($public = true) {
            add_action('wp_ajax_' . $this->getID() . '', array($this, 'ajaxFunction'));
            if ($public) {
                add_action('wp_ajax_nopriv_' . $this->getID() . '', array($this, 'ajaxFunction'));
            }

            //No js, O Ajax pode ser chamado desse jeito:
            /* jQuery.ajax({
              type: 'POST',
              url: ajaxurl,
              data:{
              'action':'getregions',
              'var1':valueA,
              'var2':valueB
              },
              success: function( response ){
              //alert(response);
              }
              }); */
        }

        public function ajaxFunction() {
            echo $this->getID() . ' function called';
            die();
        }

        public function getPublic() {
            return $this->public;
        }

        public function setPublic($value) {
            $this->public = $value;
        }

        public function getID() {
            return $this->id;
        }

        public function setID($id) {
            $this->id = $id;
        }

    }

}
?>
