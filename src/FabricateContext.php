<?php
/**
 * Fabricate
 * *
 * @package    Fabricate
 */
namespace Fabricate;

/**
 * Fabricator Context
 */
class FabricateContext
{

    /**
     * Sequence Hash map
     *
     * @var array
     */
    private $sequences = [];

    /**
     * Trait use array
     *
     * @var array
     */
    private $traits = [];

    /**
     * Fabricate config
     *
     * @var array
     */
    private $config;

    /**
     * Fabricateing Model instance
     * @var Fabricate\Model\FabricateModel
     */
    private $model;

    /**
     * Construct with Configuration
     *
     * @param array $conf configuration
     * @param Fabricate\Model\FabricateModel $model model instance
     */
    public function __construct($conf, $model = null)
    {
        $this->config = $conf;
        $this->model = $model;
    }

    /**
     * sequence allows you to get a series of numbers unique within the fabricate context.
     *
     * @param string $name sequence name
     * @param int $start If you want to specify the starting number, you can do it with a second parameter.
     *         default value is 1.
     * @param callback $callback If you are generating something like an email address,
     *         you can pass it a block and the block response will be returned.
     * @return mixed generated sequence
     */
    public function sequence($name, $start = null, $callback = null)
    {
        if (is_callable($start)) {
            $callback = $start;
            $start = null;
        }
        if (!array_key_exists($name, $this->sequences)) {
            if ($start === null) {
                $start = $this->config->sequence_start;
            }
            $this->sequences[$name] = new FabricateSequence($start);
        }
        $ret = $this->sequences[$name]->current();
        if (is_callable($callback)) {
            $ret = $callback($ret);
        }
        $this->sequences[$name]->next();
        return $ret;
    }

    /**
     * Add apply trait in the scope.
     *
     * @param string|array $name use trait name(s)
     * @return void
     */
    public function traits($name)
    {
        if (is_array($name)) {
            $this->traits = array_merge($this->traits, $name);
        } else {
            $this->traits[] = $name;
        }
    }

    /**
     * Flush trait stack in the scope
     *
     * @return array flushed trait stack
     */
    public function flashTraits()
    {
        $traits = $this->traits;
        $this->traits = [];
        return $traits;
    }

    /**
     * Only create model attributes array for association.
     *
     * @param mixed $association association name
     * @param int $recordCount count for creating.
     * @param mixed $callback callback or array can change fablicated data if you want to overwrite
     * @return array model attributes array.
     */
    public function association($association, $recordCount = 1, $callback = null)
    {
        if (!is_array($association)) {
            $association = [$association, 'association' => $association];
        }
        $attributes = Fabricate::association($association[0], $recordCount, $callback);
        if ($this->model) {
            $associations = $this->model->getAssociated();
            if (isset($associations[$association['association']])
            && $associations[$association['association']] !== 'hasMany'
            && !empty($attributes)) {
                $attributes = $attributes[0];
            }
        }
        return $attributes;
    }

    /**
     * Get Faker instance.
     *
     * @return Faker\Generator
     */
    public function faker()
    {
        return $this->config->faker;
    }
}
