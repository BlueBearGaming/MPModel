<?php

namespace BlueBear\EAVModelBundle\Entity;

use CleverAge\EAVManager\EAVModelBundle\Entity\AbstractData;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="bluebear_data")
 * @ORM\Entity(repositoryClass="BlueBear\EAVModelBundle\Entity\DataRepository")
 */
class Data extends AbstractData
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
