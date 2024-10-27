<?php
 
class ASA_Paginator {
 
    private $_conn;
    private $_limit;
    private $_page;
    private $_query;
    private $_total;
    private $_suchText;
    private $_ort;
    private $_radius;
		
	public function __construct( $limit = null, $total = null, $page = null, $suchText = null, $ort = null, $radius = 20) {
     
        $this->_limit = $limit;
        $this->_total = $total;
        $this->_page = $page;
        $this->_suchText = $suchText;
        $this->_ort = $ort;
        $this->_radius = $radius;
    }
    
    public function ASA_getData( $limit = 10, $page = 1 ) {
     
        $this->_limit   = $limit;
        $this->_page    = $page;
     
        if ( $this->_limit == 'all' ) {
            $query      = $this->_query;
        } else {
            $query      = $this->_query . " LIMIT " . ( ( $this->_page - 1 ) * $this->_limit ) . ", $this->_limit";
        }
        $rs             = $this->_conn->query( $query );
     
        while ( $row = $rs->fetch_assoc() ) {
            $results[]  = $row;
        }
     
        $result         = new stdClass();
        $result->page   = $this->_page;
        $result->limit  = $this->_limit;
        $result->total  = $this->_total;
        $result->data   = $results;
     
        return $result;
    }

    public function ASA_createLinks( $links, $list_class ) {
        if ( $this->_limit == 'all' ) {
            return '';
        }
     
        $last       = ceil( $this->_total / $this->_limit );
     
        $start      = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
        $end        = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;
     
        $html       = '<ul class="' . $list_class . '">';
     
        $class      = ( $this->_page == 1 ) ? " job__paging-element--disabled" : "";
        $html       .= '<li class="job__paging-element' . $class . '"><a class="job__paging-link" href="?limit=' . $this->_limit . '&stellenpage=' . ( $this->_page - 1 ) . '&suchText=' . $this->_suchText . '&suchOrt=' . $this->_ort . '&radius=' . $this->_radius.'">&laquo;</a></li>';
     
        if ( $start > 1 ) {
            $html   .= '<li><a class="job__paging-link" href="?limit=' . $this->_limit . '&stellenpage=1&suchText=' . $this->_suchText . '&suchOrt=' . $this->_ort. '&radius=' . $this->_radius.'">1</a></li>';
            $html   .= '<li class="job__paging-element job__paging-element--disabled"><span>...</span></li>';
        }
     
        for ( $i = $start ; $i <= $end; $i++ ) {
            $class  = ( $this->_page == $i ) ? " job__paging-element--active" : "";
            $html   .= '<li class="job__paging-element' . $class . '"><a class="job__paging-link" href="?limit=' . $this->_limit . '&stellenpage=' . $i . '&suchText=' . $this->_suchText . '&suchOrt=' . $this->_ort. '&radius=' . $this->_radius.'">' . $i . '</a></li>';
        }
     
        if ( $end < $last ) {
            $html   .= '<li class="job__paging-element job__paging-element--disabled"><span>...</span></li>';
            $html   .= '<li class="job__paging-element"><a class="job__paging-link" href="?limit=' . $this->_limit . '&stellenpage=' . $last . '&suchText=' . $this->_suchText . '&suchOrt=' . $this->_ort. '&radius=' . $this->_radius.'">' . $last . '</a></li>';
        }
     
        $class      = ( $this->_page == $last ) ? " job__paging-element--disabled" : "";
        $html       .= '<li class="job__paging-element' . $class . '"><a class="job__paging-link" href="?limit=' . $this->_limit . '&stellenpage=' . ( $this->_page + 1 ) . '&suchText=' . $this->_suchText . '&suchOrt=' . $this->_ort. '&radius=' . $this->_radius.'">&raquo;</a></li>';
     
        $html       .= '</ul>';
     
        return $html;
    }
}

?>