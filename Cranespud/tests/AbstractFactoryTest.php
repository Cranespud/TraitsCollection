<?php

use PHPUnit\Framework\TestCase;

use Cranespud\TraitsCollection\Patterns\Creational\AbstractFactory;


class StackTest extends TestCase
{
    public function testPushAndPop()
    {
        AbstractFactory::getInstance();
    }
}