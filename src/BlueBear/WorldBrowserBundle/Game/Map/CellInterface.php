<?php

namespace BlueBear\WorldBrowserBundle\Game\Map;

use BlueBear\WorldBrowserBundle\Game\Biome\BiomeInterface;

/**
 * Each cell represents a location on the map and contains elements
 */
interface CellInterface extends CoordinatedInterface
{
    /**
     * @return CoordinatedInterface[]
     */
    public function getElements(): array;

    /**
     * @param string $type
     *
     * @return array
     */
    public function getElementsByType(string $type): array;

    /**
     * Get the amount of moisture present on this cell for this turn
     *
     * @return int
     */
    public function getMoisture(): int;

    /**
     * @param int $moisture
     */
    public function setMoisture(int $moisture): void;

    /**
     * @return BiomeInterface
     */
    public function getBiome(): BiomeInterface;

    /**
     * @param BiomeInterface $biome
     */
    public function setBiome(BiomeInterface $biome): void;
}