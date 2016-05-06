<?php

namespace BlueBear\WorldBrowserBundle\Controller;

use MapGenerator\PerlinNoiseGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sidus\EAV\World;
use Sidus\EAVModelBundle\Entity\DataInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MapController extends Controller
{
    /**
     * @Template()
     * @param DataInterface|World $data
     * @return array
     */
    public function showAction(DataInterface $data)
    {
        $size = 70;
        $generator = new PerlinNoiseGenerator();
        $generator->setSize($size); //heightmap size: 100x100
        $generator->setPersistence(0.9); //map roughness
        $generator->setMapSeed($data->getWorldCode()); //optional
        $map = $generator->generate();
        $lines = [];

        for ($x = 0; $x < $size / 2; $x++) {
            for ($y = 0; $y < $size; $y++) {
                $height = round($map[$x][$y] / 2 * 255 - 255);
                $lines[$x][$y] = [
                    'coord' => "({$x},{$y})",
                    'height' => $height,
                    'color' => $this->getColor($height),
//                    'biome' => $this->findBiome($x, $y),
                ];
            }
        }
        return [
            'lines' => $lines,
        ];
    }

    /**
     * @param double $height
     * @return string
     */
    protected function getColor($height)
    {
        if ($height < 0) { // Ocean / lake
            $l = 50 + $height / 2;
            return "hsl(240, 62%, {$l}%)";
        }
        if ($height < 10) { // Swamp / beach
            $l = 70 + $height * 2;
            return "hsl(30, 100%, {$l}%)";
        }
        if ($height < 90) { // Forest
            $l = 30 - $height / 4;
            return "hsl(100, 100%, {$l}%)";
        }
        if ($height < 130) { // Mountains / grass
            $s = 90 - $height * 1.5 + 90;
            $l = 10 + $height - 90;
            return "hsl(100, {$s}%, {$l}%)";
        }
        // Rocks/snow
        $v1 = max(20 - $height + 130, 0);
        $v2 = 30 + $height - 130;
        return "hsl(100, {$v1}%, {$v2}%)";
    }
}
