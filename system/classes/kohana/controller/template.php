<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Abstract controller class for automatic templating.
 *
 * @package    Kohana
 * @category   Controller
 * @author     Kohana Team
 * @copyright  (c) 2008-2011 Kohana Team
 * @license    http://kohanaframework.org/license
 */
abstract class Kohana_Controller_Template extends Controller {
    /**
     * @var View Layout template
     */
    public $layout = 'layouts/template';

    public $template = false;

	/**
	 * @var  boolean  auto render template
	 **/
	public $auto_render = TRUE;

	/**
	 * Loads the template [View] object.
	 */
	public function before() {
		if ($this->auto_render === TRUE) {
			// Load the template
            if($this->template) {
			    $this->template = View::factory($this->template);
            }

            if($this->layout) {
                $this->layout = View::factory($this->layout);
            }
		}

		return parent::before();
	}

	/**
	 * Assigns the template [View] as the request response.
	 */
	public function after() {
		if ($this->auto_render === TRUE) {
            if($this->template) {
                if($this->layout) {
                    $this->layout->body = $this->template->render();

                    $content = $this->layout->render();
                } else if($this->template) {
                    $content = $this->template->render();
                } else {
                    $content = false;
                }

                $this->response->body($content);
            }
		}

		return parent::after();
	}

} // End Controller_Template
