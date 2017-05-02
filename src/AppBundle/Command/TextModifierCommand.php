<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;

/**
 * extModifierCommand
 *
 * @author aliaksei
 */
class TextModifierCommand extends ContainerAwareCommand
{
    const IN = 'input-file';
    const OUT = 'output-file';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('task:cli:modify-text')
            ->addArgument(self::IN, InputArgument::REQUIRED)
            ->addArgument(self::OUT, InputArgument::REQUIRED)
            ->setDescription('Read text from input file modify and save to output file');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $in = $input->getArgument(self::IN);
        $out = $input->getArgument(self::OUT);

        try {
            $this->getContainer()->get('app.text_modifier')->run($in, $out);
        } catch (\Exception $ex) {
            $output->writeln($ex->getMessage());
            exit(1);
        }

        $output->writeln('Bye.');
    }
}
