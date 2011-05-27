<?php

class Util_Pager {

    protected $pageNumber;
    protected $total;
    protected $lastPage;

    public $start;
    public $html;
    public $itemsPerPage;
    public $url;

    protected function __construct($pageNumber, $itemsPerPage, $total, $url = '') {
        if(!$pageNumber) {
            $pageNumber = 1;
        }

        $this->pageNumber = $pageNumber;
        $this->itemsPerPage = $itemsPerPage;
        $this->total = $total;

        if($url == '') {
            $this->url = $_SERVER['PHP_SELF'];
        } else {
            $this->url = $url;
        }

        $this->calculate();
    }

    public function setPageNumber($pageNumber) {
        $this->pageNumber = $pageNumber;
    }

    public function setItemsPerPage($itemsPerPage) {
        $this->itemsPerPage = $itemsPerPage;
    }

    public function setTotal($total) {
        $this->total = $total;
    }

    public function calculate() {
        $this->lastPage = ceil($this->total / $this->itemsPerPage);

        if($this->lastPage == 0) {
            $this->lastPage = 1;
        }

        if($this->pageNumber < 1) {
            $this->pageNumber = 1;
        } else if($this->pageNumber > $this->lastPage) {
            $this->pageNumber = $this->lastPage;
        }

        $this->start = (($this->pageNumber - 1) * $this->itemsPerPage);
    }

    public function limit() {      
        return 'LIMIT ' .$this->start .',' .$this->itemsPerPage;
    }

    public function generateHTML($regenerate = false) {
        if($this->html && !$regenerate) {
            return $this->html;
        }

        $pn = $this->pageNumber;
        $centerPages = ""; // Initialize this variable
        $sub1 = $pn - 1;
        $sub2 = $pn - 2;
        $add1 = $pn + 1;
        $add2 = $pn + 2;
        if ($pn == 1) {
                $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
                $centerPages .= '&nbsp; <a href="' . $this->url . '/page/' . $add1 . '">' . $add1 . '</a> &nbsp;';
        } else if ($pn == $this->lastPage) {
                $centerPages .= '&nbsp; <a href="' . $this->url . '/page/' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
                $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
        } else if ($pn > 2 && $pn < ($this->lastPage - 1)) {
                $centerPages .= '&nbsp; <a href="' . $this->url . '/page/' . $sub2 . '">' . $sub2 . '</a> &nbsp;';
                $centerPages .= '&nbsp; <a href="' . $this->url . '/page/' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
                $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
                $centerPages .= '&nbsp; <a href="' . $this->url . '/page/' . $add1 . '">' . $add1 . '</a> &nbsp;';
                $centerPages .= '&nbsp; <a href="' . $this->url . '/page/' . $add2 . '">' . $add2 . '</a> &nbsp;';
        } else if ($pn > 1 && $pn < $this->lastPage) {
                $centerPages .= '&nbsp; <a href="' . $this->url . '/page/' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
                $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
                $centerPages .= '&nbsp; <a href="' . $this->url . '/page/' . $add1 . '">' . $add1 . '</a> &nbsp;';
        }

        $paginationDisplay = ""; // Initialize the pagination output variable
        // This code runs only if the last page variable is not equal to 1, if it is only 1 page we require no paginated links to display
        if ($this->lastPage != "1"){
            // This shows the user what page they are on, and the total number of pages
            $paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $this->lastPage. '<img src="/content/images/clearImage.gif" width="48" height="1" alt="Spacer" />';
                // If we are not on page 1 we can place the Back button
            if ($pn != 1) {
                    $previous = $pn - 1;
                        $paginationDisplay .=  '&nbsp;  <a href="' . $this->url . '/page/' . $previous . '"> Back</a> ';
            }
            // Lay in the clickable numbers display here between the Back and Next links
            $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
            // If we are not on the very last page we can place the Next button
            if ($pn != $this->lastPage) {
                $nextPage = $pn + 1;
                        $paginationDisplay .=  '&nbsp;  <a href="' . $this->url . '/page/' . $nextPage . '"> Next</a> ';
            }
        }

        $this->html = $paginationDisplay;

        return $this->html;
    }

    public static function setup($pageNumber, $itemsPerPage, $table_name, $url = '') {
        $total = DB::query(Database::SELECT, "SELECT COUNT(*) as total FROM $table_name")
                    ->execute()
                    ->get('total');

        return new Util_Pager($pageNumber, $itemsPerPage, $total, $url);
    }
}
