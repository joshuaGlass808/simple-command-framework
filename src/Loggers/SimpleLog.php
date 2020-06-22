<?php declare(strict_types=1);

namespace SCF\Loggers;

class SimpleLog 
{
    const LOG_PATH = 'logs/';

    /**
     * Writes a line to the log file.
     * @param string $log - data you want to log.
     * 
     * @return bool Returns True or False on Succeed/Fail.
     */
    public static function write(string $log, ?string $path = null, ?string $filename = null): bool 
    {
        $path ??= self::LOG_PATH;
        $filename ??= 'application-' . date('YYYYmmdd') . '.log';
        $file = $path . $filename;
        if (($fd = fopen($file, 'a')) === false) {
            return false;
        }

        $msg = '[' . date('YYYY-mm-dd H:i:s') . ']' . $log . "\n";
        if (fwrite($fd, $msg) === false) {
            return false;
        }

        fclose($fd);

        return true;
    }
}