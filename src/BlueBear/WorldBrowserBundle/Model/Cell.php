<?php

namespace BlueBear\WorldBrowserBundle\Model;


class Cell
{
    /** @var int */
    protected $x;

    /** @var int */
    protected $y;

    /** @var integer */
    protected $height;

    /**
     * Cell constructor.
     * @param int $x
     * @param int $y
     */
    public function __construct($x, $y)
    {
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
     * @return string
     */
    public function getColor()
    {
        $height = $this->height;
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