<?php

namespace BlueBear\EAVModelBundle\Entity;

use CleverAge\EAVManager\EAVModelBundle\Entity\AbstractValue;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="bluebear_value")
 * @ORM\Entity(repositoryClass="CleverAge\EAVManager\EAVModelBundle\Entity\ValueRepository")
 */
class Value extends AbstractValue
{
}
