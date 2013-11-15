# LiveCake V.1
LiveCake is a plugin for CakePHP using LiveReload

##Requirements
* [CakePHP](http://cakephp.org) >= 2.3
* [LiveReload](http://livereload.com)

## Installation
### Composer
Be sure require is present in composer.json. This will install the plugin into app/Plugin/LiveCake

	{
		"require": {
			"soenkelange/live_cake": "*"
		}
	}

## Enable
You need to enable the plugin in your app/COnfig/bootstrap.php file:

`CakePlugin::load('BoostCake');`

## How to use
To use this helper add the following to you AppController:

```php
<?php
...
public $helpers = array(..., 'LiveCake.LiveReload');
```

This will insert `<script type="text/javascript" src="http://localhost:35729/livereload.js"></script>` before </head> in the respons body.

To customize the path, you can use the helper settings:

```php
<?php
...
public $helpers = array(..., 'LiveCake.LiveReload' => array('jsPath' => 'YOUR_CUSTOM_PATH'));
```