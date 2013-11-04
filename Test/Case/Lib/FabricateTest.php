<?php

App::uses('Fabricate', 'Fabricate.Lib');

/**
 * Post class
 *
 * @package       Cake.Test.Case.Model
 */
class Post extends CakeTestModel {
}

/**
 * Fabricate class test case
 */
class FabricateTest extends CakeTestCase {
	public $fixtures = ['plugin.fabricate.post'];

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


}
