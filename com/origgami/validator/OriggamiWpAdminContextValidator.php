<?php

/**
 * Description of OriggamiWpContextValidator
 *
 * Pablo Pacheco <pablo.pacheco@origgami.com.br>
 */
if (!class_exists('OriggamiWpAdminContextValidator')) {

    class OriggamiWpAdminContextValidator {
        //put your code here

        /**
         * 
         * @param array $context
         * @param int $objectID
         */
        public static function isValid($context, $objectID = null) {
            // Include in back-end only
            if (!defined('WP_ADMIN') || !WP_ADMIN) {                
                return false;
            }

            // Always include for ajax
            if (defined('DOING_AJAX') && DOING_AJAX) {
                return true;
            }

            $defaults = array(
                'id' => array(),
                'page-template' => array()
            );
            $context = wp_parse_args($context, $defaults);

            if (!$objectID) {

                if (isset($_GET['post']))
                    $objectID = $_GET['post'];
                elseif (isset($_POST['post_ID']))
                    $objectID = $_POST['post_ID'];

                if (!$objectID) {
                    global $post;
                    
                    if($post){
                        $objectID = $post->ID;
                    }
                }

                if (!$objectID) {
                    return false;
                }

                if ('page' != get_post_type($objectID))
                    return false;
            }

            $pageTemplatesToValidate = $context['page-template'];
            if (count($pageTemplatesToValidate) > 0) {
                $current_template = get_post_meta($objectID, '_wp_page_template', true);
                foreach ($pageTemplatesToValidate as $key => $pageTemplate) {
                    if ($current_template == $pageTemplate) {
                        return true;
                        break;
                    }
                }
            }
        }

    }

}
?>
