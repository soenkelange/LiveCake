<?php

class LiveReloadHelper extends Helper {

/**
 * Helpers
 * 
 * @var array
 */
	public $helpers = array(
		'Html',
	);
	
/**
 * Settings
 * 
 * @var array
 */
	public $settings = array(
		'jsPath' => 'http://localhost:35729/livereload.js',
	);
	
/**
 * Constructor
 * 
 * @param View $View The View this helper is being attached to.
 * @return array $settings Configuration settings for the helper
 */
 	public function Constructor(View $View, $settings = array()) {
 		parent::__construct($View, $settings);
 	}
	
/**
 * Called after the layout file was rendered.
 * Prepends a script-tag with the path of the reload script before </head>
 * 
 * @param string $layoutFile The layout file rendered
 * @return void
 */
	public function afterLayout($layoutFile) {
		if (Configure::read('debug') > 0) {
			$head = $this->Html->script($this->settings['jsPath']);
			$view = $this->_View;
			if (preg_match('#</head>#', $view->output)) {
				$view->output = preg_replace('#</head>#', $head . "\n</head>", $view->output, 1);
			}
		}
	}
}
