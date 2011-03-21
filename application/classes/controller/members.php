<?php

class Controller_Members extends Controller_App {
    public $template = "members";

    public function action_search() {
        $this->_requireAuth();

        $post = $this->request->post();
        $pager = Util_Pager::setup($this->request->param('page_number'), 15, 'myMembers WHERE email_activated != \'0\'', '/members/search');

        $this->template->totalMembers = Model_Member::getTotalCount();
        $this->template->members = Model_Member::doSearch(@$post['searchField'], $pager);
        $this->template->pager = $pager->generateHTML();
    }
}
?>
