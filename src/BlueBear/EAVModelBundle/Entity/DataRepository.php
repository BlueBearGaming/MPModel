<?php

namespace BlueBear\EAVModelBundle\Entity;

use CleverAge\EAVManager\EAVModelBundle\Entity\DataRepository as BaseDataRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Sidus\EAV\World;
use Sidus\EAVModelBundle\Entity\DataInterface;
use Sidus\EAVModelBundle\Model\FamilyInterface;

class DataRepository extends BaseDataRepository
{
    /**
     * @param FamilyInterface     $family
     * @param DataInterface|World $world
     * @return QueryBuilder
     */
    public function getQbByWorld(FamilyInterface $family, DataInterface $world)
    {
        /** @var QueryBuilder $qb */
        $qb = $this->createOptimizedQueryBuilder('e');
        $qb
            ->where('e.family IN (:family)')
            ->join('e.values', 'v', Join::WITH, "v.attributeCode = 'world' AND v.dataValue = :world")
            ->setParameters([
                'family' => $family->getMatchingCodes(),
                'world' => $world,
            ]);

        return $qb;
    }
}
