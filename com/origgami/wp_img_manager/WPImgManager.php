<?php

//require_once dirname(__FILE__)."/../../OOPDevConfig.php";


/**
 * Gerencia as imagens do wordpress. Redimensiona e(ou) pega uma imagem padrao caso uma nao seja encontrada
 *
 * @author USUARIO
 */
class WPImgManager {
    //put your code here
    
     /**
     * Clase que funciona como um media dispatcher 
     */
    public static $timthumbFile='timthumb.php';
    
    /**
     * Pasta padrao onde ficam as imagens do tema 
     */
    public static $imagesDirectory="images";
    
    /**
     * Nome do arquivo que funciona como sendo um padrão pra quando uma imagem não e encontrada 
     */   
    public static $imgNotFoundFileName="not_found_img.jpg";
    
    /**
     * pasta onde esta localizada a biblioteca do 'WPImgManager" a partir do diretorio do tema
     * @var type 
     */
    public static $wpImgManagerFolder='libs/origgami_wp_utils/com/origgami/wp_img_manager';
    
    
    /**
     *
     * @param type $postID
     * @param type $imageSize
     * @param type $thumbID ID do thumbnail. OBS: Apenas se o plugin MultiPostThumbnails estiver habilitado!
     * @param type $imgNotFoundURL
     * @return type 
     */
    public static function getPostThumbURL($postID,$imageSize='full',$thumbID='',$imgNotFoundURL=''){
        if($thumbID!=''){
            $postType = get_post_type($postID);
            if (class_exists('MultiPostThumbnails')) {
                $thumb = MultiPostThumbnails::get_post_thumbnail_url($postType, $thumbID,$postID);
            }
        }
        if(!isset($thumb)){
            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($postID), $imageSize );
            $thumbURL = $thumb['0'];
        }else{
            $thumbURL = $thumb;
        }        
        
        if($thumbURL==null || $thumbURL==''){
            if($imgNotFoundURL!=''){
                $thumbURL = $imgNotFoundURL;
            }else{
                $thumbURL = self::getImgNotFoundURL();
            }
        }
        return $thumbURL;
    }
    
    public static function setTimthumbFileCacheDirectory($directory=''){
        //FILE_CACHE_DIRECTORY = wp_upload_dir().'/timthumb/';
        //if( defined('FILE_CACHE_DIRECTORY') ) 		define ('FILE_CACHE_DIRECTORY', $directory);	
        //define ('FILE_CACHE_DIRECTORY', '.test');				// Directory where images are cached. Left blank it will use the system temporary directory (which is better for security)
    }
    
    /**
     * 
     * @param type $src
     * @param type $width
     * @param type $height
     * @param type $cropAndScale 0,1,2,3
     * @param type $alignment c, t, l, r, b, tl, tr, bl, br
     * @param type $quality 0-100
     * @param type $canvasColor
     * @param type $transparency 0,1
     * @param type $params
     * @return type 
     */
    public static function getResizedImgURL($src,$width='250',$height='250',$cropAndScale=1,$alignment="c",$quality=80,$canvasColor="#cccccc",$transparency=1,$params=''){
        $queryString="";
        $queryString.='?src='.$src;
        
        if($width!=''){
            $queryString.='&w='.$width;
        }
        
        if($height!=''){
            $queryString.='&h='.$height;
        }
        
        $queryString.='&zc='.$cropAndScale;
        $queryString.='&a='.$alignment;
        $queryString.='&q='.$quality;        
        $queryString.='&cc='.$canvasColor;        
        $queryString.='&ct='.$transparency;        
        
        if($params!=''){
            $queryString.=$params;
        }
        return self::getTimthumbURL().$queryString;
        
        
        
        /*$image = wp_get_image_editor( $src ); // Return an implementation that extends <tt>WP_Image_Editor</tt>
        //_log($image);
        if ( ! is_wp_error( $image ) ) {
            //$image->rotate( 90 );
            $image->resize( $width, $height, true );
            $image->stream();
            //$saved = $image->save();
            //_log($image);
            //return $saved->path;
            //return $image->stream();
        }*/
        
        
        //return 'asd';
        
        
    }
    
    public static function getImgNotFoundURL(){
        return get_stylesheet_directory_uri().'/'.self::$imagesDirectory.'/'.self::$imgNotFoundFileName;
        
    }
    
    /**
     * Pega o endereço do Media Dispatcher 
     */
    public static function getTimthumbURL(){
        return get_stylesheet_directory_uri().'/'.self::$wpImgManagerFolder.'/'.self::$timthumbFile;
        //return dirname(__FILE__).'/'.self::$timthumbFile;
    }
    
    //public static function get
    
    
    
    
    
    
    
    
    
    
    
}

?>