<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomTaxonomy
 *
 * @author USUARIO
 */
if (!class_exists('OOPCustomTaxonomy')) {

    class OOPCustomTaxonomy {

        //put your code here

        protected $name = "taxonomy";
        protected $objectType = array();
        protected $labels = array();

        public function __construct($taxonomyName = "taxonomy", $objectType = array('post')) {
            $this->setName($taxonomyName);
            $this->setObjectType($objectType);


            $this->addActions();
        }

        public function addActions() {
            add_action('admin_menu', array($this, 'adminMenu'));
            add_action('init', array($this, "init"));
            //remove_meta_box($custom_taxonomy_slug.'div', $custom_post_type, 'side' );
        }

        public function init() {
            
            $this->addActionsAndFilters();
            $this->addCustomTaxonomy($this->getName(), $this->getObjectType());
        }

        public function adminMenu() {
            $this->removeMetaBoxes();
        }

        public function removeMetaBoxes() {
            //remove_meta_box(CustomTaxonomies::REGION.'div', CustomPostTypes::CLIENTS, 'side' );
        }

        public function addActionsAndFilters() {
            foreach ($this->getObjectType() as $postType) {
                if ($postType != 'page') {
                    add_filter("manage_edit-" . $postType . "_columns", array($this, "manage_edit_columns"));
                    add_action('manage_' . $postType . '_posts_custom_column', array($this, 'manage_custom_columns'), 10, 2);





                    add_filter('manage_taxonomies_for_' . $postType . '_columns', array($this, 'activity_type_columns'));
                }
            }
        }

        public function activity_type_columns($taxonomies) {
            //$taxonomies['asd'] = 'tes';
            return $taxonomies;
        }

        /**
         * Adiciona uma nova Coluna
         * @param type $columns
         * @return type 
         */
        public function manage_edit_columns($columns) {
            /*$taxonomy = get_taxonomy($this->getName());
            $taxonomyName = $this->getName();
            if ($taxonomy) {
                $taxonomyName = $taxonomy->labels->singular_name;
            }

            $newColumns = array(
                $this->getName() => $taxonomyName
            );

            $joinedArrays = array_merge($columns, $newColumns);
            return $joinedArrays;
            //return $joinedArrays;*/
            return $columns;
        }

        /**
         * Customiza as linhas da nova coluna
         * @param type $column
         * @param type $post_id 
         */
        public function manage_custom_columns($column, $post_id) {

            /*if ($column == $this->getName()) {
                $term_list = wp_get_post_terms($post_id, $this->getName(), array("fields" => "names"));
                echo implode(',', $term_list);
                //echo 's.';
                //$metaValue = get_post_meta($post_id, $meta, true);
                //echo $metaValue;
            }*/
            return $column;
        }

        public function addCustomTaxonomy($taxonomyName = "taxonomy", $objectType = array('post')) {


            // Add new taxonomy, make it hierarchical (like categories)
            $labels = array(
                'name' => _x('Taxonomies', 'taxonomy general name'),
                'singular_name' => _x('Taxonomy', 'taxonomy singular name'),
                'search_items' => __('Search Taxonomies'),
                'all_items' => __('All Taxonomies'),
                'parent_item' => __('Parent Taxonomy'),
                'parent_item_colon' => __('Parent Taxonomy:'),
                'edit_item' => __('Edit Taxonomy'),
                'update_item' => __('Update Taxonomy'),
                'add_new_item' => __('Add New Taxonomy'),
                'new_item_name' => __('New Taxonomy Name'),
                'menu_name' => __('Taxonomy')
            );
            $this->setLabels($labels);

            $args = array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'show_admin_column' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'taxonomy')
            );

            register_taxonomy($taxonomyName, $objectType, $args);
        }

        /**
         * Gets the name
         */
        public function getName() {
            return $this->name;
        }

        /**
         * Sets the name
         * 
         * $val	mixed	Sets the property
         */
        public function setName($val) {
            $this->name = $val;
        }

        /**
         * Gets the objectType
         */
        public function getObjectType() {
            return $this->objectType;
        }

        /**
         * Sets the objectType
         * 
         * $val	mixed	Sets the property
         */
        public function setObjectType($val) {
            $this->objectType = $val;
        }

        /**
         * Gets the objectType
         */
        public function getLabels() {
            return $this->labels;
        }

        /**
         * Sets the objectType
         * 
         * $val	mixed	Sets the property
         */
        public function setLabels($val) {
            $this->labels = $val;
        }

    }

}
?>
