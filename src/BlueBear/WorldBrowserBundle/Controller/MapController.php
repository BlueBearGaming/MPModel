<?php

namespace BlueBear\WorldBrowserBundle\Controller;

use BlueBear\WorldBrowserBundle\Model\Map;
use CleverAge\EAVManager\AdminBundle\Controller\AbstractAdminController;
use CleverAge\EAVManager\Component\Controller\BaseControllerTrait;
use Faker\Factory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sidus\EAV\City;
use Sidus\EAV\World;
use Sidus\EAVModelBundle\Entity\DataInterface;
use Sidus\EAVModelBundle\Model\FamilyInterface;

class MapController extends AbstractAdminController
{
    use BaseControllerTrait;

    /**
     * @Template()
     * @param DataInterface|World $world
     * @return array
     */
    public function worldMapAction(DataInterface $world)
    {
        $map = $this->loadMap($world);

        return [
            'map' => $map,
        ];
    }

    /**
     * @Template()
     * @param DataInterface|World $world
     * @param integer             $x
     * @param integer             $y
     * @return array
     */
    public function areaMapAction(DataInterface $world, $x, $y)
    {
        $map = $this->loadMap($world);
        $currentCell = $map->getCell($x, $y);

        return [
            'map' => $map,
            'cell' => $currentCell,
        ];
    }

    /**
     * @param DataInterface|World $world
     * @param int                 $x
     * @param int                 $y
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function buildAction(DataInterface $world, $x, $y)
    {
        $faker = Factory::create();
        /** @var FamilyInterface $cityFamily */
        $cityFamily = $this->get('sidus_eav_model.family.city');
        /** @var City $city */
        $city = $cityFamily->createData();
        $city->setLabel($faker->city);
        $city->setWorld($world);
        $city->setX($x);
        $city->setY($y);

        $this->saveEntity($city);

        return $this->redirectToAction( 'areaMap', [
            'id' => $world->getId(),
            'x' => $x,
            'y' => $y,
        ]);
    }

    /**
     * @param DataInterface|World $world
     * @return Map
     */
    protected function loadMap(DataInterface $world)
    {
        return $this->get('bluebear.loader.world_map')->loadMap($world);
    }
}
