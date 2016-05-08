<?php

namespace BlueBear\WorldBrowserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sidus\EAV\World;
use Sidus\EAVModelBundle\Entity\DataInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MapController extends Controller
{
    /**
     * @Template()
     * @param DataInterface|World $world
     * @return array
     */
    public function worldMapAction(DataInterface $world)
    {
        $map = $this->get('blue_bear_world_browser.generator.world_map')->generate($world);

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
        $map = $this->get('blue_bear_world_browser.generator.world_map')->generate($world);
        $cell = $map->getCell($x, $y);

        return [
            'map' => $map,
            'cell' => $cell,
        ];
    }
}
