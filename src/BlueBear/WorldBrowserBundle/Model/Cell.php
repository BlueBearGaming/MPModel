<?php

namespace BlueBear\WorldBrowserBundle\Model;

use Sidus\EAVModelBundle\Entity\DataInterface;

class Cell
{
    /** @var Map */
    protected $map;

    /** @var int */
    protected $x;

    /** @var int */
    protected $y;

    /** @var integer */
    protected $height;

    /** @var DataInterface[] */
    protected $contents;

    /**
     * Cell constructor.
     * @param Map $map
     * @param int $x
     * @param int $y
     */
    public function __construct(Map $map, $x, $y)
    {
        $this->map = $map;
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @return int
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @return float
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param float $height
     */
    public function setHeight($height)
    {
        $this->height = (int) $height;
    }

    /**
     * @return array
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * @param DataInterface $content
     */
    public function addContent(DataInterface $content)
    {
        $this->contents[] = $content;
    }

    /**
     * @param array $contents
     */
    public function setContents($contents)
    {
        $this->contents = $contents;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        $height = $this->height;
        if ($height < 0) { // Ocean / lake
            $l = 50 + $height / 2;
            $color = [
                'H' => 240,
                'S' => 62,
                'L' => $l,
            ];
        } elseif ($height < 10) { // Swamp / beach
            $l = 70 + $height * 2;
            $color = [
                'H' => 30,
                'S' => 100,
                'L' => $l,
            ];
        } elseif ($height < 90) { // Forest
            $l = 30 - $height / 4;
            $color = [
                'H' => 100,
                'S' => 100,
                'L' => $l,
            ];
        } elseif ($height < 130) { // Mountains / grass
            $s = 90 - $height * 1.5 + 90;
            $l = 10 + $height - 90;
            $color = [
                'H' => 100,
                'S' => $s,
                'L' => $l,
            ];
        } else { // Rocks/snow
            $s = max(20 - $height + 130, 0);
            $l = 30 + $height - 130;
            $color = [
                'H' => 100,
                'S' => $s,
                'L' => $l,
            ];
        }
        return "hsl({$color['H']}, {$color['S']}%, {$color['L']}%)";
    }

    /**
     * @param Cell $cell
     * @return int
     */
    public function distance(Cell $cell)
    {
        return (abs($this->getY() - $cell->getY())
            + abs($this->getY() + $this->getX() - $cell->getY() - $cell->getX())
            + abs($this->getX() - $cell->getX())) / 2;
    }
}