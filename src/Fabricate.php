<?php
/**
 * Fabricate
 * *
 * @package    Fabricate
 */
namespace Fabricate;

use Fabricate\Factory\FabricateFactory;
use Fabricate\Definition\FabricateDefinition;

/**
 * Fabricator for CakePHP model.
 * This is inspired RSpec fablicator.
 */
class Fabricate {

/**
 * instance for singlethon
 *
 * @var Fabricate
 */
    private static $_instance = null;

/**
 * configuration
 *
 * @var FabricateConfig
 */
    private $config;

/**
 * registor for fabrications
 *
 * @var FabricateRegistry
 */
    private $registry;

/**
 * factory
 *
 * @var FabricateAbstractFactory
 */
    private $factory;

/**
 * trait definitions
 *
 * @var array
 */
    private $traits;

/**
 * Return Fabricator instance
 *
 * @return Fabricate
 */
    private static function getInstance() {
        if (self::$_instance == null) {
            self::$_instance = new Fabricate();
            self::$_instance->config = new FabricateConfig();
            self::$_instance->registry = new FabricateRegistry('Fabricate');
            self::$_instance->traits = [];
        }
        return self::$_instance;
    }

/**
 * Override constructor.
 */
    public function __construct() {
    }

/**
 * clear cached the instance
 *
 * @return void
 */
    public static function clear() {
        self::$_instance = null;
    }

/**
 * To override these settings
 *
 * @param mixed $callback can override $config(class of FabricateConfig) attributes 
 * @return void
 */
    public static function config($callback) {
        $callback(self::getInstance()->config);
    }

/**
 * Create and Save fablicated model data to database.
 *
 * @param string $modelName name of model or defined 
 * @param mixed $recordCount $recordCount number for creation or $callback if not require $recordCount
 * @param mixed $callback callback can chenge fablicated data if you want to overwrite
 * @return mixed results of creation
 */
    public static function create($modelName, $recordCount = 1, $callback = null) {
        $attributes = self::attributes_for($modelName, $recordCount, $callback);
        $instance = self::getInstance();
        $definition = $instance->definition($recordCount, $callback);
        $recordCount = $instance->recordCount($recordCount);
        return $instance->factory->create($attributes, $recordCount, $definition);
    }
/**
 * Only create a model instance.
 *
 * @param string $modelName name of model or defined 
 * @param mixed $callback callback can chenge fablicated data if you want to overwrite
 * @return Model Initializes the model for writing a new record
 */
    public static function build($modelName, $callback = null) {
        $data = self::attributes_for($modelName, 1, $callback);
        $instance = self::getInstance();
        $definition = $instance->definition(1, $callback);
        return $instance->factory->build($data, $definition);
    }
/**
 * Only create model attributes array.
 *
 * @param string $modelName name of model or defined 
 * @param mixed $recordCount $recordCount number for creation or $callback if not require $recordCount
 * @param mixed $callback callback can chenge fablicated data if you want to overwrite
 * @return array model attributes array.
 */
    public static function attributes_for($modelName, $recordCount = 1, $callback = null) {
        $instance = self::getInstance();
        $instance->factory = $instance->factory($modelName);
        $definition = $instance->definition($recordCount, $callback);
        $recordCount = $instance->recordCount($recordCount);
        return $instance->factory->attributes_for($recordCount, $definition);
    }

/**
 * Only create model attributes array for association.
 *
 * @param string $modelName name of model or defined 
 * @param mixed $recordCount $recordCount number for creation or $callback if not require $recordCount
 * @param mixed $callback callback can chenge fablicated data if you want to overwrite
 * @return array model attributes array.
 */
    public static function association($modelName, $recordCount = 1, $callback = null) {
        $instance = self::getInstance();
        $factory = $instance->factory($modelName);
        $definition = $instance->definition($recordCount, $callback);
        $recordCount = $instance->recordCount($recordCount);
        return $factory->attributes_for($recordCount, $definition);
    }

/**
 * Return defined traits.
 *
 * @return array registed trait definition
 */
    public static function traits() {
        return self::getInstance()->traits;
    }

/**
 * Define fabrication object
 *
 * @param mixed $name name or with attributes
 * @param mixed $define definition
 * @return void
 * @throws InvalidArgumentException
 */
    public static function define($name, $define) {
        $instance = self::getInstance();
        $parent = false;
        $base   = false;
        $trait  = false;
        if (is_array($name)) {
            $parent = array_key_exists('parent', $name)?$name['parent']:false;
            $base   = array_key_exists('class', $name)?$name['class']:false;
            if (array_key_exists('trait', $name)) {
                $name = $name['trait'];
                $parent = $base = false;
                $trait = true;
            } else {
                $name = $name[0];
            }
        }
        if (empty($name)) {
            throw new InvalidArgumentException("name is empty");
        }
        if ($parent && !$instance->registry->is_registered($parent)) {
            throw new InvalidArgumentException("parent `{$parent}` is not registered");
        }
        if ($base && in_array(ClassRegistry::init(['class' => $base, 'testing' => $instance->config->testing], true), [false, null])) {
            throw new InvalidArgumentException("class `{$base}` is not found");
        }
        $definition = new FabricateDefinition($define);
        if ($trait) {
            $instance->traits[$name] = $definition;
            return;
        }
        if (!$parent && !$base) {
            $base = $name;
        }
        $definition->parent = $parent?FabricateFactory::create($instance->registry->find($parent, $instance->config->testing)):false;
        $definition->parent = $base?FabricateFactory::create(ClassRegistry::init(['class' => $base, 'testing' => $instance->config->testing])):$definition->parent;
        $definition->parent->setConfig(self::getInstance()->config);

        $instance->registry->register($name, $definition);
    }

/**
 * create FabricateFactory
 *
 * @param string $name name
 * @return FabricateAbstractFactory
 */
    private function factory($name) {
        $factory = FabricateFactory::create(self::getInstance()->registry->find($name, self::getInstance()->config->testing));
        $factory->setConfig(self::getInstance()->config);
        return $factory;
    }

/**
 * get count for creation record
 *
 * @param mixed $recordCount number for creation or $callback if not require $recordCount
 * @return int
 */
    private function recordCount($recordCount) {
        if (is_callable($recordCount) || is_array($recordCount)) {
            $recordCount = 1;
        }
        return $recordCount;
    }

/**
 * create definition
 *
 * @param mixed $recordCount number for creation or $callback if not require $recordCount
 * @param callback|array $callback define block or array
 * @return FabricateDefinition created definition
 */
    private function definition($recordCount, $callback) {
        if (is_callable($recordCount) || is_array($recordCount)) {
            $callback = $recordCount;
        }
        return new FabricateDefinition($callback);
    }
}