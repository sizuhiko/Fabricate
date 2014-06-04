<?php

App::uses('Fabricate', 'Fabricate.Lib');

/**
 * User class
 *
 * @package       Cake.Test.Case.Model
 */
class User extends CakeTestModel {
	public $hasMany = [
		'Post' => ['foreignKey' => 'author_id']
	];
}

/**
 * Post class
 *
 * @package       Cake.Test.Case.Model
 */
class Post extends CakeTestModel {
	public $belongsTo = [
		'Author' => ['className' => 'User', 'foreignKey' => 'author_id'],
	];
}

/**
 * Fabricate class test case
 */
class FabricateTest extends CakeTestCase {
	public $fixtures = ['plugin.fabricate.post', 'plugin.fabricate.user'];

	public function setUp() {
		parent::setUp();
		Fabricate::clear();
	}

	public function testAttributesFor() {
		$results = Fabricate::attributes_for('Post', 10, function($data){
			return ["created" => "2013-10-09 12:40:28", "updated" => "2013-10-09 12:40:28"];
		});
		$this->assertCount(10, $results);
		$expected = [
			"id"=>5, 
			"author_id"=>5, 
			"title"=>"Lorem ipsum dolor sit amet",
			"body"=>"Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.",
			"published"=>"Lorem ipsum dolor sit ame",
			"created"=>"2013-10-09 12:40:28",
			"updated"=>"2013-10-09 12:40:28"
		];
		$this->assertEquals($expected, $results[4]);
	}

	public function testBuild() {
		$result = Fabricate::build('Post', function($data){
			return ["created" => "2013-10-09 12:40:28", "updated" => "2013-10-09 12:40:28"];
		});
		$this->assertInstanceOf('Post', $result);
		$expected = [
			"id"=>1, 
			"author_id"=>1, 
			"title"=>"Lorem ipsum dolor sit amet",
			"body"=>"Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.",
			"published"=>"Lorem ipsum dolor sit ame",
			"created"=>"2013-10-09 12:40:28",
			"updated"=>"2013-10-09 12:40:28"
		];
		$this->assertEquals($expected, $result->data['Post']);
	}

	public function testCreate() {
		Fabricate::create('Post', 10, function($data){
			return ["created" => "2013-10-09 12:40:28", "updated" => "2013-10-09 12:40:28"];
		});
		$model = ClassRegistry::init('Post');
		$results = $model->find('all');
		$this->assertCount(10, $results);

		$expected = [
			"id"=>'5', 
			"author_id"=>'5', 
			"title"=>"Lorem ipsum dolor sit amet",
			"body"=>"Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.",
			"published"=>"L",
			"created"=>"2013-10-09 12:40:28",
			"updated"=>"2013-10-09 12:40:28"
		];
		$this->assertEquals($expected, $results[4]['Post']);
	}

	public function testAttributesForWithArrayOption() {
		$results = Fabricate::attributes_for('Post', 10, ["created" => "2013-10-09 12:40:28", "updated" => "2013-10-09 12:40:28"]);
		$this->assertCount(10, $results);
		$expected = [
			"id"=>5, 
			"author_id"=>5, 
			"title"=>"Lorem ipsum dolor sit amet",
			"body"=>"Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.",
			"published"=>"Lorem ipsum dolor sit ame",
			"created"=>"2013-10-09 12:40:28",
			"updated"=>"2013-10-09 12:40:28"
		];
		$this->assertEquals($expected, $results[4]);
	}

	public function testBuildWithArrayOption() {
		$result = Fabricate::build('Post', ["created" => "2013-10-09 12:40:28", "updated" => "2013-10-09 12:40:28"]);
		$this->assertInstanceOf('Post', $result);
		$expected = [
			"id"=>1, 
			"author_id"=>1, 
			"title"=>"Lorem ipsum dolor sit amet",
			"body"=>"Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.",
			"published"=>"Lorem ipsum dolor sit ame",
			"created"=>"2013-10-09 12:40:28",
			"updated"=>"2013-10-09 12:40:28"
		];
		$this->assertEquals($expected, $result->data['Post']);
	}

	public function testCreateWithArrayOption() {
		Fabricate::create('Post', 10, ["created" => "2013-10-09 12:40:28", "updated" => "2013-10-09 12:40:28"]);
		$model = ClassRegistry::init('Post');
		$results = $model->find('all');
		$this->assertCount(10, $results);

		$expected = [
			"id"=>'5', 
			"author_id"=>'5', 
			"title"=>"Lorem ipsum dolor sit amet",
			"body"=>"Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.",
			"published"=>"L",
			"created"=>"2013-10-09 12:40:28",
			"updated"=>"2013-10-09 12:40:28"
		];
		$this->assertEquals($expected, $results[4]['Post']);
	}

	public function testConfigureSequenceStart() {
		Fabricate::config(function($config) {
			$config->sequence_start = 100;
		});
		$results = Fabricate::attributes_for('Post', 10);
		$this->assertEquals(100, $results[0]['id']);
		$this->assertEquals(109, $results[9]['id']);
	}

	public function testCreateUsingSequence() {
		Fabricate::config(function($config) {
			$config->sequence_start = 100;
		});
		$results = Fabricate::attributes_for('Post', 10, function($data, $world){
			return [
				'id'=> $world->sequence('id'),
				'title'=> $world->sequence('title', 1, function($i){ return "Title {$i}"; })
			];
		});
		$this->assertEquals(100, $results[0]['id']);
		$this->assertEquals('Title 1', $results[0]['title']);
		$this->assertEquals(109, $results[9]['id']);
		$this->assertEquals('Title 10', $results[9]['title']);
	}

	/**
	 * @dataProvider exampleInvalidDefineParameter
	 * @expectedException InvalidArgumentException
	 */
	public function testDefineThrowExceptionIfInvalidParameter($name, $case) {
		Fabricate::define($name, ['title'=>'title'], $case);
	}
	public function exampleInvalidDefineParameter() {
		return [
			['', 'Empty name'],
			[['', 'class'=>'Post'], 'Empty name'],
			[['Test', 'parent'=>'NotDefine'], 'No defined parent'],
			[['Manager', 'class'=>'Person'], 'Not found class'],
		];
	}

	public function testDefineUseClassOption() {
		Fabricate::define(['PublishedPost', 'class'=>'Post'], ['published'=>'1']);
		$results = Fabricate::attributes_for('PublishedPost');
		$this->assertEquals('1', $results[0]['published']);
	}

	public function testDefineUseNestedOption() {
		Fabricate::define(['PublishedPost', 'class'=>'Post'], ['published'=>'1']);
		Fabricate::define(['Author5PublishedPost', 'parent'=>'PublishedPost'], ['author_id'=>'5']);
		$results = Fabricate::attributes_for('Author5PublishedPost');
		$this->assertEquals('1', $results[0]['published']);
		$this->assertEquals('5', $results[0]['author_id']);
	}

	public function testCreateOverwritesAnyPrimaryKeyInputWithAnEmptyIfFilterKeyIsTrue() {
		Fabricate::config(function($config) {
			$config->filter_key = true;
		});
		Fabricate::create('Post', ["id"=>5,"created" => "2013-10-09 12:40:28", "updated" => "2013-10-09 12:40:28"]);
		$model = ClassRegistry::init('Post');
		$results = $model->find('all');
		$this->assertEquals(1, $results[0]['Post']['id']);
	}

	public function testDefineNameOnlyOption() {
		Fabricate::define('Post', ['published'=>'1']);
		$results = Fabricate::attributes_for('Post');
		$this->assertEquals('1', $results[0]['published']);
	}

	public function testSaveWithAssociation() {
		Fabricate::define(['PublishedPost', 'class'=>'Post'], ['published'=>'1']);
		Fabricate::create('User', function($data, $world) {
			return [
				'user' => 'taro',
				'Post' => Fabricate::association('PublishedPost', 3, ['id'=>false,'author_id'=>false]),
			];
		});

		$model = ClassRegistry::init('User');
		$results = $model->find('first', ['contain'=>['Post']]);
		$this->assertEquals('taro', $results['User']['user']);
		$this->assertCount(3, $results['Post']);
	}

	public function testDefineAndUseTrait() {
		Fabricate::define(['trait'=>'published'], ['published'=>'1']);
		$results = Fabricate::attributes_for('Post', function($data, $world) {
			$world->traits('published');
			return ['id'=>false];
		});
		$this->assertEquals('1', $results[0]['published']);
	}

	public function testDefineAndUseMultiTrait() {
		Fabricate::define(['trait'=>'published'], ['published'=>'1']);
		Fabricate::define(['trait'=>'author5'],   function($data, $world) { return ['author_id'=>5]; });
		$results = Fabricate::attributes_for('Post', function($data, $world) {
			$world->traits(['published','author5']);
			return ['id'=>false];
		});
		$this->assertEquals('1', $results[0]['published']);
		$this->assertEquals(5, $results[0]['author_id']);
	}

	public function testDefineAndAssociationAndTraits() {
		Fabricate::define(['trait'=>'published'], ['published'=>'1']);
		Fabricate::define(['PublishedPost', 'class'=>'Post'], function($data, $world) { return ['published'=>'1']; });
		Fabricate::create('User', function($data, $world) {
			return [
				'user' => 'taro',
				'Post' => Fabricate::association('PublishedPost', 3, ['id'=>false,'author_id'=>false]),
			];
		});

		$model = ClassRegistry::init('User');
		$results = $model->find('first', ['contain'=>['Post']]);
		$this->assertEquals('taro', $results['User']['user']);
		$this->assertEquals(['1','1','1'], Hash::extract($results, 'Post.{n}.published'));
	}

}
