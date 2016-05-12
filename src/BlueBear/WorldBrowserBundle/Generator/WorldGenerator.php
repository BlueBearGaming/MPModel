<?php

namespace BlueBear\EAVModelBundle\Generator;

use Doctrine\ORM\Query;
use Faker\Factory;
use Faker\Generator;
use Sidus\EAV\Climate;
use Sidus\EAV\ResourceQuantity;
use Sidus\EAV\World;
use Sidus\EAVModelBundle\Configuration\FamilyConfigurationHandler;
use Sidus\EAVModelBundle\Entity\DataInterface;
use Sidus\EAVModelBundle\Entity\DataRepository;
use Sidus\EAVModelBundle\Model\FamilyInterface;

class WorldGenerator
{
    /** @var FamilyConfigurationHandler */
    protected $familyConfigurationHandler;

    /** @var FamilyInterface */
    protected $worldFamily;

    /** @var DataRepository */
    protected $repository;

    /**
     * WorldGenerator constructor.
     * @param FamilyConfigurationHandler $familyConfigurationHandler
     * @param DataRepository  $repository
     */
    public function __construct(FamilyConfigurationHandler $familyConfigurationHandler, DataRepository $repository)
    {
        $this->familyConfigurationHandler = $familyConfigurationHandler;
        $this->worldFamily = $familyConfigurationHandler->getFamily('World');
        $this->repository = $repository;
    }

    /**
     * @param string $code
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

        $resourceQuantityFamily = $this->familyConfigurationHandler->getFamily('ResourceQuantity');

        $resourceQuantities = [];
        foreach ($this->findRandomDatas('Resource', $faker, $faker->numberBetween(2, 5)) as $resource) {
            if (!$resource) {
                continue;
            }
            /** @var ResourceQuantity $resourceQuantity */
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
     * @return array
     */
    protected function findRandomDatas($familyCode, Generator $faker, $count)
    {
        $dataIds = $faker->randomElements($this->findElementsIds($familyCode), $count);

        return $this->repository->findBy([
            'id' => $dataIds,
        ]);
    }

    /**
     * @param string $familyCode
     * @return array
     */
    protected function findElementsIds($familyCode)
    {
        $qb = $this->repository->createQueryBuilder('d');
        $qb
            ->select('d.id')
            ->where('d.family = :family')
            ->orderBy('d.id')
            ->setParameters([
                'family' => $familyCode,
            ]);
        $dataIds = [];
        foreach ($qb->getQuery()->getResult(Query::HYDRATE_ARRAY) as $item) {
            $dataIds[] = $item['id'];
        }
        return $dataIds;
    }
}