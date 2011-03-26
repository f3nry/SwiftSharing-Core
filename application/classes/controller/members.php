<?php

class Controller_Members extends Controller_App {
    public $template = "members";

    /**
     * Search controller. Drives searching through the members table.
     */
    public function action_search() {
        $this->_requireAuth(); //Require authentication

        $post = $this->request->post(); //Get post data

        /**
         * Try to find the search field. There are 3 options here.
         *
         * 1. The user submitted a search query, use it, and send it to
         *    the session to be used on other pages.
         * 2. The user didn't submit a search query, but is going to another
         *    page in a previous search.
         * 3. The user is simply searching everything.
         */
        if(isset($post['searchField'])) {
            $searchField = $post['searchField'];

            Session::instance()->set('searchField', $searchField);
        } else if(Session::instance()->get('searchField') && $this->request->param('page_number')) {
            $searchField = $post['searchField'];
        } else {
            $searchField = "";

            Session::instance()->delete('searchField');
        }

        $searchField = Database::instance()->escape($searchField);

        //Setup a pager
        $pager = Util_Pager::setup(
                $this->request->param('page_number'),       //Page number
                15,                                         //Max number of records to retrieve
                "myMembers WHERE email_activated != '0'
                                 AND firstname SOUNDS LIKE '%$searchField%'
                                 OR lastname   SOUNDS LIKE '%$searchField%'
                                 OR username    SOUNDS LIKE '%$searchField%' ", //Extra query to get count
                '/members/search'                           //URL to use in the pager. Will append /page/<new_pager_number>
            );

        $this->template->totalMembers = Model_Member::getTotalCount(); //Get total number of members
        $this->template->members = Model_Member::doSearch(@$post['searchField'], $pager); //Perform the search
        $this->template->pager = $pager->generateHTML(); //Generate the pager HTML
    }
}
?>
