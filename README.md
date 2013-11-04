Fabricate
=========

CakePHP data generator for Testing

It's inspired on [Fabrication](https://github.com/paulelliott/fabrication) from the Ruby world.

Fabricate is a simple fake object generation plugin for CakePHP.
Quickly Fabricate objects as needed anywhere in your app or test case.
Generation method(Lib/Fabricate#_generateRecords()) cited FixtureTask of CakePHP.

## Install 

Add require-dev in your composer.json

`composer require --dev sizuhiko/fabricate`


Add bootstrap

`CakePlugin::load('Fabricate');`

## Usage

### The Basics

The simplest way to generate objects

	Fabricate::create('Post')

That will generate and save to database an instance of Post using the schema information.

To set additional attributes or override what is in the Fabricator, you can pass a array to Fabricate with the fields you want to set.

	Fabricate::create('Post', ["created" => "2013-10-09 12:40:28", "updated" => "2013-10-09 12:40:28"])

### Fabricating With Blocks

In addition to the array, you can pass a callback function to Fabricate and all the features of a Fabricator definition are available to you at object generation time.

	Fabricate::create('Post', 10, function($data){
		return ["created" => "2013-10-09 12:40:28", "updated" => "2013-10-09 12:40:28"];
	});

The hash will overwrite any fields defined in the callback function.

## APIs

### Generate model attributes as array (not saved)

`Fabricate::attributes_for(:model_name, :number_of_generation, :array_or_callback)` generate only attributes.

* model_name: CakePHP Model class name.
* number_of_generation: Generated number of records
* array_or_callback: it can override each generated attributes

#### Example

	$results = Fabricate::attributes_for('Post', 10, function($data){
		return ["created" => "2013-10-09 12:40:28", "updated" => "2013-10-09 12:40:28"];
	});

	// $results is followings :
	array (
	  0 => 
	  array (
	    'id' => 1,
	    'title' => 'Lorem ipsum dolor sit amet',
	    'body' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
	    'created' => '2013-10-09 12:40:28',
	    'updated' => '2013-10-09 12:40:28',
	  ),
	  1 => 
	  array (
	  ....

### Generate a model instance (not saved)

`Fabricate::build(:model_name, :array_or_callback)` generate a model instance (using ClassRegistry::init).

* model_name: CakePHP Model class name.
* array_or_callback: it can override each generated attributes

#### Example

	$result = Fabricate::build('Post', function($data){
		return ["created" => "2013-10-09 12:40:28", "updated" => "2013-10-09 12:40:28"];
	});

	// $results is followings :
	AppModel::__set_state(array(
	   'useDbConfig' => 'default',
	   'useTable' => 'posts',
	   'id' => 1,
	   'data' => 
	  array (
	    'Post' => 
	 ......

### Generate records to database

`Fabricate::create(:model_name, :number_of_generation, :array_or_callback)` generate and save records to database.

* model_name: CakePHP Model class name.
* number_of_generation: Generated number of records
* array_or_callback: it can override each generated attributes

#### Example

	Fabricate::create('Post', 10, function($data){
		return ["created" => "2013-10-09 12:40:28", "updated" => "2013-10-09 12:40:28"];
	});


## Contributing to this Plugin

Please feel free to contribute to the plugin with new issues, requests, unit tests and code fixes or new features.
If you want to contribute some code, create a feature branch from develop, and send us your pull request.

