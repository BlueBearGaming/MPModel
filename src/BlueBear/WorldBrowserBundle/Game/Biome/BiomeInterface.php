<?php

namespace BlueBear\WorldBrowserBundle\Game\Biome;

use BlueBear\WorldBrowserBundle\Game\Map\CellInterface;

/**
 * Defines a biome
 */
interface BiomeInterface
{
    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * Get the amount of moisture present on this cell for this turn
     *
     * @param CellInterface $cell
     *
     * @return int
     */
    public function getMoisture(CellInterface $cell): int;
}
