<?php

namespace BlueBear\WorldBrowserBundle\Model;

use MapGenerator\PerlinNoiseGenerator;
use Sidus\EAV\World;
use Sidus\EAVModelBundle\Entity\DataInterface;

class Map
{
    const MAP_SIZE = 70; // Changing this will completely transform the computed heightmap

    /** @var Cell[][] */
    protected $cells;

    /** @var array */
    protected $heightMap;

    /** @var DataInterface|World */
    protected $world;

    /**
     * Map constructor.
     * @param World|DataInterface $world
     */
    public function __construct(DataInterface $world)
    {
        $this->world = $world;

        $generator = new PerlinNoiseGenerator();
        $generator->setSize(self::MAP_SIZE);
        $generator->setPersistence(0.9);
        $generator->setMapSeed($world->getWorldCode());
        $this->heightMap = $generator->generate();

        $cells = [];
        foreach ($this->heightMap as $x => $heights) {
            foreach ($heights as $y => $rawHeight) {
                $height = round($rawHeight / 2 * 255 - 255);
                $cell = new Cell($x, $y);
                $cell->setHeight($height);

                $cells[$x][$y] = $cell;
            }
        }
        $this->cells = $cells;
    }

    /**
     * @return Cell[][]
     */
    public function getCells()
    {
        return $this->cells;
    }

    /**
     * @param int $x
     * @param int $y
     * @return Cell
     */
    public function getCell($x, $y)
    {
        // @todo check existence of coordinates
        return $this->cells[$x][$y];
    }

    /**
     * @return array
     */
    public function getHeightMap()
    {
        return $this->heightMap;
    }

    /**
     * @return World|DataInterface
     */
    public function getWorld()
    {
        return $this->world;
    }
}