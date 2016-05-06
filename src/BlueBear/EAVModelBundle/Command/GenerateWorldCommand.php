<?php

namespace BlueBear\EAVModelBundle\Command;

use Faker\Factory;
use Sidus\EAVModelBundle\Entity\DataInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateWorldCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('bluebear:generate:world')
            ->setDescription('Generate World');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return null|int null or 0 if everything went fine, or an error code
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        $faker = Factory::create();
        $faker->seed('BlueBearProjectMilitaryCoriandre');
        for ($i = 0; $i < 100; $i++) {
            $world = $this->getContainer()->get('bluebear.generator.world')->generate(sha1($faker->uuid));
            $em->persist($world);
        }
        $em->flush();
    }

    /**
     * @param DataInterface $data
     * @return array
     */
    protected function dump(DataInterface $data)
    {
        dump(json_decode($this->getContainer()->get('serializer')->serialize($data, 'json'), true));
    }
}
