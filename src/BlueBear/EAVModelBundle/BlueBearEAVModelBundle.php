<?php

namespace BlueBear\EAVModelBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BlueBearEAVModelBundle extends Bundle
{
    /**
     * @inheritDoc
     */
    public function getParent()
    {
        return 'CleverAgeEAVManagerEAVModelBundle';
    }
}
