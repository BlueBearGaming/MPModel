<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 23/03/18
 * Time: 22:30
 */

namespace BlueBear\WorldBrowserBundle\Game\Map;

/**
 * Any elements that can be positioned on the map needs to implements this interface
 * Also the cells themselves
 */
interface CoordinatedInterface
{
    /**
     * @return int
     */
    public function getX(): int;

    /**
     * @return int
     */
    public function getY(): int;

    /**
     * @return int
     */
    public function getZ(): int;
}