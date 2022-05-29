<?php declare(strict_types=1);
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Framework\Mapping\Annotation;

/**
 * Path annotation trait.
 */
trait PathTrait
{
    /**
     * Pattern path.
     *
     * @var string
     */
    protected string $pattern;

    /**
     * Pattern path placeholders regex.
     *
     * @var array
     */
    protected array $placeholders = [];

    /**
     * Pattern parameters.
     *
     * @var array
     */
    protected array $parameters = [];

    /**
     * Get pattern path.
     *
     * @return string|null
     */
    public function getPattern(): ?string
    {
        return $this->pattern;
    }

    /**
     * Set pattern path.
     *
     * @param string $pattern
     *
     * @return Group|PathTrait|Route
     */
    public function setPattern(string $pattern): self
    {
        $this->pattern = $pattern;

        return $this;
    }

    /**
     * Get pattern placeholders regex.
     *
     * @return array
     */
    public function getPlaceholders(): array
    {
        return $this->placeholders;
    }

    /**
     * Set pattern placeholders regex.
     *
     * @param array $placeholders
     *
     * @return Group|PathTrait|Route
     */
    public function setPlaceholders(array $placeholders): self
    {
        $this->placeholders = $placeholders;

        return $this;
    }

    /**
     * Get parameters.
     *
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * Set parameters.
     *
     * @param array $parameters
     *
     * @return Group|PathTrait|Route
     */
    public function setParameters(array $parameters): self
    {
        $this->parameters = $parameters;

        return $this;
    }
}