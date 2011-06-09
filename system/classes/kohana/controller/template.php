<?php

defined('SYSPATH') or die('No direct script access.');

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
     * */
    public $auto_render = TRUE;
    
    public $_vars = array();
    
    public function __set($name, $value) {
        $this->_vars[$name] = $value;
    }
    
    public function __get($name) {
        return $this->_vars[$name];
    }
    
    /**
     * Initialize $this->template as a real View
     */
    protected function initializeTemplate() {
        // Load the template

        if (!$this->template) {
			$controller = implode("/", explode("_", $this->request->controller()));
	
            $this->template = $controller . "/" . $this->request->action();
        }
        
        try {
            $this->template = View::factory($this->template);
        } catch(Kohana_View_Exception $e) {}
    }
    
    /**
     * Initialize $this->layout as a View
     */
    protected function initializeLayout() {
        if($this->layout) {
            $this->layout = View::factory($this->layout);
        }
    }

    /**
     * Loads the template [View] object.
     */
    public function before() {
        if ($this->auto_render === TRUE) {
            $this->initializeLayout();
            
            $this->initializeTemplate();
        }

        return parent::before();
    }
    
    /**
     * Attach any variables that were set in this controller,
     * to the template and view.
     */
    protected function setVars() {
        foreach($this->_vars as $var => $value) {
            if($this->template instanceof View) {
                $this->template->$var = $value;
            }
            
            if($this->layout instanceof View) {
                $this->layout->$var = $value;
            }
        }
    }

    /**
     * Assigns the template [View] as the request response.
     */
    public function after() {
        if ($this->auto_render === TRUE) {
            $this->setVars();
            
            if ($this->template instanceof View) {
                if ($this->layout) {
                    $this->layout->body = $this->template->render();

                    $content = $this->layout->render();
                } else if ($this->template instanceof View) {
                    $content = $this->template->render();
                } else {
                    $content = false;
                }

                $this->response->body($content);
            }
        }

        return parent::after();
    }

}

// End Controller_Template
