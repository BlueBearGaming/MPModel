<?php

namespace BlueBear\WorldBrowserBundle\Twig;

use BlueBear\WorldBrowserBundle\Model\Cell;

/**
 * Rendering utilities for
 */
class WorldExtension extends \Twig_Extension
{
    /**
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('get_color', [$this, 'getColor']),
        ];
    }

    /**
     * @param Cell $cell
     *
     * @return string
     */
    public function getColor(Cell $cell): string
    {
        $height = $cell->getHeight();
        if ($height < 0) { // Ocean / lake
            $color = [
                'H' => 240,
                'S' => 62,
                'L' => 50 + $height / 2,
            ];
        } elseif ($height < 10) { // Swamp / beach
            $color = [
                'H' => 30,
                'S' => 100,
                'L' => 70 + $height * 2,
            ];
        } elseif ($height < 90) { // Forest
            $color = [
                'H' => 100,
                'S' => 100,
                'L' => 30 - $height / 4,
            ];
        } elseif ($height < 120) { // Mountains / grass
            $color = [
                'H' => 100,
                'S' => 90 - $height * 1.5 + 90,
                'L' => 10 + $height - 90,
            ];
        } elseif ($height < 150) { // Rocks
            $color = [
                'H' => 100,
                'S' => max(20 - $height + 130, 0),
                'L' => 30 + $height - 130,
            ];
        } else { // Snow
            $color = [
                'H' => 100,
                'S' => 0,
                'L' => 90,
            ];
        }

        return "hsl({$color['H']}, {$color['S']}%, {$color['L']}%)";
    }
}
