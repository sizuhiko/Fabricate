<?php
/**
 * Fabricate
 * *
 * @package    Fabricate
 */
namespace Fabricate;

/**
 * Fabricator Configuration
 */
class FabricateConfig
{

    /**
     * start number for $world->sequence()
     *
     * @var int
     */
    public $sequence_start = 1;

    /**
     * adaptor
     *
     * @var Fabricate\Adaptor\AbstractFabricateAdaptor
     */
    public $adaptor = null;

    /**
     * Faker default instance.
     * The locale en_EN.
     * If you want to change locale then overwrite the value.
     *
     * @var Faker\Factory
     */
    public $faker = null;

    /**
     * Limit size for generation of text field
     *
     * @var int
     * @since 1.2.3
     */
    public $text_size_limit = 200;
}
