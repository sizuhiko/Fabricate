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

### Generate model attributes as array (not saved)

`Fabricate::attributes_for(:model_name, :number_of_generation, :callback)` generate only attributes.

* model_name: CakePHP Model class name.
* number_of_generation: Generated number of records
* callback: it can overwrite each generated attributes

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

`Fabricate::build(:model_name, :callback)` generate a model instance (using ClassRegistry::init).

* model_name: CakePHP Model class name.
* callback: it can overwrite each generated attributes

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

`Fabricate::create(:model_name, :number_of_generation, :callback)` generate and save records to database.

* model_name: CakePHP Model class name.
* number_of_generation: Generated number of records
* callback: it can overwrite each generated attributes

#### Example

	Fabricate::create('Post', 10, function($data){
		return ["created" => "2013-10-09 12:40:28", "updated" => "2013-10-09 12:40:28"];
	});


## Contributing to this Plugin

Please feel free to contribute to the plugin with new issues, requests, unit tests and code fixes or new features.
If you want to contribute some code, create a feature branch from develop, and send us your pull request.

