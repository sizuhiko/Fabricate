<?php
/**
 * Fabricate
 *
 * @package    Fabricate
 * @subpackage Fabricate\Adaptor
 */
namespace Fabricate\Adaptor;

/**
 * Fabricate Array Model Adaptor for example your custom adaptor
 */
class FabricateArrayAdaptor extends AbstractFabricateAdaptor
{
    /** definitions of all schema and association */
    public static $definitions;

    /**
     * @inherit
     */
    public function getModel($modelName)
    {
        if (array_key_exists($modelName, self::$definitions)) {
            return self::$definitions[$modelName];
        }
        return null;
    }

    /**
     * @inherit
     */
    public function create($modelName, $attributes, $recordCount)
    {
        $results = array_map(function ($attribute) use ($modelName) {
            return [$modelName => $attribute];
        }, $attributes);
        return $recordCount == 1 ? $results[0] : $results;
    }

    /**
     * @inherit
     */
    public function build($modelName, $data)
    {
        return [$modelName => $data];
    }
}
