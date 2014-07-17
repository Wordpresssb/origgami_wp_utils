<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OOPScriptsLoader
 *
 * @author USUARIO
 */
if (!class_exists('OriggamiScriptsManager')) {

    class OriggamiScriptsManager {

        //put your code here

        public function __construct() {
            add_action('wp_enqueue_scripts', array($this, 'loadFrontEndJsAndCSS'));
            add_action('admin_enqueue_scripts', array($this, 'loadAdminJsAndCSS'));
        }

        /* protected function __construct() {
          parent::__construct();
          add_action('wp_enqueue_scripts', array($this, 'loadFrontEndJsAndCSS'));
          add_action('admin_enqueue_scripts', array($this, 'loadAdminJsAndCSS'));
          } */

        public function loadFrontendScript($methodName, $priority = 10) {
            remove_action('wp_enqueue_scripts', array($this, $methodName));
            add_action('wp_enqueue_scripts', array($this, $methodName), $priority);
        }

        public function loadAdminScript($methodName, $priority = 10) {
            remove_action('admin_enqueue_scripts', array($this, $methodName));
            add_action('admin_enqueue_scripts', array($this, $methodName));
        }

        public function loadFrontEndJsAndCSS() {
            /* wp_register_style( 'frontend_css', get_template_directory_uri() . '/css/frontend.css',array());
              wp_enqueue_style( 'frontend_css' );

              wp_register_script( 'frontend_js', get_template_directory_uri().'/js/frontend.js',array('jquery'));
              wp_enqueue_script( 'frontend_js' ); */



            //Remove Google Parent theme fonts
            /* wp_dequeue_style( 'twentytwelve-fonts' );

              //Remove Native Child theme
              wp_deregister_style('twentytwelve-style');
              wp_dequeue_style( 'twentytwelve-style' );

              //Add Parent theme
              wp_register_style( 'twentytwelve-parent', get_template_directory_uri().'/style.css',array());
              wp_enqueue_style( 'twentytwelve-parent' );

              //Add Custom Child tieme
              wp_register_style( 'frontend_css', get_stylesheet_directory_uri() . '/css/frontend.css',array('twentytwelve-parent'));
              wp_enqueue_style( 'frontend_css' );

              wp_register_style( 'ie7', get_bloginfo('stylesheet_directory').'/css/ie7.css', false);
              $GLOBALS['wp_styles']->add_data( 'ie7', 'conditional', 'lt IE 8' );
              wp_enqueue_style( 'ie7' ); */
        }

        public function loadAdminJsAndCSS($hook) {
            /* wp_register_style( 'admin_css', get_template_directory_uri() . '/css/admin.css',array());
              wp_enqueue_style( 'admin_css' );

              wp_register_script( 'admin_js', get_template_directory_uri().'/js/admin.js',array('jquery'));
              wp_enqueue_script( 'admin_js' ); */
        }

    }

}
?>
