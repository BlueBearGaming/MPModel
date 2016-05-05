<?php

namespace BlueBear\LayoutBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BlueBearLayoutBundle extends Bundle
{
    /**
     * @inheritDoc
     */
    public function getParent()
    {
        return 'CleverAgeEAVManagerLayoutBundle';
    }
}
