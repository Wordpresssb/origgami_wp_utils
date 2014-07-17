<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomWidget
 *
 * @author USUARIO
 */
if (!class_exists('OOPCustomWidget')) {

    class OOPCustomWidget extends WP_Widget {

        //put your code here

        private $metas;
        

        public function __construct($id_base = false, $name = "Custom Widget", $widget_options = array(), $control_options = array()) {
            parent::__construct($id_base, $name, $widget_options, $control_options);
            add_action( 'widgets_init', array($this,'register'));            
        }

        public function register() {
            register_widget(get_class($this));
        }

        public function addMeta($metaKey) {
            $this->metas[$metaKey] = $metaKey;
        }

        /* public function getMeta(){
          return $this->metas;
          } */

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form($instance) {
            //parent::form($instance);
            $instance = wp_parse_args((array) $instance, array('title' => ''));
            $title = $instance['title'];
            ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>

            <?php
            //Imprimindo um combobox (http://justintadlock.com/archives/2009/05/26/the-complete-guide-to-creating-widgets-in-wordpress-28)
            /*
              <label for="<?php echo $this->get_field_id(self::META_SIZE); ?>">Tamanho:</label>
              <select id="<?php echo $this->get_field_id(self::META_SIZE); ?>" name="<?php echo $this->get_field_name(self::META_SIZE); ?>" class="widefat" style="width:100%;">

              foreach ($sizes as $key => $value) {
              $selectedStr="";
              if($value['id']==$instance[self::META_SIZE]){
              $selectedStr='selected="selected"';
              }
              echo '<option '.$selectedStr.' value="'.$value['id'].'">'.$value['value'].'</option>';
              }

              </select> */
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        public function update($new_instance, $old_instance) {
            //parent::update($new_instance, $old_instance);
            $instance = $old_instance;
            $instance['title'] = $new_instance['title'];




            return $instance;
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args     Widget arguments.
         * @param array $instance Saved values from database.
         */
        public function widget($args, $instance) {
            //parent::widget($args, $instance);
            extract($args, EXTR_SKIP);

            echo $before_widget;
            $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

            if (!empty($title))
                echo $before_title . $title . $after_title;

            // WIDGET CODE GOES HERE
            echo "<h1>My Custom widget!</h1>";

            echo $after_widget;
        }
        

        

    
    }

}
?>
