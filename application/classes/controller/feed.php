<?php
/**
 * Created by JetBrains PhpStorm.
 * User: letuboy
 * Date: 3/3/11
 * Time: 11:47 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Controller_Feed extends Controller_App {
    public $template = "feed";

    public function action_index() {
        $this->_requireAuth();

        $this->layout->hideContentPane = true;

        $this->template->feed_list = Model_Feed::generateFeedList();

        $this->template->feed_content = Model_Feed::getFeedContent($this->request->param('id'));

        $this->template->feed = Model_Feed::getFeed($this->request->param('id'));
    }

    public function action_comments() {
        $data = array();
        
        $data['blab'] = Model_Feed::getBlab($this->request->param('id'), false, false);
        $data['blab_data'] = Model_Blab::getById($this->request->param('id'))->as_array();
        $data['comments'] = Model_Feed::getFeedContent($this->request->param('id'), "'COMMENT'");

        echo json_encode($data);

        exit;
    }
}
