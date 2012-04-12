# Twitter Bootstrap CakePHP Helper

CakePHP helper for rendering bootstrap appropriate markup. Uses the Twitter Bootstrap 2.0.

## Requirements

* [CakePHP 2.0](https://github.com/cakephp/cakephp)
* [Twitter Bootstrap CSS 2.0](http://twitter.github.com/bootstrap/)
* *Optional* [Twitter Bootstrap JS](http://twitter.github.com/bootstrap/javascript.html)

## Installation

Check out the the repo in the plugins directory

	git clone git://github.com/loadsys/twitter-bootstrap-helper TwitterBootstrap

Add the plugin inclusion in the project bootstrap file

	echo "CakePlugin::load('TwitterBootstrap');" >> Config/bootstrap.php

Then add helper to the $helpers array in a controller (AppController.php to use in all views)

	public $helpers = array("Html", "Form", "TwitterBootstrap.TwitterBootstrap");

Now available in your views is `$this->TwitterBootstrap`. If you'd like to make the helper name shorter, remember the alias functionality:

	public $helpers = array(
		"Html",
		"Form",
		"TB" => array(
			"className" => "TwitterBootstrap.TwitterBootstrap"
		)
	);

## Methods

### TwitterBootstrapHelper::input(array $options)

The form inputs in Twitter Bootstrap are quite different from the default html that the `FormHelper::input()` method. The `TwitterBootstrap->input()` aims to do the same type of thing that the `FormHelper::input()` would, but with the markup the bootstrap styles work with.

	echo $this->TwitterBootstrap->input("field_name", array(
		"input" => $this->Form->text("field_name"),
		"help_inline" => "Text to the right of the input",
		"help_block" => "Text under the input"
	));

The method will handle errors and update the class on the div surrounding the input and label to show the text and input border as red.

### TwitterBootstrapHelper::basic_input(mixed $field, array $options)

While the `input()` method outputs the more verbose markup; the `basic_input()` method just outputs the minimum markup (the labal and input tags).

	echo $this->TwitterBootstrap->basic_input("field_name", array(
		"label" => "Custom label text"
	));

### TwitterBootstrapHelper::search(string $name, array $options)

Twitter Bootstrap offers a new search specific text input field, and this method will ouput that input with its special class.

	echo $this->TwitterBootstrap->search();

### TwitterBootstrapHelper::radio(array $options)

This method will render groups of radio inputs. Internally it will call `TwitterBootstrap->input()`, so the options are the same.

	echo $this->TwitterBootstrap->radio("field_name", array(
		"options" => array(
			"yes" => "Yes",
			"no" => "No",
			"maybe" => "Maybe"
		)
	));

### TwitterBootstrapHelper::button(string $value, array $options)

`TwitterBootstrap->button()` will render the submit button for forms.

	echo $this->TwitterBootstrap->button("Save", array("style" => "primary", "size" => "large"));

Valid styles for the button are "primary", "success", "info", and "danger". Valid sizes are "small" and "large". If either are left out, then the default styles will apply (A grey button and a medium size). There is another option, "disabled", that takes a bool. If true it will apply the disabled styles.

### TwitterBootstrapHelper::button_dropdown(string $value, array $options)

The method will build a button dropdown menu. The dropdown js plugin is required for the dropdown functionality. The list of links for the dropdown is supplied in any array of string links (the output of `HtmlHelper::link()`) or arrays (that are used as params for `HtmlHelper::link()`). A null value in the array will add a divider in the list of links. Other unique options are 'split', 'dropup', and 'right'. The 'split' option will make the caret appear in its own button instead of part of the main button. The 'dropup' option (if the value is true) will cause the list of links to appear above the button instead of below. The 'right' option will make the list be pulled right instead of the default left.

	echo $this->TwitterBootstrap->button_dropdown("Button Value", array(
		"split" => true,
		"dropup" => true,
		"right" => true,
		"links" => array(
			$this->Html->link("Link 1", "#"),
			array("Link 2", "#"),
			null, // Will produce a divider line
			array("Link 3", "#")
		)
	));

### TwitterBootstrapHelper::button_link(string $title, mixed $url, array $options, string $confirm)

The `TwitterBootstrap::button_link()` builds a button similar to the `TwitterBootstrap::button()` but it uses `Html->link()` to make an anchor tag.

	echo $this->TwitterBootstrap->button_link("Edit", "/resource/edit/1", array("style" => "info", "size" => "small"));

Like the `TwitterBootstrap->button()`, the "disabled" option can be passed to apply the disabled styles.

### TwitterBootstrapHelper::button_form(string $title, mixed $url, array $options, string $confirm)

The `TwitterBootstrap->button_form()` is the same as `TwitterBootstrap->button_link()`, but it uses `Form->postLink()` to create the link.

	echo $this->TwitterBootstrap->button_form("Delete", "/resource/delete/1", array("style" => "danger", "size" => "small"), "Are you sure?");

Like the `TwitterBootstrap->button()`, the "disabled" option can be passed to apply the disabled styles.

### TwitterBootstrapHelper::breadcrumbs(array $options)

`TwitterBootstrap->breadcrumbs()` utilizes `HtmlHelper::getCrumbs()` to build the breadcrumbs markup specific to Twitter Bootstrap.

	$this->TwitterBootstrap->breadcrumbs(array("divider" => ">"));

### TwitterBootstrapHelper::add_crumb(string $title, mixed $url, array $options)

`TwitterBootstrap->add_crumb()` delegates to `HtmlHelper::addCrumb()`.

	$this->TwitterBootstrap->add_crumb("Crumb Item", "/path");

### TwitterBootstrapHelper::label(string $message, string $style, array $options)

Twitter Bootstrap has some reusable label styles, and `TwitterBootstrap->label()` simply returns this small html fragment.

	echo $this->TwitterBootstrap->label("Recent", "warning");

The valid values for the second parameter are "success", "important", "warning", "info", "inverse". Passing no second param will use the default (grey) style.

### TwitterBootstrapHelper::badge(int $num, string $style, array $options)

The Twitter Bootstrap badges are similar to labels, but are meant to contain an integer.

	echo $this->TwitterBootstrap->badge(4, "error");

The valid values for the second parameter are "success", "warning", "error", "info", "inverse". Passing no second param will use the default (grey) style.

### TwitterBootstrapHelper::icon(string $name, string $color)

This method will output the icon markup with the proper clases. The valid colors are 'white' and 'black' (default is 'black'). Valid icon names are detailed on the [Twitter Bootstrap docs](http://twitter.github.com/bootstrap/base-css.html#icons). Pass the name of the icon without 'icon-'.

	echo $this->TwitterBootstrap->icon("fire", "white");

### TwitterBootstrapHelper::progress(array $options)

The `progress()` method makes progress bars by specifying a width style inline. You can pass a 'width' option with a value from 0 to 100 and it will be applied as the beginning width. Passing the "striped" option will apply the striped styles, and passing the "active" option will make the progress bar animate.

	echo $this->TwitterBootstrap->progress(array("width" => 50, "striped" => true, "active" => true));

The valid values for the "style" options are "info", "success", "warning", and "danger".

### TwitterBootstrapHelper::flash(string $key, array $options)

Twitter Bootstrap has some nice styles that would work great for the session flash message. By default, the method will return the value in the default key that `SessionComponent::setFlash()` sets (that is "flash").

	echo $this->TwitterBootstrap->flash("success");

The flash message can be closable if the "closable" option is passed in the options array witha value of true. Here is info on the [javascript closable alerts](http://twitter.github.com/bootstrap/javascript.html#alerts). The alert styles offer some different styles and they are "warning", "error", "success", and "info". To set the class to use these different styles, call `setFlash()` like so:

	$this->Session->setFlash(__("Flash message"), "default", array(), "error");

Note that the default "flash" key that will be used when a different key is not passed in the 4th param of the `setFlash()` method will use the "warning" styles.

### TwitterBootstrapHelper::flashes(array $options)

`TwitterBootstrap->flashes()` will loop through the valid alert types ("warning", "error", "success", "info") as well as the default flash type ("flash"), and optionally the "auth" flash.

	echo $this->TwitterBootstrap->flashes(array("auth" => true));

Passing "auth" => true, will include the "auth" string in the loop of keys to try. You may also pass in an array of keys in the option "keys" for this method to loop through.

### TwitterBootstrapHelper::block(string $message, array $links, array $options)

`TwitterBootstrap->block()` will create the more detailed alerts. It take a string (could contain html), and an array of links. The links should be created with `TwitterBootstrap->button_link()`.

	echo $this->TwitterBootstrap->block(
		$html_content,
		array(
			$this->TwitterBootstrap->button_link("Action Link", "/path"),
			$this->TwitterBootstrap->button_link("Another Action", "/another/path")
		),
		array(
			"style" => "success",
			"closable" => true
		)
	);

The valid options for "style" are "warning", "error", "success", "info". If the "closable" option is passed with a value of true, then the close link is added. Here is info on the [javascript closable alerts](http://twitter.github.com/bootstrap/javascript.html#alerts).

### TwitterBootstrapHelper::page_header(string)

`TwitterBootstrap->page_header(string)` will print a page heading TB style.

	echo $this->TwitterBootstrap->page_header("Page Header");
