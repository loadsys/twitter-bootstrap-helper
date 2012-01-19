# Twitter Bootstrap CakePHP Helper

## Requirements

* [CakePHP 2.0](https://github.com/cakephp/cakephp)
* [Twitter Bootstrap CSS](https://twitter.github.com/bootstrap)
* *Optional* [Twitter Bootstrap JS](https://twitter.github.com/bootstrap/javascript.html)

## Installation

Check out the the repo in the plugins directory

	git clone git@github.com/loadsys/twitter-bootstrap-helper TwitterBootstrap

Add the plugin inclusion in the project bootstrap file

	echo "CakePlugin::load("TwitterBootstrap");" >> Config/bootstrap.php

Then add helper to the $helpers array in a controller (AppController.php to use in all views)

	public $helpers = array("Html", "Form", "TwitterBootstrap.TwitterBootstrap");

Now available in your views is `$this->TwitterBootstrap`

## Methods

### input(array $options)

### radio(array $options)

### button(string $value, array $options)

### button_link(string $title, mixed $url, array $options, string $confirm)

### button_form(string $title, mixed $url, array $options, string $confirm)

### breadcrumbs(array $options)

### add_crumb(string $title, mixed $url, array $options)

### label(string $message, string $style, array $options)

### flash(string $key, array $options)

### flashes(array $options)

### block(string $message, array $links, array $options)
