<?php
if (!class_exists('OOPWordpressTheme')) {

    class OOPWordpressTheme {

        protected $postTypes;

        public function __construct() {
            $this->createLogFunction();
        }

        protected function addThumbnailsToColumns() {
            if (class_exists('BFI_Thumb_1_3')) {
                add_filter('manage_posts_columns', 'posts_columns', 5);
                add_filter('manage_pages_columns', 'posts_columns', 5);
                add_action('manage_posts_custom_column', 'posts_custom_columns', 5, 2);
                add_action('manage_pages_custom_column', 'posts_custom_columns', 5, 2);
                add_action('admin_head', 'my_column_width');
            }else{                
                error_log('Missing library "BFI Thumb" for addThumbnailsToColumns() can work');
            }

            function my_column_width() {
                echo
                '
                    <style type="text/css">
                        .column-thumbnail { width:90px}
                    </style>
                ';
            }

            function posts_columns($columns) {
                $array1 = array('thumbnail' => __('Thumbnail'));
                $resulting_array = $columns + $array1;
                return $resulting_array;
            }

            function posts_custom_columns($column_name, $id) {
                if ($column_name === 'thumbnail') {
                    if (has_post_thumbnail($id)) {
                        $imageID = get_post_thumbnail_id();
                        $image = wp_get_attachment_url($imageID);
                        $thumbParams = array('width' => 80);
                        $imageSRC = bfi_thumb($image, $thumbParams);

                        echo '<img src="' . $imageSRC . '"></a>';
                        //echo the_post_thumbnail('thumbnail');
                    }
                }
            }

        }

        protected function addCustomPostType($cptID, $cpt) {
            if (!$this->postTypes) {
                !$this->postTypes = array();
            }
            $this->postTypes[$cptID] = $cpt;
            return $this->postTypes;
        }

        protected function getCustomPostType($cptID) {
            return $this->postTypes[$cptID];
        }

        protected function addCssPie() {

            function addPie() {
                ?>
                <!-- child theme hack for versions of IE 8 or less -->
                <!--[if lt IE 10]>
                <style type="text/css">
                .pie{
                    behavior: url("<?php echo get_stylesheet_directory_uri() . '/pie/PIE.php'; ?>");
                    position: relative;
                    zoom: 1;
                }
                </style>
                <![endif]-->
                <?php
            }

            add_action('wp_head', 'addPie');
        }

        protected function createLogFunction() {
            if (!function_exists('_log')) {

                function _log($message) {
                    if (WP_DEBUG === true) {
                        if (is_array($message) || is_object($message)) {
                            error_log(print_r($message, true));
                        } else {
                            error_log($message);
                        }
                    }
                }

            }
        }

    }

}
?>