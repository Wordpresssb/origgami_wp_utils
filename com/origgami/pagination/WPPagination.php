<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pagination
 *
 * @author USUARIO
 */
class WPPagination {
    //put your code here
    
    public static function getPaginationHtml(WP_Query $wpQuery){
        $big = 999999999;
        $pagination = paginate_links( array(
                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format' => '?paged=%#%',
                'current' => max( 1, get_query_var('paged') ),
                'total' => $wpQuery->max_num_pages,
                //'type' => 'array'
        ) );
        
        /*$paginationHTML='';
        foreach ($pagination as $i => $value) {
            if($i==0){
                $paginationHTML.=$value;
                $paginationHTML.='<span class="middle">';
            }else if($i<(count($pagination)-1)){
                if($i==1){
                    $paginationHTML.=$value;
                }else{
                    $paginationHTML.=' - '.$value;
                }
                
            }else if($i==(count($pagination)-1)){
                $paginationHTML.='</span>';
                $paginationHTML.=$value;                
            }
        }*/
        
        if(strlen($pagination)>0){
            return '<div style="clear:both"></div><div class="thePagination">'.$pagination.'</div>';
        }else{
            return '';
        }
        
    }
    
}

?>
