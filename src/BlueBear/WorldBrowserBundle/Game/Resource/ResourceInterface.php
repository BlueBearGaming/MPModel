<?php

namespace BlueBear\WorldBrowserBundle\Game\Resource;

use BlueBear\WorldBrowserBundle\Game\Map\CoordinatedInterface;

/**
 * Defines the behavior of an in-game resource
 */
interface ResourceInterface
{
    /**
     * Unique code identifying the resource
     *
     * @return string
     */
    public function getCode(): string;

    /**
     * Use Z to define resource found at a given depth
     *
     * @param CoordinatedInterface $position
     *
     * @return int
     */
    public function getQuantity(CoordinatedInterface $position): int;
}