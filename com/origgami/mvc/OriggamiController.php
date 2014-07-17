<?php

/**
 * Description of OriggamiController
 *
 * Pablo Pacheco <pablo.pacheco@origgami.com.br>
 */
class OriggamiController {

    //put your code here

    public function __construct() {
        function mh_insert_before_posts($post) {
            echo '<!-- insert meaningful references HERE -->';
        }
    }
    
    public function loadModel(){
        add_action('the_post', 'mh_insert_before_posts');
    }

}

?>
