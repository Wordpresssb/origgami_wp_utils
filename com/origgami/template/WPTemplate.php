<?php

/**
 * Description of Template
 *
 * @author USUARIO
 */
if(!class_exists('WPTemplate')) {
    class WPTemplate {
        //put your code here

        public static function getTemplatePart($slug, $name=null,$output=true){
            if($output){
                get_template_part($slug, $name);
            }else{
                ob_start();
                get_template_part($slug, $name);
                $var = ob_get_contents();
                ob_end_clean();
                return $var;
            }
        }

    }
}

?>
