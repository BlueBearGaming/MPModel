<?php

namespace BlueBear\EAVModelBundle\Entity;

use CleverAge\EAVManager\EAVModelBundle\Entity\Data as BaseData;
use Doctrine\ORM\Mapping as ORM;

/**
 * Data
 *
 * @ORM\Table(name="bluebear_data")
 * @ORM\Entity(repositoryClass="CleverAge\EAVManager\EAVModelBundle\Entity\DataRepository")
 */
class Data extends BaseData
{
}
