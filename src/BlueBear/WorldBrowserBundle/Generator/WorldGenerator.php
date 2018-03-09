<?php

namespace BlueBear\WorldBrowserBundle\Generator;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\Query;
use Faker\Factory;
use Faker\Generator;
use Sidus\EAV\Climate;
use Sidus\EAV\GameResourceQuantity;
use Sidus\EAV\World;
use Sidus\EAVModelBundle\Entity\DataInterface;
use Sidus\EAVModelBundle\Entity\DataRepository;
use Sidus\EAVModelBundle\Model\FamilyInterface;
use Sidus\EAVModelBundle\Registry\FamilyRegistry;

class WorldGenerator
{
    /** @var FamilyRegistry */
    protected $familyRegistry;

    /** @var FamilyInterface */
    protected $worldFamily;

    /** @var DataRepository */
    protected $repository;

    /**
     * @param Registry       $doctrine
     * @param FamilyRegistry $familyRegistry
     */
    public function __construct(Registry $doctrine, FamilyRegistry $familyRegistry)
    {
        $this->familyRegistry = $familyRegistry;
        $this->worldFamily = $familyRegistry->getFamily('World');
        $this->repository = $doctrine->getRepository($this->worldFamily->getDataClass());
    }

    /**
     * @param string $code
     *
     * @return World
     */
    public function generate($code = null)
    {
        $faker = Factory::create();

        if (null === $code) {
            $code = $faker->sha1;
        }
        $faker->seed($code);

        /** @var World $world */
        $world = $this->worldFamily->createData();
        $world->setWorldCode($code);
        $world->setLabel($faker->city); // @todo generate "Sci-Fi-like" planet names

        /** @var Climate $climate */
        $climate = $this->findRandomData('Climate', $faker);
        $world->setClimate($climate);

        $resourceQuantityFamily = $this->familyRegistry->getFamily('GameResourceQuantity');

        $resourceQuantities = [];
        foreach ($this->findRandomDatas('GameResource', $faker, $faker->numberBetween(2, 5)) as $resource) {
            if (!$resource) {
                continue;
            }
            /** @var GameResourceQuantity $resourceQuantity */
            $resourceQuantity = $resourceQuantityFamily->createData();
            $resourceQuantity->setResource($resource);
            $resourceQuantity->setQuantity($faker->numberBetween(1, 1000));
            $resourceQuantities[] = $resourceQuantity;
        }
        $world->setResourceQuantities($resourceQuantities);

        return $world;
    }

    /**
     * @param string    $familyCode
     * @param Generator $faker
     *
     * @return DataInterface
     */
    protected function findRandomData($familyCode, Generator $faker)
    {
        $dataId = $faker->randomElement($this->findElementsIds($familyCode));

        return $this->repository->find($dataId);
    }

    /**
     * @param string    $familyCode
     * @param Generator $faker
     * @param int       $count
     *
     * @return array
     */
    protected function findRandomDatas($familyCode, Generator $faker, $count)
    {
        $dataIds = $faker->randomElements($this->findElementsIds($familyCode), $count);

        return $this->repository->findBy(
            [
                'id' => $dataIds,
            ]
        );
    }

    /**
     * @param string $familyCode
     *
     * @return array
     */
    protected function findElementsIds($familyCode)
    {
        $qb = $this->repository->createQueryBuilder('d');
        $qb
            ->select('d.id')
            ->where('d.family = :family')
            ->orderBy('d.id')
            ->setParameters(
                [
                    'family' => $familyCode,
                ]
            );
        $dataIds = [];
        foreach ($qb->getQuery()->getResult(Query::HYDRATE_ARRAY) as $item) {
            $dataIds[] = $item['id'];
        }

        return $dataIds;
    }
}
