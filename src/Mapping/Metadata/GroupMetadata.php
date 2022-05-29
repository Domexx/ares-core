<?php declare(strict_types=1);
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Framework\Mapping\Metadata;

/**
 * Group metadata.
 */
class GroupMetadata extends AbstractMetadata
{
    /**
     * Parent group metadata.
     *
     * @var self
     */
    protected GroupMetadata $parent;

    /**
     * Route prefix.
     *
     * @var string
     */
    protected string $prefix;

    /**
     * Get parent group.
     *
     * @return GroupMetadata|null
     */
    public function getParent(): ?self
    {
        return $this->parent;
    }

    /**
     * Set parent group.
     *
     * @param self $parent
     *
     * @return self
     */
    public function setParent(self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get route prefix.
     *
     * @return string|null
     */
    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    /**
     * Set route prefix.
     *
     * @param string $prefix
     *
     * @return self
     */
    public function setPrefix(string $prefix): self
    {
        $this->prefix = $prefix;

        return $this;
    }
}