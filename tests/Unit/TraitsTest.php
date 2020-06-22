<?php declare(strict_types=1);

use SCF\Commands\BaseCommand;
use SCF\Contracts\KernelContract;

use SCF\Traits\{
    CommandTrait,
    KernelTrait
};

class TraitsTest extends \PHPUnit\Framework\TestCase
{
    public function testCommandTrait(): void 
    {
        $class = (new class extends BaseCommand {
            use CommandTrait;
            public array $argumentMap = [
                '--path=' => 'override default path (app/Commands/).',
                '--command-name=' => 'Name of the class for the command you wish to create.',
                '--signature=' => 'set the signature. Example: "create:command"',
            ];

            public function getResultsFromTrait(): array 
            {
                return $this->getArgs();
            }
        });

        $res = $class->getResultsFromTrait();
        $this->assertTrue(gettype($res) === 'array');
        // Our class contained 0 args.
        $this->assertTrue(count($res) === 0);
    }

    public function testKernelTrait(): void 
    {
        $class = new class implements KernelContract {
            use KernelTrait;
            public static function classes(): array 
            {
                return [];
            }
            public static function getCommandClass(
                string $signature, 
                ?array $args, 
                array $env, 
                array $config
            ): ?BaseCommand {
                return null;
            }
        };

        $this->assertTrue(method_exists($class, 'printHelp'));
    }
}