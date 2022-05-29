<?php declare(strict_types=1);
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Framework\Transformer;

/**
 * Parameter transformer interface.
 */
interface ParameterTransformer
{
    /**
     * Transform parameters.
     *
     * @param array $parameters
     * @param array $definitions
     *
     * @return array
     */
    public function transform(array $parameters, array $definitions): array;
}