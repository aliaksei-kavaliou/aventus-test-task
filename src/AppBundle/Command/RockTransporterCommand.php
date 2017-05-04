<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Description of RockTransporterCommand
 *
 * @author aliaksei
 */
class RockTransporterCommand extends Command
{
    const TRACK_CAPACITY = 30000;
    const MAX_ROCK_WEIGHT = 20000;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('task:rock:move')
            ->setDescription('Rock task solution');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new Question("Add a rock. Press enter to stop. Allowed weight 1 - ".self::MAX_ROCK_WEIGHT." kg: ");

        $rocks = [];
        while ($result = $helper->ask($input, $output, $question)) {
            if ($result > self::MAX_ROCK_WEIGHT) {
                $output->writeln('Your rock is too heavy. ');
                continue;
            }

            $rocks[] = $result;
        }

        $output->writeln("Your rock heap is [".implode(',', $rocks).']');

        rsort($rocks);

        $c = 0;
        while (!empty($rocks)) {
            $c++;
            $track = $this->loadTrack($rocks);

            $output->writeln("$c track: [".implode(',', $track).']');
        }

        $output->writeln("Heap was transported in $c rounds.\nBye");

        exit(0);
    }

    /**
     * Return part of array with summ less then track capacity
     * @param array $rocks
     * @return array
     */
    private function loadTrack(array &$rocks)
    {
        $track = [];
        $load = 0;

        foreach ($rocks as $key => $rock) {
            if ($load + $rock <= self::TRACK_CAPACITY) {
                $track[] = $rock;
                unset($rocks[$key]);
                $load += $rock;
            }

            if (self::TRACK_CAPACITY === $load) {
                break;
            }
        }

        return $track;
    }
}
