<?php

/**
 * Description of OriggamiSuperCPT
 *
 * @author Pablo Pacheco <pablo.pacheco@origgami.com.br>
 */
class OriggamiSuperCPT extends Super_Custom_Post_Type {

    //put your code here

    public function add_meta_box($attr = array()) {
        if (isset($attr['page_template'])) {
            if (isset($_GET['post']))
                $post_id = $_GET['post'];
            elseif (isset($_POST['post_ID']))
                $post_id = $_POST['post_ID'];
            else
                $post_id = get_the_ID();

            if (!$post_id)
                return;

            if ('page' != get_post_type($post_id))
                return;
            
            if ($attr['page_template'] == get_post_meta($post_id, '_wp_page_template', true)) {
                parent::add_meta_box($attr);
            }
        }else{
            parent::add_meta_box($attr);
        }
    }

}
