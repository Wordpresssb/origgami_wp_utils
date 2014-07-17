<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OOPShortcode
 *
 * @author USUARIO
 */
if (!class_exists('OOPShortcode')) {

    class OOPShortcode {

        //put your code here

        private $shortcodeTag;

        public function getShortcodeTag() {
            return $this->shortcodeTag;
        }

        public function setShortcodeTag($shortcodeTag) {
            $this->shortcodeTag = $shortcodeTag;
        }

        public function __construct($shortcodeTag) {
            $this->setShortcodeTag($shortcodeTag);

            add_shortcode($shortcodeTag, array($this, 'shortcodeFunction'));
        }

        public function shortcodeFunction($atts) {
            /* extract(shortcode_atts(array(
              'width' => 400,
              'height' => 200,
              ), $atts));
              return '<img src="http://lorempixel.com/' . $width . '/' . $height . '" />'; */
        }

        //add_shortcode('lorem', 'lorem_function');
    }

}
?>
