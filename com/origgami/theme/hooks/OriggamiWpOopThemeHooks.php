<?php
/**
 * Description of OriggamiWpOopThemeHooks
 *
 * @author Pablo Pacheco <pablo.pacheco@origgami.com.br>
 */
if (!class_exists('OriggamiWpOopThemeHooks')) {

    class OriggamiWpOopThemeHooks {

        private $theme;

        public function __construct(OriggamiWpOopTheme $theme) {
            $this->theme = $theme;
        }

        public function addPie() {
            ?>
            <!-- child theme hack for versions of IE 8 or less -->
            <!--[if lt IE 10]>
            <style type="text/css">
            <?php echo $this->getTheme()->getPieCssClasses(); ?>{
                behavior: url("<?php echo get_stylesheet_directory_uri() . '/pie/PIE.php'; ?>");
                position: relative;
                zoom: 1;
            }
            </style>
            <![endif]-->
            <?php
        }

        public function my_column_width() {
            echo
            '
                    <style type="text/css">
                        .column-thumbnail { width:90px}
                    </style>
                ';
        }

        public function mr_thumb_posts_columns($columns) {
            $array1 = array('thumbnail' => __('Thumbnail'));
            $resulting_array = $columns + $array1;
            return $resulting_array;
        }

        public function mr_thumb_posts_custom_columns($column_name, $id) {
            if ($column_name === 'thumbnail') {
                if (has_post_thumbnail($id)) {
                    $imageSrc = $this->getTheme()->getImgResizer()->getThumbSrc(array('width' => 80), array('thumb' => array('post_id' => $id)));
                    echo '<img src="' . $imageSrc . '"></a>';
                }
            }
        }

        /**
         * 
         * @return OriggamiWpOOpThemeHooks
         */
        public function getTheme() {
            return $this->theme;
        }

        public function setTheme($theme) {
            $this->theme = $theme;
        }

    }

}