<?php

/**
 * Description of Thumbnail
 *
 * @author Pablo Pacheco <pablo.pacheco@origgami.com.br>
 */
if (!class_exists('OriggamiThumbnail')) {


    class OriggamiThumbnail {

        //put your code here

        private static $thumbSrc;

        public static function getThumbSrc($thumbArgs, $imgSourceArgs = null) {
            $imgSourceArgsDefault = array(
                //'source_img_from'=>'thumb,src,post_meta',
                'source_img_from' => 'thumb',
                'thumb' => array('post_id' => null),
                'src' => array('src' => null),
                'post_meta' => array(
                    'post_id' => null,
                    'post_meta' => null,
                    'post_meta_is_id' => true
                )
            );
            $imgSourceArgs = wp_parse_args($imgSourceArgs, $imgSourceArgsDefault);

            if ($imgSourceArgs['source_img_from'] == 'thumb') {
                $imageID = get_post_thumbnail_id($imgSourceArgs['thumb']['post_id']);
                $image = wp_get_attachment_url($imageID);
            } else if ($imgSourceArgs['source_img_from'] == 'src') {
                $image = wp_get_attachment_url($imgSourceArgs['src']['src']);
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
                'crop'=>false,
            );
            $thumbArgs = wp_parse_args($thumbArgs, $thumbArgsDefault);
            //$imageSRC = bfi_thumb($image, $thumbArgs);
            $imageSRC = mr_image_resize($image, $thumbArgs['width'], $thumbArgs['height'], $thumbArgs['crop'], $thumbArgs['align'], false);

            return $imageSRC;
        }

    }

}
