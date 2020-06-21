<?php declare(strict_types=1);

namespace SCF;

use SCF\Contracts\KernelContract;
use SCF\Commands\BaseCommand;

class CommandApplication
{
    public array $args = [];
    public array $env = [];
    public array $config = [];

    /**
     * Build Application.
     */
    public function __construct(array $args = [], array $env = [], array $config = [])
    {
        $this->args = $args;
        $this->env = $env;
        $this->config = $config;
    }

    /**
     * Runs the command application.
     * 
     * @param bool $logRuns - If this is in production and running on cronjobs / queuing system,
     *   you may want to know when they ran, if so make $logRuns True.
     * @return bool
     */
    public function run(KernelContract $kernel, bool $logRuns = false): bool
    {
        $command = array_shift($this->args);
        if (preg_match('/^(--help|-h)$/i', $command)) {
            $kernel::printHelp();
            print "Options:\n    --help|-h : Display this help message.\n";
            exit(0);
        }

        $args = (!empty($this->args)) ? $this->args : null;    
        $class = $kernel::getCommandClass($command, $args, $this->env, $this->config);
        if ($class === null) {
            $error = sprintf(
                "The command: %s is not a valid command listed in the %s class or a valid option.\n", 
                $command, 
                get_class($kernel)
            );
            (new BaseCommand())->error($error, true);
            exit(3);
        }
        
        $class->execute();

        return true;
    }
}