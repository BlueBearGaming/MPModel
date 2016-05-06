<?php

namespace BlueBear\EAVModelBundle\Generator;


use Faker\Factory;
use Faker\Generator;
use Sidus\EAVModelBundle\Model\FamilyInterface;

class WorldGenerator
{
    /** @var FamilyInterface */
    protected $worldFamily;

    /** @var Generator */
    protected $faker;

    /**
     * WorldGenerator constructor.
     * @param FamilyInterface $worldFamily
     */
    public function __construct(FamilyInterface $worldFamily)
    {
        $this->worldFamily = $worldFamily;
        $this->faker = Factory::create();
    }

    public function generate($code = null)
    {
        if (null === $code) {
            $code = $this->faker->sha1;
        }
        $world = $this->worldFamily->createData();
        $world->set('code', $code);
//        $world->set();
    }
}