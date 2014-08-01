<?php

/**
 * Description of OriggamiWpRouter
 *
 * Pablo Pacheco <pablo.pacheco@origgami.com.br>
 */
class OriggamiWpRouter {
   
    private $theme;
    private $view;

    public function __construct(OriggamiWpOopTheme $theme) {
        //Set theme
        $this->setTheme($theme);

        //Handle View
        require dirname(__FILE__) . "/OriggamiWpView.php";
        $view = new OriggamiWpView($theme->getScriptsManager());
        $this->setView($view);

        //Init
        add_action('pre_get_posts', array($this, 'onInit'), 1, 1);
    }

    public function onInit($query) {
        if (!$query->is_main_query()) {
            return;
        }
        /* if (!$query->is_main_query()) {
          return;
          }
          _log(print_r($query,true)); */
    }

    /**
     * 
     * @return OriggamiWpOopTheme
     */
    public function getTheme() {
        return $this->theme;
    }

    public function setTheme(OriggamiWpOopTheme $theme) {
        $this->theme = $theme;
    }

    /**
     * 
     * @return OriggamiWpView
     */
    public function getView() {
        return $this->view;
    }

    public function setView(OriggamiWpView $view) {
        $this->view = $view;
    }

}

?>
