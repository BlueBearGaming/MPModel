<?php

namespace BlueBear\WorldBrowserBundle\Game\Exception;

use BlueBear\WorldBrowserBundle\Game\Map\CellInterface;
use BlueBear\WorldBrowserBundle\Game\Resource\ResourceInterface;

/**
 * Indicated that the system was trying to extract to much of a resource given it's availability
 */
class InsufficientResourceException extends \RuntimeException
{
    /**
     * @param ResourceInterface $resource
     * @param CellInterface     $cell
     * @param int               $quantity
     *
     * @return self
     */
    public static function create(ResourceInterface $resource, CellInterface $cell, int $quantity): self
    {
        $m = "Not enough resource '{$resource->getCode()}' available on cell {$cell->getX()}, {$cell->getZ()}. ";
        $m .= "Trying to extract {$quantity} but only {$resource->getAvailableQuantity($cell)} available";

        return new self($m);
    }
}
