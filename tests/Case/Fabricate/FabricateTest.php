<?php
namespace Test\Fabricate;

use Fabricate\Fabricate;
use Fabricate\Adaptor\FabricateArrayAdaptor;
use Fabricate\Model\FabricateModel;

/**
 * Fabricate class test case
 */
class FabricateTest extends \PHPUnit_Framework_TestCase {
    public function setUp() {
        parent::setUp();
        Fabricate::clear();
        $adaptor = new FabricateArrayAdaptor();
        $adaptor::$definitions = [
            'Post' => (new FabricateModel('Post'))
                ->addColumn('id', 'integer')
                ->addColumn('author_id', 'integer', ['null' => false])
                ->addColumn('title', 'string', ['null' => false, 'limit' => 50])
                ->addColumn('body', 'text')
                ->addColumn('published', 'string', ['limit' => 1])
                ->addColumn('created', 'datetime')
                ->addColumn('updated', 'datetime')
                ->belongsTo('Author', 'author_id', 'User'),
            'User' => (new FabricateModel('User'))
                ->addColumn('id', 'integer')
                ->addColumn('user', 'string', ['null' => true, 'limit' => 255])
                ->addColumn('password', 'string', ['null' => true, 'limit' => 255])
                ->addColumn('created', 'datetime')
                ->addColumn('updated', 'datetime')
                ->hasMany('Post', 'author_id'),
        ];
        Fabricate::config(function($config) use($adaptor) {
            $config->adaptor = $adaptor;
        });
    }

    public function testAttributesFor() {
        $results = Fabricate::attributes_for('Post', 10, function($data){
            return ["created" => "2013-10-09 12:40:28", "updated" => "2013-10-09 12:40:28"];
        });
        $this->assertCount(10, $results);
        for ($i = 0; $i < 10; $i++) { 
            $this->assertEquals($i+1, $results[$i]['id']);
            $this->assertEquals($i+1, $results[$i]['author_id']);
            $this->assertEquals(50, strlen($results[$i]['title']));
            $this->assertNotEmpty($results[$i]['body']);
            $this->assertEquals(1, strlen($results[$i]['published']));
            $this->assertEquals('2013-10-09 12:40:28', $results[$i]['created']);
            $this->assertEquals('2013-10-09 12:40:28', $results[$i]['updated']);
        }
    }

    public function testBuild() {
        $result = Fabricate::build('Post', function($data){
            return ["created" => "2013-10-09 12:40:28", "updated" => "2013-10-09 12:40:28"];
        });
        $this->assertEquals(1, $result['Post']['id']);
        $this->assertEquals(1, $result['Post']['author_id']);
        $this->assertEquals(50, strlen($result['Post']['title']));
        $this->assertNotEmpty($result['Post']['body']);
        $this->assertEquals(1, strlen($result['Post']['published']));
        $this->assertEquals('2013-10-09 12:40:28', $result['Post']['created']);
        $this->assertEquals('2013-10-09 12:40:28', $result['Post']['updated']);
    }

    public function testCreate() {
        $results = Fabricate::create('Post', 10, function($data){
            return ["created" => "2013-10-09 12:40:28", "updated" => "2013-10-09 12:40:28"];
        });
        $this->assertCount(10, $results);
        for ($i = 0; $i < 10; $i++) { 
            $this->assertEquals($i+1, $results[$i]['Post']['id']);
            $this->assertEquals($i+1, $results[$i]['Post']['author_id']);
            $this->assertEquals(50, strlen($results[$i]['Post']['title']));
            $this->assertNotEmpty($results[$i]['Post']['body']);
            $this->assertEquals(1, strlen($results[$i]['Post']['published']));
            $this->assertEquals('2013-10-09 12:40:28', $results[$i]['Post']['created']);
            $this->assertEquals('2013-10-09 12:40:28', $results[$i]['Post']['updated']);
        }
    }

    public function testAttributesForWithArrayOption() {
        $results = Fabricate::attributes_for('Post', 10, ["created" => "2013-10-09 12:40:28", "updated" => "2013-10-09 12:40:28"]);
        $this->assertCount(10, $results);
        for ($i = 0; $i < 10; $i++) { 
            $this->assertEquals($i+1, $results[$i]['id']);
            $this->assertEquals($i+1, $results[$i]['author_id']);
            $this->assertEquals(50, strlen($results[$i]['title']));
            $this->assertNotEmpty($results[$i]['body']);
            $this->assertEquals(1, strlen($results[$i]['published']));
            $this->assertEquals('2013-10-09 12:40:28', $results[$i]['created']);
            $this->assertEquals('2013-10-09 12:40:28', $results[$i]['updated']);
        }
    }

    public function testBuildWithArrayOption() {
        $result = Fabricate::build('Post', ["created" => "2013-10-09 12:40:28", "updated" => "2013-10-09 12:40:28"]);
        $this->assertEquals(1, $result['Post']['id']);
        $this->assertEquals(1, $result['Post']['author_id']);
        $this->assertEquals(50, strlen($result['Post']['title']));
        $this->assertNotEmpty($result['Post']['body']);
        $this->assertEquals(1, strlen($result['Post']['published']));
        $this->assertEquals('2013-10-09 12:40:28', $result['Post']['created']);
        $this->assertEquals('2013-10-09 12:40:28', $result['Post']['updated']);
    }

    public function testCreateWithArrayOption() {
        $results = Fabricate::create('Post', 10, ["created" => "2013-10-09 12:40:28", "updated" => "2013-10-09 12:40:28"]);
        $this->assertCount(10, $results);

        $this->assertCount(10, $results);
        for ($i = 0; $i < 10; $i++) { 
            $this->assertEquals($i+1, $results[$i]['Post']['id']);
            $this->assertEquals($i+1, $results[$i]['Post']['author_id']);
            $this->assertEquals(50, strlen($results[$i]['Post']['title']));
            $this->assertNotEmpty($results[$i]['Post']['body']);
            $this->assertEquals(1, strlen($results[$i]['Post']['published']));
            $this->assertEquals('2013-10-09 12:40:28', $results[$i]['Post']['created']);
            $this->assertEquals('2013-10-09 12:40:28', $results[$i]['Post']['updated']);
        }
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

    public function testDefineNameOnlyOption() {
        Fabricate::define('Post', ['published'=>'1']);
        $results = Fabricate::attributes_for('Post');
        $this->assertEquals('1', $results[0]['published']);
    }

    public function testCreateWithAssociation() {
        $results = Fabricate::create('User', function($data, $world) {
            return [
                'user' => 'taro',
                'Post' => $world->association('Post', 3, ['id'=>false,'author_id'=>false]),
            ];
        });

        $this->assertEquals('taro', $results['User']['user']);
        $this->assertCount(3, $results['User']['Post']);
    }

    public function testCreateWithDefinedAssociation() {
        Fabricate::define(['PublishedPost', 'class'=>'Post'], ['published'=>'1']);
        $results = Fabricate::create('User', function($data, $world) {
            return [
                'user' => 'taro',
                'Post' => $world->association(['PublishedPost', 'association'=>'Post'], 3, ['id'=>false,'author_id'=>false]),
            ];
        });

        $this->assertEquals('taro', $results['User']['user']);
        $this->assertCount(3, $results['User']['Post']);
    }

    public function testCreateWithBelongsToAssociation() {
        Fabricate::define(['PublishedPost', 'class'=>'Post'], ['published'=>'1']);
        $results = Fabricate::create('PublishedPost', 3, function($data, $world) {
            return [
                'Author' => $world->association(['User', 'association'=>'Author'], ['id'=>1,'user'=>'taro']),
            ];
        });

        $this->assertEquals('taro', $results[0]['Post']['Author']['user']);
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
        Fabricate::define(['PublishedPost', 'class'=>'Post'], function($data, $world) {
            $world->traits('published');
            return ['title'=>$world->sequence('title',function($i) { return "Title{$i}"; })];
        });
        $results = Fabricate::create('User', function($data, $world) {
            return [
                'user' => 'taro',
                'Post' => Fabricate::association('PublishedPost', 3, ['id'=>false,'author_id'=>false]),
            ];
        });

        $this->assertEquals('taro', $results['User']['user']);
        $this->assertEquals(['1','1','1'], array_map(function($post) { return $post['published']; }, $results['User']['Post']));
        $this->assertEquals(['Title1','Title2','Title3'], array_map(function($post) { return $post['title']; }, $results['User']['Post']));
    }

}
