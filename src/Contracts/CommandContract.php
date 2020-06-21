<?php declare(strict_types=1);

namespace SCF\Contracts;

interface CommandContract 
{
    public function execute(): void;
}