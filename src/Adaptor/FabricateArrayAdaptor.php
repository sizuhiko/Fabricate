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
class FabricateArrayAdaptor extends AbstractFabricateAdaptor {
    /** definitions of all schema and association */
    public static $definitions;

    /**
     * @inherit
     */
    public function getModel($modelName) {
        if(array_key_exists($modelName, self::$definitions)) {
            return self::$definitions[$modelName];
        }
        return null;
    }
}
