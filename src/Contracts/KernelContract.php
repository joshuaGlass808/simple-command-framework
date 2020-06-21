<?php declare(strict_types=1);

namespace SCF\Contracts;

use SCF\Commands\BaseCommand;

interface KernelContract 
{
    /**
     * Classes is a method were you register all the command classes.
     * They be from any namespace as long as they implement 
     *   extend BaseCmd and have an execute method.
     * 
     * @return array - an array of all registered commands.
     */
    public static function classes(): array;

    /**
     * Get the class instance of the command.
     * 
     * @param string $signature - The command signature <basic:signature:block>
     * @param null|array $args  - Arguments passed with the command at run time.
     * @return null|BaseCmd     - Returns a Cmd class or null if not registered.
     */
    public static function getCommandClass(string $signature, ?array $args, array $env, array $config): ?BaseCommand;
}