<?php

namespace Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Console\Animation;

/**
 * Haphpy birthday command
 */
class HaphpyBirthdayCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('haphpy:birthday')
            ->setDescription('20 years of PHP')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $message   = implode(PHP_EOL, Animation\HaphpyBirthday::MESSAGE);
        $height    = count(Animation\HaphpyBirthday::MESSAGE);
        $animation = $this->createAnimation($message);
        $max       = count($animation) - 1;
        $frame     = 0;

        while (true) {
            $this->clear($height);
            $this->overwrite($animation[$frame], $height);
            if ($frame === $max) {
                usleep(10 * 1000000);
            } else {
                $frame++;
                usleep(1/60 * 1000000);
            }
        }
    }

    /**
     * Clear lines
     *
     * @param integer $height
     */
    private function clear($height = 1)
    {
        $this->output->write("\x0D");
        $this->output->write(sprintf("\033[%dA", $height));
    }

    /**
     * Overwrite
     *
     * @param string $message
     * @param integer $height
     */
    private function overwrite($message, $height = 1)
    {
        $lines = explode(PHP_EOL, $message);

        $this->output->write("\x0D");
        $this->output->write(sprintf("\033[%dA", $height));
        $this->output->write(implode(PHP_EOL, $lines));
    }

    /**
     * Create animation from message
     *
     * @param string $message
     * @param integer $maxStep
     *
     * @return array
     */
    private function createAnimation($message, $length = 120, $maxStep = 20)
    {
        $animation = [$message];
        $step      = 0;

        for ($i=0; $i < $length; $i++) {
            $step = min($step + 1, $maxStep);
            for ($j=0; $j < $step; $j++) {
                $message = $this->shuffleMessage($message);
            }
            array_unshift($animation, $message);
        }

        return $animation;
    }

    /**
     * Shuffle
     *
     * @param string $source
     *
     * @return array
     */
    private function shuffleMessage($message)
    {
        $max = strlen($message) - 1;

        $i = rand(0, $max);
        $j = rand(0, $max);

        while ($i === $j || $message[$i] === PHP_EOL || $message[$j] === PHP_EOL) {
            $i = rand(0, $max);
            $j = rand(0, $max);
        }

        $a = $message[$i];
        $b = $message[$j];

        $message[$j] = $a;
        $message[$i] = $b;

        return $message;
    }
}
