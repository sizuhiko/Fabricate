[![Build Status](https://travis-ci.org/sizuhiko/Fabricate.svg?branch=v2)](https://travis-ci.org/sizuhiko/Fabricate) [![Coverage Status](https://coveralls.io/repos/sizuhiko/Fabricate/badge.png)](https://coveralls.io/r/sizuhiko/Fabricate) [![Total Downloads](https://poser.pugx.org/sizuhiko/fabricate/downloads.svg)](https://packagist.org/packages/sizuhiko/fabricate) [![Latest Stable Version](https://poser.pugx.org/sizuhiko/fabricate/v/stable.svg)](https://packagist.org/packages/sizuhiko/fabricate)

Fabricate
=========

PHP data generator for Testing

It's inspired on [Fabrication](https://github.com/paulelliott/fabrication) and [factory-girl](https://github.com/thoughtbot/factory_girl) from the Ruby world.

Fabricate is a simple fake object generation core library for PHP.
Quickly Fabricate objects as needed anywhere in your app or test case.

## Install 

Add require-dev in your composer.json

`composer require --dev sizuhiko/fabricate`

## Usage

### Adaptor

At first, Fabricate require to config for using.
For example, to override these settings, put a bootstrap.php in your app folder and append the path to phpunit.xml 

```php
use Fabricate\Fabricate;
use CakeFabricate\Adaptor\CakeFabricateAdaptor;

Fabricate::config(function($config) {
    $config->adaptor = new CakeFabricateAdaptor();
});
```

Fabricate doesn't provide adaptors.
If you will make adaptor of any frameworks, send us your pull request.
The pull request will include suggestion into composer.json and link of repository on README(Comunity Adaptors).

#### Comunity Adaptors

- [CakeFabricate for CakePHP3](https://github.com/sizuhiko/cakephp-fabricate-adaptor)
- Please contribute

### The Basics

The simplest way to generate objects

```php
Fabricate::create('Post')
```

That will generate and save to database an instance of Post using the schema information.

To set additional attributes or override what is in the Fabricator, you can pass a array to Fabricate with the fields you want to set.

```php
Fabricate::create('Post', ["created" => "2013-10-09 12:40:28", "updated" => "2013-10-09 12:40:28"])
```

### Fabricating With Blocks

In addition to the array, you can pass a callback function to Fabricate and all the features of a Fabricator definition are available to you at object generation time.

```php
Fabricate::create('Post', 10, function($data){
    return ["created" => "2013-10-09 12:40:28", "updated" => "2013-10-09 12:40:28"];
});
```

The hash will overwrite any fields defined in the callback function.

## APIs

### Configuration

To override these settings, put a bootstrap.php in your app folder and append the path to phpunit.xml 

```
Fabricate::config(function($config) {
    $config->sequence_start = 1;
    $config->adaptor = new Fabricate\Adaptor\CakePHPAdaptor();
    $config->faker = \Faker\Factory::create('ja_JP');
});
```

#### Supported Options

##### sequence_start

Allows you to specify the default starting number for all sequences. 
This can still be overridden for specific sequences.

`Default: 1`

##### adaptor

Adapters ease the population of databases through the Database accessor provided by an ORM library(or framework).

`Default: null`

##### faker

Allow you to specify the default Faker instance to return localized data.

`Default: default locale(en_EN) instance`

### Generate model attributes as array (not saved)

`Fabricate::attributes_for(:model_name, :number_of_generation, :array_or_callback)` generate only attributes.

* model_name: Model class name.
* number_of_generation: Generated number of records
* array_or_callback: it can override each generated attributes

#### Example

```php
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
```

### Generate a model instance (not saved)

`Fabricate::build(:model_name, :array_or_callback)` generate a model instance (using ClassRegistry::init).

* model_name: Model class name.
* array_or_callback: it can override each generated attributes

#### Example

```php
$result = Fabricate::build('Post', function($data){
    return ["created" => "2013-10-09 12:40:28", "updated" => "2013-10-09 12:40:28"];
});

// $results are depends adaptor result.
 ......
```

### Generate records to database

`Fabricate::create(:model_name, :number_of_generation, :array_or_callback)` generate and save records to database.

* model_name: Model class name.
* number_of_generation: Generated number of records
* array_or_callback: it can override each generated attributes

#### Example

```php
Fabricate::create('Post', 10, function($data){
    return ["created" => "2013-10-09 12:40:28", "updated" => "2013-10-09 12:40:28"];
});
```

## Defining 

Fabricate has a name and a set of attributes when fabricating objects.
The name is used to guess the class of the object by default, 

```php
Fabricate::define('Post', ['published'=>'1']);
// or using callback block
Fabricate::define('Post', function($data, $world) {
    return ['published'=>'1']
});
```

To use a different name from the class, you must specify 'class'=>:class_name into first argument as array.

```php
Fabricate::define(['PublishedPost', 'class'=>'Post'], ['published'=>'1']);

Fabricate::create('PublishedPost');
```

You can inherit attributes from other defined set of attributes by using the 'parent' key.

```php
Fabricate::define(['PublishedPost', 'class'=>'Post'], ['published'=>'1']);
Fabricate::define(['Author5PublishedPost', 'parent'=>'PublishedPost'], ['author_id'=>'5']);

Fabricate::create('Author5PublishedPost');
```
## Associations

It's possible to set up associations(hasOne/hasMany/belongsTo) within Fabricate::create().
You can also specify a FabricateContext::association().
It will generate the attributes, and set(merge) it in the current array. 

### Usage

```php
Fabricate::create('User', function($data, $world) {
    return [
        'user' => 'taro',
        'Post' => $world->association('Post', 3),
    ];
});
// or can overwritten by array or callback block.
Fabricate::create('User', function($data, $world) {
    return [
        'user' => 'taro',
        'Post' => $world->association('Post', 3, function($data, $world) {
            return ['title'=>$world->sequence('Post.title',function($i){ return "Title-${i}"; })];
        }),
    ];
});
// can use defined onbject.
Fabricate::define(['PublishedPost', 'class'=>'Post'], ['published'=>'1']);
Fabricate::create('User', function($data, $world) {
    return [
        'user' => 'taro',
        'Post' => $world->association(['PublishedPost', 'association'=>'Post'], 3),
    ];
});
// can use association alias (Post belongs to Author of User class)
Fabricate::define(['PublishedPost', 'class'=>'Post'], ['published'=>'1']);
Fabricate::create('PublishedPost', 3, function($data, $world) {
    return [
        'Author' => $world->association(['User', 'association'=>'Author'], ['id'=>1,'user'=>'taro']),
    ];
});
```

## Sequences

A sequence allows you to get a series of numbers unique within the each generation function. Fabrication provides you with an easy and flexible means for keeping track of sequences.

### Config

Allows you to specify the default starting number for all sequences. 
This can still be overridden for specific sequences.

```php
Fabricate::config(function($config) {
    $config->sequence_start = 100;
});
```

### Usage

```php
Fabricate::config(function($config) {
    $config->sequence_start = 100;
});
$results = Fabricate::attributes_for('Post', 10, function($data, $world){
    return [
        'id'=> $world->sequence('id'),
        'title'=> $world->sequence('title', 1, function($i){ return "Title {$i}"; })
    ];
});

// $results is followings :
array (
  0 => 
  array (
    'id' => 100,           // starting configure sequence
    'title' => 'Title 1',  // closure function returned 
    ...
  ),
  1 => 
  array (
    'id' => 101,           // starting configure sequence
    'title' => 'Title 2',  // closure function returned 
    ...
```

If you want use sequence within generation function, callback has second attribute.
`$world` is FabricateContext instance. It have sequence method.

### FabricateContext#sequence API

You should set name argument to sequence.

```php
$world->sequence('id')
```

If you want to specify the starting number, you can do it with a second parameter.
It will always return the seed number on the first call and it will be ignored with subsequent calls.

```php
$world->sequence('id', 10)
```

If you are generating something like an unique string, you can pass it a callback function and the callback function response will be returned.

```php
$world->sequence('title', function($i){ return "Title {$i}"; }
// or with start number
$world->sequence('title', 1, function($i){ return "Title {$i}"; }
```

## Traits

Traits allow you to group attributes together and then apply them to any fabricating objects.

```php
Fabricate::define(['trait'=>'published'], ['published'=>'1']);
Fabricate::create('Post', function($data, $world) {
    $world->traits('published');
    return ['author_id'=>5];
});
```

`traits` can specify defined names as array

```php
Fabricate::define(['trait'=>'published'], ['published'=>'1']);
Fabricate::define(['trait'=>'author5'],   function($data, $world) { return ['author_id'=>5]; });
Fabricate::create('Post', function($data, $world) {
    $world->traits(['published','author5']);
    return [];
});
```

## Faker

Faker is a PHP library that generates fake data for you.
Fabrication provides you with generation custom value for own rule.

### Config

Faker supports a localization.
The default locale is en_EN.
Allows you to specify the locale. 
This can still be overridden for specific Faker Factory.

```php
Fabricate::config(function($config) {
    $config->faker = Faker\Factory::create('ja_JP');
});
```

### Usage

```php
Fabricate::config(function($config) {
    $config->faker = Faker\Factory::create('ja_JP'); // this is optional
});

$results = Fabricate::attributes_for('User', function($data, $world){
    return [
        'user'=> $world->faker()->name
    ];
});
```

## Reloading

If you need to reset fabricate back to its original state after it has been loaded.

```php
Fabricate::clear();
```

## Contributing to this Library

Please feel free to contribute to the library with new issues, requests, unit tests and code fixes or new features.
If you want to contribute some code, create a feature branch from develop, and send us your pull request.

