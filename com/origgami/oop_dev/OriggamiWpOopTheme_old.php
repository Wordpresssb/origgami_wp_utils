<?php
/**
 * Description of OriggamiWpOopTheme
 *
 * @author Pablo Pacheco <pablo.pacheco@origgami.com.br>
 */
if (!class_exists('OriggamiWpOopThemeOld')) {



    class OriggamiWpOopThemeOld {

        private $pieCssClasses = '.pie';

        //Define autoloader 
        function __autoload($className) {
            error_log('sss');
            if (file_exists($className . '.php')) {
                require $className . '.php';
                return true;
            }
            return false;
        }

        public function __construct() {
            error_log('ccccc');
            add_action('after_setup_theme', array($this, 'init'));
        }

        public function init() {
            
        }

        public function addCssPie($cssClasses = '.pie') {
            $this->pieCssClasses = $cssClasses;
            add_action('wp_head', array($this,'addPie'));
        }

        public function addPie() {
            ?>
            <!-- child theme hack for versions of IE 8 or less -->
            <!--[if lt IE 10]>
            <style type="text/css">
            <?php echo $this->pieCssClasses; ?>{
                behavior: url("<?php echo get_stylesheet_directory_uri() . '/pie/PIE.php'; ?>");
                position: relative;
                zoom: 1;
            }
            </style>
            <![endif]-->
            <?php
        }

        public function addThumbnailsToColumns() {
            if (function_exists('mr_image_resize')) {
                add_filter('manage_posts_columns', 'mr_thumb_posts_columns', 5);
                add_filter('manage_pages_columns', 'mr_thumb_posts_columns', 5);
                add_action('manage_posts_custom_column', 'mr_thumb_posts_custom_columns', 5, 2);
                add_action('manage_pages_custom_column', 'mr_thumb_posts_custom_columns', 5, 2);
                add_action('admin_head', 'my_column_width');
            } else {
                error_log('Missing library "mr-image-resize.php" so addThumbnailsToColumns() can work');
            }

            function my_column_width() {
                echo
                '
                    <style type="text/css">
                        .column-thumbnail { width:90px}
                    </style>
                ';
            }

            function mr_thumb_posts_columns($columns) {
                $array1 = array('thumbnail' => __('Thumbnail'));
                $resulting_array = $columns + $array1;
                return $resulting_array;
            }

            function mr_thumb_posts_custom_columns($column_name, $id) {
                if ($column_name === 'thumbnail') {
                    if (has_post_thumbnail($id)) {

                        $imageSRC = OriggamiThumbnail::getThumbSrc(array('width' => 80));

                        echo '<img src="' . $imageSRC . '"></a>';
                        //echo the_post_thumbnail('thumbnail');
                    }
                }
            }

        }

    }

}