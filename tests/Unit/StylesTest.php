<?php 

class StylesTest extends \PHPUnit\Framework\TestCase
{

    public function testTextStyles(): void 
    {
        $class = new ReflectionClass(\SCF\Styles\TextStyle::class);
        $this->assertTrue(count($class->getConstants()) >= 9);
    }
}