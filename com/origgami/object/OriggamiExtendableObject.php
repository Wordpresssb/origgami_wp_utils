<?php

/**
 * Description of ExtendableObject
 *
 * @author Pablo Pacheco <pablo.pacheco@origgami.com.br>
 */
if (!class_exists('OriggamiExtendableObject')) {

    class OriggamiExtendableObject {

        //put your code here

        protected $_value_object;

        public static function factory($value_object = NULL) {
            $class = get_called_class();
            $newObject = new $class($value_object);
            foreach (get_object_vars($value_object) as $key => $value) {
                $newObject->$key = $value;
            }
            return $newObject;
        }

    }

}
