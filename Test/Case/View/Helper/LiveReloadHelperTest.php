<?php
App::uses('View', 'View');
App::uses('Helper', 'View');
App::uses('LiveReloadHelper', 'LiveReload.View/Helper');

/**
 * LiveReloadHelper Test Case
 *
 */
class LiveReloadHelperTest extends CakeTestCase {

/**
 * Controller object for testing
 */
 	private $Controller = null;
	
/**
 * View object for testing
 */
 	private $View = null;

/**
 * LiveReloadHelper object for testing
 */
 	private $LiveReload = null;

/**
 * Setup Test Case
 * 
 * @return void
 */
 	public static function setupBeforeClass() {
		App::build(array(
			'View' => array(
				CAKE_CORE_INCLUDE_PATH . DS . 'Cake' . DS . 'Test' . DS . 'test_app' . DS . 'View' . DS,
				APP . 'Plugin' . DS . 'DebugKit' . DS . 'View' . DS,
				CAKE_CORE_INCLUDE_PATH . DS . 'Cake' . DS . 'View' . DS
			)
		), true);
 	}
	
/**
 * Tear Down Test Case
 * 
 * @return void
 */
 	public static function tearDownAfterClass() {
 		App::build();
 	}

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		
		Router::connect('/:controller/:action');
		$request = new CakeRequest();
		$request->addParams(array('controller' => 'pages', 'action' => 'display'));
		
		$this->Controller = new Controller($request, new CakeResponse());
		$this->View = new View($this->Controller);
		$this->LiveReload = new LiveReloadHelper($this->View);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LiveReload, $this->Controller, $this->View);

		parent::tearDown();
	}

/**
 * Test Constructor with settings
 * 
 * @return void
 */
 	public function testConstructorSettings() {
 		$settings = array(
			'jsPath' => 'http://localhost/new-url',
		);
 		$LiveReload = new LiveReloadHelper($this->View, $settings);
		$this->assertEquals($settings['jsPath'], $LiveReload->settings['jsPath']);
 	}
	
/**
 * Test injectScript method
 * 
 * @return void
 */
 	public function testInjectScript() {
 		$this->Controller->viewPath = 'Posts';
		$this->Controller->uses = null;
		$request = new CakeRequest('/posts/index');
		$request->addParams(array('controller' => 'posts', 'action' => 'index'));
		$this->Controller->setRequest($request);
		$this->Controller->helpers = array('LiveReload.LiveReload');
		$this->Controller->layout = 'default';
		$this->Controller->constructClasses();
		$result = $this->Controller->render();
		$result = $result->body();
		$result = str_replace(array("\n", "\r"), '', $result);
		$jsPath =  $this->LiveReload->settings['jsPath'];
		$this->assertPattern('#<script\s*type="text/javascript"\s*src="' . $jsPath . '(?:\?\d*?)?"\s*>\s?</script>#', $result);
 	}

}
