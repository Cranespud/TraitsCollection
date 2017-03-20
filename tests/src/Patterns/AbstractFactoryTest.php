<?php

use PHPUnit\Framework\TestCase;
use Cranespud\TraitsCollection\Patterns\Creational\AbstractFactory;

class MyCarFactory {
    use AbstractFactory;

    /* Explicitly define the methods you want to abstract */
    public function createSportsCar() { return $this->getFactory()->createSportsCar(); }
    public function createSuvCar() { return $this->getFactory()->createSuvCar(); }

    /**
     * Alternatively for all methods not explicitly defined on the class
     * @param type $method
     * @param type $arguments
     * @return type
     */
    public function __call($method, $arguments) {
        return $this->getFactory()->$method($arguments);
    }
}

class MazdaFactory extends MyCarFactory {

    public static function getInstance() { return new MazdaFactory; }
    // These methods shoudl return object instances instead of strings
    public function createSportsCar() { return 'RX-8'; }
    public function createSuvCar() { return 'CX-9'; }
    public function createPickup() { return 'BT-50'; }  // this method is provided by the factory through __call()
}

class ChevyFactory extends MyCarFactory {

    public static function getInstance() { return new ChevyFactory; }
    // These methods shoudl return object instances instead of strings
    public function createSportsCar() { return 'Covertte'; }
    public function createSuvCar() { return 'Tahoe'; }
    public function createPickup() { return 'Avalanche'; }  // this method is provided by the factory through __call()
}


class AbstractFactoryTest extends TestCase
{
    private $abstractFactory;

    public function setUp() {
        parent::setUp();

        $this->abstractFactory = new MyCarFactory();
        $this->abstractFactory->registerFactory('mazda', 'MazdaFactory');
        $this->abstractFactory->registerFactory('chevy', 'ChevyFactory');
    }


    /**
     * When no factory has been selected it should throw an exception
     */
    public function testNoFactoryHasBeenSelected() {
        $this->expectException("Exception");
        $this->assertEquals('RX-8', $this->abstractFactory->createSportsCar());
    }

    /**
     * When the default factory is unregistered and attempt to use the abstract factory an exception should be thrown
     */
    public function testUnregisterTheCurrentSelectedFactory() {
        $this->expectException("Exception");
        $this->abstractFactory->unregisterFactory('mazda');
        $this->assertEquals('RX-8', $this->abstractFactory->createSportsCar());
    }

    /**
     * When a factory is unregistered any attempt to use the abstract factory should throw an exception
     */
    public function testUnregisterAFactoryAndAttemptToUseIt() {
        $this->expectException("Exception");
        $this->abstractFactory->unregisterFactory('mazda');
        $this->abstractFactory->setCurrentFactory('mazda');
    }

    public function testcreateSportsCar()
    {
        $this->abstractFactory->setCurrentFactory('mazda');
        $this->assertEquals('RX-8', $this->abstractFactory->createSportsCar());

        $this->abstractFactory->setCurrentFactory('chevy');
        $this->assertEquals('Covertte', $this->abstractFactory->createSportsCar());
    }

    public function testcreateSuvCar()
    {
        $this->abstractFactory->setCurrentFactory('mazda');
        $this->assertEquals('CX-9', $this->abstractFactory->createSuvCar());

        $this->abstractFactory->setCurrentFactory('chevy');
        $this->assertEquals('Tahoe', $this->abstractFactory->createSuvCar());
    }

    public function testcreatePickup()
    {
        $this->abstractFactory->setCurrentFactory('mazda');
        $this->assertEquals('BT-50', $this->abstractFactory->createPickup());

        $this->abstractFactory->setCurrentFactory('chevy');
        $this->assertEquals('Avalanche', $this->abstractFactory->createPickup());
    }
}