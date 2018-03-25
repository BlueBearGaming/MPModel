<?php

namespace BlueBear\WorldBrowserBundle\Implementation\Resource;

use BlueBear\WorldBrowserBundle\Game\Map\CellInterface;

/**
 * Basic stone
 */
class Stone extends AbstractResource
{
    /**
     * @param $cell
     *
     * @return int
     */
    protected function getInitialQuantity(CellInterface $cell): int
    {
        return random_int(0, 1000); // @todo seed this
    }
}
