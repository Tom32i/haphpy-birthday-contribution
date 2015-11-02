<?php

namespace Console;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Console\Command\HaphpyBirthdayCommand;

/**
 * Haphpy Birthday console
 */
class HaphpyBirthdayApplication extends Application
{
    /**
     * Constructor
     *
     * @param string $name
     * @param string $version
     */
    public function __construct($name = 'Haphpy Birthday Console', $version = 'v1.0.0')
    {
        parent::__construct($name, $version);
    }

    /**
     * Gets the name of the command based on input.
     *
     * @param InputInterface $input The input interface
     *
     * @return string The command name
     */
    protected function getCommandName(InputInterface $input)
    {
        return 'haphpy:birthday';
    }

    /**
     * Gets the default commands that should always be available.
     *
     * @return array An array of default Command instances
     */
    protected function getDefaultCommands()
    {
        $defaultCommands = parent::getDefaultCommands();

        $defaultCommands[] = new HaphpyBirthdayCommand();

        return $defaultCommands;
    }

    /**
     * Overridden so that the application doesn't expect the command
     * name to be the first argument.
     */
    public function getDefinition()
    {
        $inputDefinition = parent::getDefinition();
        // clear out the normal first argument, which is the command name
        $inputDefinition->setArguments();

        return $inputDefinition;
    }
}
