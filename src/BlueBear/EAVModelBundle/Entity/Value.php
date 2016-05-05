<?php

namespace BlueBear\EAVModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use CleverAge\EAVManager\EAVModelBundle\Entity\Value as BaseValue;

/**
 * Value
 *
 * @ORM\Table(name="bluebear_value")
 * @ORM\Entity(repositoryClass="CleverAge\EAVManager\EAVModelBundle\Entity\ValueRepository")
 */
class Value extends BaseValue
{
}
