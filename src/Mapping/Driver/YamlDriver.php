<?php declare(strict_types=1);

namespace Ares\Framework\Mapping\Driver;

use Jgut\Mapping\Driver\AbstractMappingDriver;
use Jgut\Mapping\Driver\Traits\YamlMappingTrait;

/**
 * YAML mapping driver.
 */
class YamlDriver extends AbstractMappingDriver
{
    use YamlMappingTrait;
    use MappingTrait;
}