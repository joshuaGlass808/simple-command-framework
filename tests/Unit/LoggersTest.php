<?php 

use SCF\Loggers\SimpleLog;

class LoggersTest extends \PHPUnit\Framework\TestCase
{

    public function testSimpleLogWrite(): void 
    {
        $path = 'tests/';
        $filename = 'test.log';
        $this->assertTrue(SimpleLog::write("test", $path, $filename));

        $file = $path . $filename;
        $fd = fopen($file, 'r');
        $contents = fread($fd, filesize($file));
        fclose($fd);

        $this->assertTrue(strpos($contents, 'test') !== false);
        unlink($file);
    }
}