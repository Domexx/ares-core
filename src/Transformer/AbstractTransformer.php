<?php declare(strict_types=1);

namespace Ares\Framework\Transformer;

/**
 * Abstract parameter transformer.
 */
abstract class AbstractTransformer implements ParameterTransformer
{
    /**
     * {@inheritdoc}
     */
    public function transform(array $parameters, array $definitions): array
    {
        \array_walk(
            $parameters,
            function (string &$parameter, string $name) use ($definitions) {
                if (isset($definitions[$name])) {
                    $type = $definitions[$name];
                    $parameter = \in_array($type, ['string', 'int', 'float', 'bool'], true)
                        ? $this->transformToPrimitive($parameter, $type)
                        : $this->transformParameter($parameter, $definitions[$name]);
                }
            }
        );

        return $parameters;
    }

    /**
     * Transform parameter to primitive.
     *
     * @param string $parameter
     * @param string $type
     *
     * @return bool|float|int|string
     */
    protected function transformToPrimitive(string $parameter, string $type)
    {
        switch ($type) {
            case 'int':
                $parameter = (int) $parameter;
                break;

            case 'float':
                $parameter = (float) $parameter;
                break;

            case 'bool':
                $parameter = \in_array(\trim($parameter), ['1', 'on', 'yes', 'true'], true);
                break;
        }

        return $parameter;
    }

    /**
     * Transform parameter.
     *
     * @param string $parameter
     * @param string $type
     *
     * @return mixed
     */
    abstract protected function transformParameter(string $parameter, string $type);
}