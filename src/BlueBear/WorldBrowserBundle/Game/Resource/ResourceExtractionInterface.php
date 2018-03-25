<?php

namespace BlueBear\WorldBrowserBundle\Game\Resource;

use BlueBear\WorldBrowserBundle\Game\Map\CoordinatedInterface;

/**
 * This gets generated each time a resource is extracted from a cell
 */
interface ResourceExtractionInterface extends CoordinatedInterface
{
    /**
     * @param ResourceInterface    $resource
     * @param CoordinatedInterface $position
     * @param int                  $quantity
     *
     * @return ResourceExtractionInterface
     */
    public static function create(ResourceInterface $resource, CoordinatedInterface $position, int $quantity): self;

    /**
     * @return ResourceInterface
     */
    public function getResource(): ResourceInterface;

    /**
     * @return int
     */
    public function getQuantity(): int;
}
