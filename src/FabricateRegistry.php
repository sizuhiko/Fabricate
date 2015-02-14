<?php
/**
 * Fabricate
 *
 * @package    Fabricate
 */
namespace Fabricate;

/**
 * Fabricator Registry Class
 */
class FabricateRegistry
{

    /**
     * the register name
     *
     * @var string
     */
    private $name;

    /**
     * registerd items
     *
     * @var array
     */
    private $items;

    /**
     * adaptor
     *
     * @var Fabricate\Adaptor\AbstractFabricateAdaptor
     */
    private $adaptor;

    /**
     * Construct with registry name
     *
     * @param string $name registry name
     * @param Fabricate\Adaptor\AbstractFabricateAdaptor $adaptor
     * @return void
     */
    public function __construct($name, $adaptor)
    {
        $this->name  = $name;
        $this->adaptor = $adaptor;
        $this->items = [];
    }

    /**
     * Clear registerd entries
     *
     * @return void
     */
    public function clear()
    {
        $this->items = [];
    }

    /**
     * Find from registred or model by name
     *
     * @param string $name model name
     * @return mixed registerd object
     * @throws InvalidArgumentException
     */
    public function find($name)
    {
        if ($this->is_registered($name)) {
            return $this->items[$name];
        }
        $model = $this->adaptor->getModel($name);
        if ($model) {
            return $model;
        }
        throw new \InvalidArgumentException("{$name} not registered");
    }

    /**
     * Regist to registries
     *
     * @param string $name name
     * @param FabricateDefinition $item item
     * @return void
     */
    public function register($name, $item)
    {
        $this->items[$name] = $item;
    }

    /**
     * Is registered?
     *
     * @param string $name name
     * @return bool
     */
    public function is_registered($name)
    {
        return array_key_exists($name, $this->items);
    }

    /**
     * Set Adaptor
     *
     * @param Fabricate\Adaptor\AbstractFabricateAdaptor $adaptor
     */
    public function setAdaptor($adaptor)
    {
        $this->adaptor = $adaptor;
    }
}
