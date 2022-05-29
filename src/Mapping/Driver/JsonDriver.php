<?php declare(strict_types=1);

namespace Ares\Framework\Mapping\Driver;

use Jgut\Mapping\Driver\AbstractMappingDriver;
use Jgut\Mapping\Driver\Traits\JsonMappingTrait;

/**
 * JSON mapping driver.
 */
class JsonDriver extends AbstractMappingDriver
{
    use JsonMappingTrait;
    use MappingTrait;
}