<?php declare(strict_types=1);

namespace SCF\Traits;

trait KernelTrait
{
    /**
     * Display Help Message.
     * 
     * @return void
     */
    public static function printHelp(): void
    {
        $classes = self::classes();
        print "Usage: ./scf <shell:signature> [--args=...]\n"
            . "       ./scf -h\n\n";
		
        rsort($classes);
        foreach ($classes as $class) {
            $c = new $class;
            $s = '    ';
            print $s . $c->signature . "\n";
            foreach ($c->argumentMap as $arg => $desc) {
                print $s . $s . $arg . ' : ' . $desc . "\n";
            }
            print "\n";
        }
    } 
}