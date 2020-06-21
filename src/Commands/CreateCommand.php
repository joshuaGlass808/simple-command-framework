<?php declare(strict_types=1);

namespace SCF\Commands;

use SCF\Contracts\CommandContract;
use SCF\Traits\CommandTrait;

class CreateCommand extends BaseCommand implements CommandContract
{
    use CommandTrait;

	public string $signature = 'create:command';
	public array $argumentMap = [
		'--path=' => 'override default path (app/Commands/).',
		'--command-name=' => 'Name of the class for the command you wish to create.',
		'--signature=' => 'set the signature. Example: "create:command"',
	];

    /**
     * Execute Command = Creates a new Command Class file.
     * 
     * @return void
     */
    public function execute(): void
    {
        $args = $this->getArgs();
        $class = $args['command-name'];
        $path = $args['path'] ?? "/app/Commands";
        $file = getcwd() . "{$path}/{$class}.php";
        $this->warn("Building file: {$file}\n");

        if (file_exists($file)) {
            print "Class already exists, use a new name.\n";
            exit(1);
        }

        $fd = fopen($file, 'x');
        fwrite($fd, $this->getClassTemplate($class, $args['signature']));
        fclose($fd);

        $this->success("New class ({$class}) create: {$file}\n");
        $this->warn("Don't forget to add {$class} to the App/Kernel class.\n");
    }
	
    /**
     * Returns the class template as a string.
     * 
     * @param string $class - Class namespace of running command.
     * @param null|string $signature - Class signature.
     * 
     * @return string
     */
    protected function getClassTemplate(string $class, ?string $signature): string 
    {
        return "<?php declare(strict_types=1);\n\nnamespace App\Commands;\n\n"
            . "use SCF\\Contracts\\CommandContract;\n"
            . "use SCF\\Commands\\BaseCommand;\n"
            . "use SCF\\Traits\\CommandTrait;\n\n"
            . "class {$class} extends BaseCommand implements CommandContract\n"
            . "{\n    use CommandTrait;\n\n"
			. "    public string \$signature = '" . $signature . "';\n"
			. "    public array \$argumentMap = [];\n\n"
            . "    public function execute(): void\n"
            . "    {\n        // Get started!\n    }\n}\n";
    }
}
