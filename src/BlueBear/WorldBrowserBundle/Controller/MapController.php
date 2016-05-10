<?php

namespace BlueBear\WorldBrowserBundle\Controller;

use BlueBear\WorldBrowserBundle\Model\Map;
use CleverAge\EAVManager\Component\Controller\AdminControllerTrait;
use CleverAge\EAVManager\Component\Controller\BaseControllerTrait;
use Doctrine\ORM\Query\Expr\Join;
use Faker\Factory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sidus\AdminBundle\Controller\AdminInjectable;
use Sidus\EAV\City;
use Sidus\EAV\Coordinated;
use Sidus\EAV\World;
use Sidus\EAVModelBundle\Entity\DataInterface;
use Sidus\EAVModelBundle\Model\Family;
use Sidus\EAVModelBundle\Model\FamilyInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MapController extends Controller implements AdminInjectable
{
    use BaseControllerTrait;
    use AdminControllerTrait;

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

        return $this->redirectToAdmin('map', 'areaMap', [
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
        $map = $this->get('blue_bear_world_browser.generator.world_map')->generate($world);
        /** @var Family $coordinatedFamily */
        $coordinatedFamily = $this->get('sidus_eav_model.family.coordinated');
        $qb = $this->get('sidus_eav_model.doctrine.repository.data')->createQueryBuilder('e');
        $qb
            ->addSelect('values')
            ->where('e.family IN (:family)')
            ->join('e.values', 'v', Join::WITH, "v.attributeCode = 'world' AND v.dataValue = :world")
            ->leftJoin('e.values', 'values')
            ->setParameters([
                'family' => $coordinatedFamily->getMatchingCodes(),
                'world' => $world,
            ]);

        $elements = $qb->getQuery()->getResult();

        /** @var Coordinated $element */
        foreach ($elements as $element) {
            $cell = $map->getCell($element->getX(), $element->getY());
            if ($cell) {
                $cell->addContent($element);
            }
        }

        return $map;
    }
}
