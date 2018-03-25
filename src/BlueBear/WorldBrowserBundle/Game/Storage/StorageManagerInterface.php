<?php

namespace BlueBear\WorldBrowserBundle\Game\Storage;

use BlueBear\WorldBrowserBundle\Game\Map\CoordinatedInterface;

/**
 * Common methods for storage adapters
 */
interface StorageManagerInterface
{
    /**
     * Return type depends of the needs
     *
     * @param string               $class
     * @param CoordinatedInterface $position
     *
     * @return CoordinatedInterface[]
     */
    public function getElements(string $class, CoordinatedInterface $position): array;

    /**
     * @param string               $class
     * @param CoordinatedInterface $position
     * @param CoordinatedInterface $element
     */
    public function addElement(string $class, CoordinatedInterface $position, CoordinatedInterface $element): void;
}
