<?php

if (!class_exists("OriggamiWpSingleton")) {

    class OriggamiWpSingleton {

        //private static $instance = null;

        /**
         * Returns the *Singleton* instance of this class.
         *
         * @staticvar Singleton $instance The *Singleton* instances of this class.
         *
         * @return this
         */
        /* public static function getInstance() {
          if (null == self::$instance) {
          self::$instance = new self;
          }

          return self::$instance;
          } */

        private static $_instances = array();

        /**
         * Returns the *Singleton* instance of this class.
         *
         * @staticvar Singleton $instance The *Singleton* instances of this class.
         *
         * @return this
         */
        public static function getInstance() {
            $class = get_called_class();
            if (!isset(self::$_instances[$class])) {
                self::$_instances[$class] = new $class();
            }
            return self::$_instances[$class];
        }

        /**
         * Protected constructor to prevent creating a new instance of the
         * *Singleton* via the `new` operator from outside of this class.
         */
        protected function __construct() {
            //error_log('asdasd');
            //new WP_Error('broke', __("I've fallen and can't get up", "my_textdomain"));
            //die('asdasd');
            //throw new Exception('Division by zero.');
        }

        /**
         * Private clone method to prevent cloning of the instance of the
         * *Singleton* instance.
         *
         * @return void
         */
        private function __clone() {
            
        }

        /**
         * Private unserialize method to prevent unserializing of the *Singleton*
         * instance.
         *
         * @return void
         */
        private function __wakeup() {
            
        }

    }

}