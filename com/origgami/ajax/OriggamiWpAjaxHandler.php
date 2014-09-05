<?php

/**
 * Description of OriggamiWpAjaxHandler
 *
 * @author Pablo Pacheco <pablo.pacheco@origgami.com.br>
 */
if (!class_exists('OriggamiWpAjaxHandler')) {

    class OriggamiWpAjaxHandler {

        private $ajaxFunctions = array();

        public function __construct() {
            //add_action('init', array($this, "ajaxInit"));
        }

        public function addAjaxFunction($id, $functionName, $accessibleOnFrontend = false, $accessibleOnAdmin = true) {
            $ajaxFunctions = $this->getAjaxFunctions();
            $ajaxFunctions[] = array('id' => $id, 'functionName' => $functionName, 'accessibleOnFrontend' => $accessibleOnFrontend, 'accessibleOnAdmin' => $accessibleOnAdmin);
            $this->setAjaxFunctions($ajaxFunctions);

            remove_action('init', array($this, "ajaxInit"));
            add_action('init', array($this, "ajaxInit"));
        }

        private function runAjaxFunction($id, $functionName, $accessibleOnFrontend = false, $accessibleOnAdmin = true) {
            //if ($accessibleOnAdmin) {
                remove_action('wp_ajax_' . $id, array($this, $functionName));
                add_action('wp_ajax_' . $id, array($this, $functionName));
                //error_log(print_r('asdasd', true));
            //}

            //if ($accessibleOnFrontend) {
                remove_action('wp_ajax_nopriv_' . $id, array($this, $functionName));
                add_action('wp_ajax_nopriv_' . $id, array($this, $functionName));
                //error_log(print_r($var, true));
            //}
        }

        public function ajaxInit() {
            $ajaxFunctions = $this->getAjaxFunctions();
            foreach ($ajaxFunctions as $ajaxFunction) {
                //error_log(print_r($ajaxFunction['id'], true));
                $this->runAjaxFunction($ajaxFunction['id'], $ajaxFunction['functionName'], $ajaxFunction['accessibleOnFrontend'], $ajaxFunction['accessibleOnAdmin']);
            }
        }

        public function getAjaxFunctions() {
            return $this->ajaxFunctions;
        }

        public function setAjaxFunctions($ajaxFunctions) {
            $this->ajaxFunctions = $ajaxFunctions;
        }

    }

}