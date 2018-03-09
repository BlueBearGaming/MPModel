<?php

namespace BlueBear\WorldBrowserBundle\Loader;

use BlueBear\EAVModelBundle\Entity\DataRepository;
use BlueBear\WorldBrowserBundle\Model\Map;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Sidus\EAVModelBundle\Entity\DataInterface;
use Sidus\EAVModelBundle\Model\FamilyInterface;
use Sidus\EAVModelBundle\Registry\FamilyRegistry;
use Sidus\EAV;

class WorldMapLoader
{
    /** @var DataRepository */
    protected $dataRepository;

    /** @var FamilyInterface */
    protected $coordinatedFamily;

    /**
     * @param Registry       $doctrine
     * @param FamilyRegistry $familyRegistry
     */
    public function __construct(Registry $doctrine, FamilyRegistry $familyRegistry)
    {
        $this->coordinatedFamily = $familyRegistry->getFamily('Coordinated');
        $this->dataRepository = $doctrine->getRepository($this->coordinatedFamily->getDataClass());
    }

    /**
     * @param DataInterface|EAV\World $world
     * @return Map
     */
    public function loadMap(DataInterface $world)
    {
        $map = new Map($world);
        $qb = $this->dataRepository->getQbByWorld($this->coordinatedFamily, $world);

        /** @var EAV\Coordinated $element */
        foreach ($qb->getQuery()->getResult() as $element) {
            $cell = $map->getCell($element->getX(), $element->getY());
            if ($cell) {
                $cell->addContent($element);
            }
        }

        return $map;
    }
}
