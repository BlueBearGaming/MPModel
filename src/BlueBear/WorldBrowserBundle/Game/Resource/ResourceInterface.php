<?php

namespace BlueBear\WorldBrowserBundle\Game\Resource;

use BlueBear\WorldBrowserBundle\Game\Map\CellInterface;

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
     * Give the available quantity at a given round
     *
     * @param CellInterface $cell
     *
     * @return int
     */
    public function getAvailableQuantity(CellInterface $cell): int;

    /**
     * @param CellInterface $cell
     * @param int           $quantity
     */
    public function extract(CellInterface $cell, int $quantity): void;
}
