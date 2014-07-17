<?php

require_once dirname(__FILE__)."/../MediaDispatcher.php";

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WordpressTheme
 *
 * @author USUARIO
 */
class WordpressTheme {
        //put your code here
    
    public function __construct() {        
        $this->addWPActions();
        $this->addWPFilters();
        
    }
    
    public function addAjaxFunctions(){
        
    }
    
    protected function addWPActions(){        
        add_action('init', array($this, "init"));
        add_action('wp_enqueue_scripts', array($this,'loadFrontEndJsAndCSS'));
        add_action('admin_enqueue_scripts', array($this,'loadAdminJsAndCSS'));       
        add_action('admin_init', array($this,'admin_init'));
        add_action('admin_menu', array($this,'admin_menu'));
        add_action('save_post', array($this,"save_post"));
        add_action("manage_posts_custom_column",  array($this,"manage_posts_custom_column"));
        add_action('wp_login_failed', array($this,'my_front_end_login_fail') );  // hook failed login
        add_action('wp_print_scripts', array($this,'wpPrintScripts') );
        add_action('widgets_init', array($this,'widgetsInit') );     
        add_action('wp_head',array($this,'wpHead'));
    }
    
    public function wpHead(){
        ?>
        <script type="text/javascript">
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
        </script>
        <?php
    }
    
    public function widgetsInit(){        
        $this->addWidgets();
        
        $this->addSideBars();
        $this->removeSideBars();
    }
    
    public function addWidgets(){        
        
        //ClassName
        register_widget('CustomWidget');
    }
    
    public function addMenuPages(){
        //add_submenu_page( 'edit.php?post_type=news_cpt', 'My Custom Submenu Page', 'My Custom Submenu Page', 'manage_options', 'my-custom-submenu-page', array($this,'my_custom_submenu_page_callback') ); 
    }
    
    public function wpPrintScripts(){
         
    }
    
    /**
     * Carrega javascript e CSS no frontEnd 
     */
    public function loadFrontEndJsAndCSS(){
        wp_register_style( 'frontend_css', get_template_directory_uri() . '/css/frontend.css',array());
	wp_enqueue_style( 'frontend_css' );
        
        wp_register_script( 'frontend_js', get_template_directory_uri().'/js/frontend.js',array('jquery'));
	wp_enqueue_script( 'frontend_js' );
    }    
    
    /**
     * Carrega javascirpt e CSS no admin 
     */
    public function loadAdminJsAndCSS($hook){
        wp_register_style( 'admin_css', get_template_directory_uri() . '/css/admin.css',array());
	wp_enqueue_style( 'admin_css' );
        
         /*wp_deregister_script('jquery');        
        wp_register_script('jquery', get_template_directory_uri() . '/js/jquery.min.js');
        wp_enqueue_script('jquery');*/
        
        wp_register_script( 'admin_js', get_template_directory_uri().'/js/admin.js',array('jquery'));
	wp_enqueue_script( 'admin_js' );
    }
    
    public function addWPFilters(){
        add_filter( 'comments_template', array($this,'comments_template'));
        add_filter("query_vars", array($this, "queryVars"));
    }    
    
    public function queryVars($qvars){
        $qvars[] = "customparam";
        return $qvars;
    }  
    
    public function comments_template($file){
        /*if ( is_page() )
        $file = STYLESHEETPATH . '/no-comments-please.php';
        return $file;*/       
    }   
    
    public function init(){       
        $this->addCustomPostTypes();
        $this->addCustomTaxonomies();
        $this->addAjaxFunctions();
        
       // $this->removeMenuPages();
    }
    
    public function removeSideBars(){
        
    }
    
    public function addSideBars(){
        $args = array(
	'name'          => __( 'Barra lateral Automatica das pags internas', 'theme_text_domain' ),
	'id'            => SideBars::INTERNAL_PAGES_DEFAULT,
	'description'   => '',
        'class'         => '',
	'before_widget' => '<li id="%1$s" class="widget %2$s">',
	'after_widget'  => '</li>',
	'before_title'  => '<h2 class="widgettitle">',
	'after_title'   => '</h2>' );
        register_sidebar($args);
    }
    
    
    public function removeMenuPages(){       
        remove_menu_page('link-manager.php');
        remove_menu_page('tools.php');
        remove_menu_page('users.php');
        remove_menu_page('edit.php');
        remove_menu_page('edit.php?post_type=post');
        remove_menu_page('themes.php');
        remove_menu_page('plugins.php');
        remove_menu_page('options-general.php');
        remove_menu_page('upload.php');
        remove_menu_page('update-core.php');
        remove_menu_page('index.php');
    }
    
    public function addCustomTaxonomies(){
        //flush_rewrite_rules( false );/* Please read "Update 2" before adding this line */
    }
    
    public function addCustomPostTypes(){
        
    }
    
    public function admin_init(){
             
    }
    
    public function addCustomMetaBoxes(){
        
    }
    
    public function admin_menu(){
        $this->addCustomMetaBoxes();
        $this->addMenuPages();
        $this->removeMenuPages();
    }
    
    public function save_post(){
        
    }
    
    public function manage_posts_custom_column(){
        
    }
    
    public function my_front_end_login_fail(){
        
    }
    
    
}

if(!function_exists('_log')){
    function _log( $message ) {
        if( WP_DEBUG === true ){
            if( is_array( $message ) || is_object( $message ) ){
                error_log( print_r( $message, true ) );
            } else {
                error_log( $message );
            }
        }
    }
}


?>
