<?php

namespace BlueBear\WorldBrowserBundle\Loader;

use BlueBear\EAVModelBundle\Entity\DataRepository;
use BlueBear\WorldBrowserBundle\Model\Map;
use Sidus\EAV\Coordinated;
use Sidus\EAV\World;
use Sidus\EAVModelBundle\Entity\DataInterface;
use Sidus\EAVModelBundle\Model\FamilyInterface;

class WorldMapLoader
{
    /** @var DataRepository */
    protected $dataRepository;

    /** @var FamilyInterface */
    protected $coordinatedFamily;

    /**
     * WorldMapGenerator constructor.
     * @param DataRepository  $dataRepository
     * @param FamilyInterface $coordinatedFamily
     */
    public function __construct(DataRepository $dataRepository, FamilyInterface $coordinatedFamily)
    {
        $this->dataRepository = $dataRepository;
        $this->coordinatedFamily = $coordinatedFamily;
    }

    /**
     * @param DataInterface|World $world
     * @return Map
     */
    public function loadMap(DataInterface $world)
    {
        $map = new Map($world);
        $qb = $this->dataRepository->getQbByWorld($this->coordinatedFamily, $world);

        /** @var Coordinated $element */
        foreach ($qb->getQuery()->getResult() as $element) {
            $cell = $map->getCell($element->getX(), $element->getY());
            if ($cell) {
                $cell->addContent($element);
            }
        }

        return $map;
    }
}