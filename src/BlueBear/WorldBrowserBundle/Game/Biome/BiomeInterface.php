<?php

namespace BlueBear\WorldBrowserBundle\Game\Biome;

/**
 * Defines a biome
 */
interface BiomeInterface
{
    /**
     * @return string
     */
    public function getCode(): string;
}