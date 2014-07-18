<?php

/**
 * Description of OriggamiPagination
 *
 * @author Pablo Pacheco <pablo.pacheco@origgami.com.br>
 */
if (!class_exists('OriggamiWpPagination')) {

    class OriggamiWpPagination {

        //put your code here

        private $wp_query;
        private $paginationArray;
        private $args;
        private $defaultArgs;
        private $big = 999999999;

        public function __construct(WP_Query $wp_query, $args = null) {
            $this->args = $args;
            $this->setWp_query($wp_query);
            $this->createDefaultArgs();
            $this->start();
        }

        private function createDefaultArgs() {
            $this->setDefaultArgs(array(
                'base' => str_replace($this->big, '%#%', esc_url(get_pagenum_link($this->big))),
                'format' => '?paged=%#%',
                'infinite' => true,
                'current' => max(1, get_query_var('paged')),
                'total' => $this->getWp_query()->max_num_pages,
                'type' => 'array'
            ));
        }       

        protected function searchForValue($index, $id, $array) {
            if (is_array($array)) {
                foreach ($array as $key => $val) {
                    if ($val[$index] === $id) {
                        return $val;
                    }
                }
            }
            return false;
        }

        public function getPrev() {
            return $this->searchForValue('action', 'prev', $this->paginationArray['prevAndNextLinks']);
        }

        public function getNext() {
            return $this->searchForValue('action', 'next', $this->paginationArray['prevAndNextLinks']);
        }

        private function getPageNumber($pagString) {
            preg_match('/(?<=\>)\d(?=\<)/', $pagString, $matchesHref);
            return $matchesHref[0];
        }

        private function getHrefContent($aString) {
            preg_match('/(?<=href=\").+.(?=\")|(?<=href=\').+.(?=\')/', $aString, $matchesHref);
            if (is_array($matchesHref) && count($matchesHref) > 0) {
                return $matchesHref[0];
            } else {
                return '';
            }
        }

        public function getPaginationPagesArray() {
            return $this->paginationArray['pages'];
        }

        private function start() {
            $paginationArray = $this->getPaginationArray();
            $finalArgs = wp_parse_args($this->getArgs(), $this->getDefaultArgs());
            $pagination = paginate_links($finalArgs);
            
            $count = 1;
            if (is_array($pagination)) {

                //Get prev link
                $fl_array = preg_grep("/prev page-numbers/", $pagination);
                if (is_array($fl_array) && count($fl_array) > 0) {
                    $paginationArray['prevAndNextLinks'][] = array(
                        'action' => 'prev',
                        'disabled' => false,
                        'href' => $this->getHrefContent(current($fl_array))
                    );
                } else if ($finalArgs['infinite'] == true) {
                    $paginationArray['prevAndNextLinks'][] = array(
                        'action' => 'prev',
                        'disabled' => true,
                        'href' => str_replace($this->big, $this->getWp_query()->max_num_pages, esc_url(get_pagenum_link($this->big)))
                    );
                }

                //Get next link
                $fl_array = preg_grep("/next page-numbers/", $pagination);
                if (is_array($fl_array) && count($fl_array) > 0) {
                    $paginationArray['prevAndNextLinks'][] = array(
                        'action' => 'next',
                        'disabled' => false,
                        'href' => $this->getHrefContent(current($fl_array))
                    );
                } else if ($finalArgs['infinite'] == true) {
                    $paginationArray['prevAndNextLinks'][] = array(
                        'action' => 'next',
                        'disabled' => true,
                        'href' => str_replace($this->big, 1, esc_url(get_pagenum_link($this->big)))
                    );
                }

                //Get pages
                $fl_array = preg_grep("/'page-numbers current'|'page-numbers'/", $pagination);
                foreach ($fl_array as $key => $value) {
                    $pagesInfs = array();
                    $href = $this->getHrefContent($value);
                    $pagesInfs['href'] = $href;
                    preg_match("/page-numbers current/", $value, $isCurrPage);
                    if (is_array($isCurrPage) && count($isCurrPage) > 0) {
                        $pagesInfs['is_current'] = true;
                    } else {
                        $pagesInfs['is_current'] = false;
                    }
                    $pagesInfs['page_num'] = $this->getPageNumber($value);
                    $paginationArray['pages'][] = $pagesInfs;
                }

                $this->paginationArray = $paginationArray;                
            }
        }

        public function getWp_query() {
            return $this->wp_query;
        }

        public function setWp_query($wp_query) {
            $this->wp_query = $wp_query;
        }

        public function getPaginationArray() {
            return $this->paginationArray;
        }

        public function getArgs() {
            return $this->args;
        }

        public function setArgs($args) {
            $this->args = $args;
        }

        public function getDefaultArgs() {
            return $this->defaultArgs;
        }

        public function setDefaultArgs($defaultArgs) {
            $this->defaultArgs = $defaultArgs;
        }

    }

}
