<?php

namespace BlueBear\WorldBrowserBundle\Generator;

use BlueBear\WorldBrowserBundle\Model\Map;
use Sidus\EAV\World;
use Sidus\EAVModelBundle\Entity\DataInterface;

class WorldMapGenerator
{
    /**
     * @param DataInterface|World $world
     * @return Map
     */
    public function generate(DataInterface $world)
    {
        $map = new Map($world);
        // @load time dependant variations / user modifications into map ?

        return $map;
    }
}