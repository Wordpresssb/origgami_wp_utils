<?php

/**
 * Description of OriggamiWpView
 *
 * Pablo Pacheco <pablo.pacheco@origgami.com.br>
 */
if (!class_exists('OriggamiWpView')) {

    class OriggamiWpView {

        //put your code here

        private $template;
        private $scriptsManager;

        public function __construct(OriggamiScriptsManager $scriptsManager) {
            $this->scriptsManager = $scriptsManager;
            //$scriptsManager = new ScriptsManager();
        }

        public function loadTemplate($template) {
            $this->template = $template;
            add_filter('template_include', array($this, 'onTemplateInclude'), 10, 1);
        }

        public function onTemplateInclude($template) {
            if ($this->template) {
                $template = $this->template;
            }
            return $template;
        }

        /**
         * 
         * @return OriggamiScriptsManager
         */
        public function getScriptsManager() {
            return $this->scriptsManager;
        }

    }

}
?>
