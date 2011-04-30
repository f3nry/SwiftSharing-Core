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

        $this->template->feed_content = Util_Feed_Generator::factory()
                ->set('types', array('STATUS', 'PHOTO'))
                ->set('feed_id', $this->request->param('id'))
                ->load()
                ->render();

        $this->template->feed = Model_Feed::getFeed($this->request->param('id'));
    }

    public function action_comments() {
        $data = array();
        
        $data['blab'] = Model_Feed::getBlab($this->request->param('id'), false, false);
        $data['blab_data'] = Model_Blab::getById($this->request->param('id'))->as_array();
        //$data['comments'] = Model_Feed::getFeedContent($this->request->param('id'), "'COMMENT'");

        $data['comments'] = Util_Feed_Generator::factory()
                ->set('feed_id', $this->request->param('id'))
                ->set('types', array('COMMENT'))
                ->set('ignore_privacy', true)
                ->load()
                ->render();

        echo json_encode($data);

        exit;
    }
}
