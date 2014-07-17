<?php

/**
 * Description of Thumbnail
 *
 * @author Pablo Pacheco <pablo.pacheco@origgami.com.br>
 */
if (!class_exists('OriggamiImgResizer')) {


    class OriggamiImgResizer{

        private $imgResizerSourceClass = '';

        //protected function 

        

        public function getThumbSrc($thumbArgs, $imgSourceArgs = null, $overrideImgSourceArgs = null) {
            
            $imgSourceArgsDefault = array(
                //'source_img_from'=>'thumb,src,post_meta',
                'source_img_from' => 'thumb',
                'thumb' => array('post_id' => null),
                'src' => array(
                    'src' => null,
                    'src_is_id' => false
                ),
                'post_meta' => array(
                    'post_id' => null,
                    'post_meta' => null,
                    'post_meta_is_id' => true
                ),
                'test'=>'test2'
            );
            $imgSourceArgs = wp_parse_args($imgSourceArgs, $imgSourceArgsDefault);
            
            
            

            if ($imgSourceArgs['source_img_from'] == 'thumb') {
                
                $imageID = get_post_thumbnail_id($imgSourceArgs['thumb']['post_id']);
                
                $image = wp_get_attachment_url($imageID);
               
            } else if ($imgSourceArgs['source_img_from'] == 'src') {
                if(isset($imgSourceArgs['src']['src_is_id']) && $imgSourceArgs['src']['src_is_id']){
                    $image = wp_get_attachment_url($imgSourceArgs['src']['src']);
                }else{
                    $image = $imgSourceArgs['src']['src'];
                }
            } else if ($imgSourceArgs['source_img_from'] == 'post_meta') {
                $imageInf = get_post_meta($imgSourceArgs['post_meta']['post_id'], $imgSourceArgs['post_meta']['post_meta'], true);
                if ($imgSourceArgs['post_meta']['post_meta_is_id']) {
                    $image = wp_get_attachment_url($imageInf);
                } else {
                    $image = $imageInf;
                }
            }

            $thumbArgsDefault = array(
                'width' => 300,
                'height' => 0,
                'align' => 'tl',
                'crop' => false,
            );
            $thumbArgs = wp_parse_args($thumbArgs, $thumbArgsDefault);

            //$imageSRC = bfi_thumb($image, $thumbArgs);
            $imageSRC = mr_image_resize($image, $thumbArgs['width'], $thumbArgs['height'], $thumbArgs['crop'], $thumbArgs['align'], false);            
            return $imageSRC;
        }

        public function getImgResizerSourceClass() {
            return $this->imgResizerSourceClass;
        }

        private function loadImgResizerSourceClass($imgResizerSourceClass, $requireOnce = false) {
            $fileToLoad = '';
            switch ($imgResizerSourceClass) {
                case OriggamiImgResizerSourceClass::MR_IMAGE_RESIZE:
                    if (!function_exists('mr_image_resize')) {
                        $fileToLoad = dirname(__FILE__) . "/img_resizer_classes/mr_image_resizer/mr-image-resize.php";
                    }
                    break;
            }

            if ($fileToLoad != '') {
                if ($requireOnce) {
                    require_once $fileToLoad;
                } else {
                    require $fileToLoad;
                }
            }
        }

        public function setImgResizerSourceClass($imgResizerSourceClass, $loadClass = true) {
            $this->imgResizerSourceClass = $imgResizerSourceClass;
            if ($loadClass) {

                $this->loadImgResizerSourceClass($this->imgResizerSourceClass);
            }
        }

    }

}

if (!class_exists('OriggamiImgResizerSourceClass')) {

    class OriggamiImgResizerSourceClass {

        const MR_IMAGE_RESIZE = 'mr_image_resize';
        const TIM_THUMB = 'timthumb';
        const AQUA_RESIZER = 'aqua_resizer';

    }

}
