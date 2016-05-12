<?php

namespace BlueBear\EAVModelBundle\Entity;

use CleverAge\EAVManager\EAVModelBundle\Entity\Data as BaseData;
use Doctrine\ORM\Mapping as ORM;

/**
 * Data
 *
 * @ORM\Table(name="bluebear_data")
 * @ORM\Entity(repositoryClass="BlueBear\EAVModelBundle\Entity\DataRepository")
 */
class Data extends BaseData
{
    /**
     * @return string
     */
    public function getIcon()
    {
        $code = strtolower($this->getFamilyCode());
        switch ($code) {
            case 'city':
                return 'bank';
        }
        return $code;
    }
}
