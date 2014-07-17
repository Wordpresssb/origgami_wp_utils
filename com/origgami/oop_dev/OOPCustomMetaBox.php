<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomMetaBox
 *
 * @author USUARIO
 */
if (!class_exists('OOPCustomMetaBox')) {


    class OOPCustomMetaBox {

        //put your code here

        private $id;
        private $title;
        private $postTypes=array();
        private $metas;
        private $metasArray;

        public function __construct($id = "my_metabox", $title = "My MetaBox Title", $metas = array('meta1' => '_meta1'), $postTypesArr = array('post,page')) {
            $this->setId($id);
            $this->setTitle($title);
            $this->setPostTypes($postTypesArr);
            $this->setMetas($metas);

            $this->addActionsAndFilters();
        }
        
        public function admin_menu(){
            $this->addCustomMetaBoxes();
        }
        
        public function loadAdminCMBScripts($pagenow,$typenow){
            //wp_register_script( 'maskedinput', get_stylesheet_directory_uri().'/js/maskedinput.min.js',array('jquery'));
            //wp_enqueue_script( 'maskedinput' );
        }
        
        public function admin_enqueue_scripts($hook){            
            $this->loadAminCMBScriptsCaseThisPostIsCMBRegistered();           
        }
        
        protected function loadAminCMBScriptsCaseThisPostIsCMBRegistered(){
            global $pagenow, $typenow;
            $typenow = $this->getTypeNow();
            
            if($this->isPostRegisteredForThisCMB($pagenow, $typenow)){
                $this->loadAdminCMBScripts($pagenow, $typenow);
            }
        }

        protected function getTypeNow($post=null) {
            global $typenow;
            if (empty($typenow) && !empty($_GET['post'])) {
                if($post==null){
                    $post = get_post($_GET['post']);
                }                
                $typenow = $post->post_type;
            } 
            return $typenow;
        }


        protected function isPostRegisteredForThisCMB($pagenow,$typenow){
            $postRegistered = false;
            if(is_admin() && $pagenow=='post-new.php' || $pagenow=='post.php'){
                $postTypes = $this->getPostTypes();
                if(is_array($postTypes)){
                    foreach ($postTypes as $i => $postType) {
                        if (is_numeric($i)) {
                            if($postType==$typenow){
                                $postRegistered=true;
                            }                            
                        }else{
                            if ($i == 'page') {
                                if('page'==$typenow){
                                    $postRegistered=true;
                                }                                
                            }
                        }
                    }
                }                
            }    
            return $postRegistered;
        }
        

        public function addActionsAndFilters() {
            add_action( 'admin_enqueue_scripts', array($this,'admin_enqueue_scripts') );
            add_action('admin_menu', array($this,'admin_menu'));
            add_action('save_post', array($this, 'save'));

            /*
              add_filter( 'manage_edit-apartamento_sortable_columns', array($this,'apartamento_column_register_sortable'));
              add_filter( 'request', array($this,'fakeid_column_orderby')); */

            $postTypes = $this->getPostTypes();
            if(is_array($postTypes)){
                
                foreach ($postTypes as $i => $postType) {
                    if (is_numeric($i)) {
                        add_filter("manage_edit-" . $postType . "_columns", array($this, "manage_edit_columns"));
                        if ($postType == 'page') {
                            add_action('manage_' . $postType . '_pages_custom_column', array($this, 'manage_custom_columns'), 10, 2);
                        } else {
                            add_action('manage_' . $postType . '_posts_custom_column', array($this, 'manage_custom_columns'), 10, 2);
                        }
                    } else {
                        if ($i == 'page') {

                        }
                    }
                }
                
            }
            
        }

        /**
         * Adiciona uma nova Coluna
         * @param type $columns
         * @return type 
         */
        public function manage_edit_columns($columns) {
            $newColumns = array();
            foreach ($this->getMetas() as $i => $meta) {
                $newColumns[$i] = $meta;
            }
            $joinedArrays = array_merge($columns, $newColumns);
            return $joinedArrays;
        }

        /**
         * Customiza as linhas da nova coluna
         * @param type $column
         * @param type $post_id 
         */
        public function manage_custom_columns($column, $post_id) {
            //_log('asdasd');
            foreach ($this->getMetas() as $i => $meta) {
                if ($column == $i) {
                    $metaValue = get_post_meta($post_id, $i, true);
                    echo $metaValue;
                }
            }
        }

        public function canSave($post_id) {
            
            //_log(print_r($_POST,true));

            // verify if this is an auto save routine. 
            // If it is our form has not been submitted, so we dont want to do anything
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
                return;


            $postStatus = get_post_status($post_id);
            if ($postStatus == 'trash' or $postStatus == 'auto-draft') {
                return;
            }            

            // verify this came from the our screen and with proper authorization,
            // because save_post can be triggered at other times

            if(isset($_POST[$this->getId()])){
                if (!wp_verify_nonce($_POST[$this->getId()], $this->getId()))
                    return;
            }            

            $postTypes = $this->getPostTypes();
            foreach ($postTypes as $i => $postType) {
                if (is_numeric($i)) {

                    // Check permissions
                    if ($postType == $_POST['post_type']) {
                        if ('page' == $_POST['post_type']) {
                            if (!current_user_can('edit_page', $post_id))
                                return;
                        }
                        else {
                            if (!current_user_can('edit_post', $post_id))
                                return;
                        }
                    }
                }else {
                    if ($i == 'page') {
                        // Check permissions
                        if ($i == $_POST['post_type']) {
                            if (!current_user_can('edit_page', $post_id))
                                return;

                            $template = $postTypes[$i];
                            $template_file = get_post_meta($post_id, '_wp_page_template', TRUE);

                            if ($template_file != $template || $template_file == '') {
                                return;
                            }
                        }
                    }
                }
            }

            return true;
        }

        public function save($post_id) {
            
            if ($this->canSave($post_id)) {
                
                if(is_array($this->getMetas()) && count($this->getMetas()>0)){
                    foreach ($this->getMetas() as $metaIndex => $meta) {
                        //update_post_meta($post_id, $meta, $_POST[$meta]);
                        
                        if(isset($_POST[$metaIndex])){
                            update_post_meta($post_id, $metaIndex, $_POST[$metaIndex]);
                        }
                        
                    }
                }
                
            }
        }

        public function addCustomMetaBoxes($context = "normal", $priority = "low") {
            $postTypes = $this->getPostTypes();
            if(is_array($postTypes)){
                foreach ($postTypes as $i => $v) {
                    if (is_numeric($i)) {
                        add_meta_box($this->getId() . '-meta-box', $this->getTitle(), array($this, "showMetaBox"), $v, $context, $priority);
                    } else {
                        if ($i == 'page') {
                            $template = $postTypes[$i];
                            $post_id = $this->getPostID();
                            $template_file = get_post_meta($post_id, '_wp_page_template', TRUE);
                            if ($template_file == $template) {
                                add_meta_box($this->getId() . '-meta-box', $this->getTitle(), array($this, "showMetaBox"), $i, $context, $priority);
                            }
                        }
                    }
                }
            }
        }

        public function getPostID() {
            if (isset($_GET['post'])) {
                $post_id = $_GET['post'];
            } else if (isset($_POST['post_ID'])) {
                $post_id = $_POST['post_ID'];
            }

            if (!isset($post_id) || $post_id == null || $post_id == '') {
                global $post;
                if ($post) {
                    $post_id = $post->ID;
                } else {
                    $post_id = false;
                }
            }
            return $post_id;
        }

        public function showMetaBox($post) {
            wp_nonce_field($this->getId(), $this->getId());
            foreach ($this->getMetas() as $metaIndex => $meta) {
                $metaValue = get_post_meta($post->ID, $metaIndex, true);
                
                switch($metaIndex){
                    case 'some_meta':
                    break;
                    default:
                        echo '<label for="' . $metaIndex . '">';
                        echo $meta;
                        //_e("Description for this field", 'myplugin_textdomain' );
                        echo '</label><br /> ';
                        echo '<input style="width:99%" type="text" id="' . $metaIndex . '" name="' . $metaIndex . '" value="' . $metaValue . '" />';
                        echo "<br /><br />";
                    break;
                }
            }
        }

        /**
         * Gets the id
         */
        public function getId() {
            return $this->id;
        }

        /**
         * Sets the id
         * 
         * $val	mixed	Sets the property
         */
        public function setId($val) {
            $this->id = $val;
        }

        /**
         * Gets the title
         */
        public function getTitle() {
            return $this->title;
        }

        /**
         * Sets the title
         * 
         * $val	mixed	Sets the property
         */
        public function setTitle($val) {
            $this->title = $val;
        }

        /**
         * Gets the postTypes
         */
        public function getPostTypes() {
            return $this->postTypes;
        }

        /**
         * Sets the postTypes
         * 
         * $val	mixed	Sets the property
         */
        public function setPostTypes($val) {
            $this->postTypes = $val;
        }

        /**
         * Gets the metas
         */
        public function getMetas() {
            return $this->metas;
        }

        /**
         * Sets the metas
         * 
         * $val	mixed	Sets the property
         */
        public function setMetas($val) {
            $this->metas = $val;
        }

        /**
         * Gets the metas
         */
        public function getMetasArray() {
            //$this->metasArray = array_keys($this->getMetas());
            if (count($this->metasArray) == 0) {
                foreach ($this->getMetas() as $key => $value) {
                    $this->metasArray[] = $value;
                }
            }

            return $this->metasArray;
        }

    }

}
?>
