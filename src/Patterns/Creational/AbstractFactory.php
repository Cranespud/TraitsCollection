<?php

namespace Cranespud\TraitsCollection\Patterns\Creational;

/**
 * This are sample methods you SHOULD delete them and create your own
 * Remember that each of this methods should call a concrete subclass of AbstractFactory and each method of those
 * should call an abstract "Widget/Item" factory
 *
 */
trait AbstractFactory {
    protected $currentFactory;
    protected $currentFactoryKey;
    protected $registeredFactories = array();

    /**
     * This can be changed to an autoloading mechanism or whatever suits your app best.
     * @param type $factoryKey
     */
    public function setCurrentFactory($factoryKey) {
        $this->currentFactoryKey = $factoryKey;
        $this->currentFactory = $this->getFactory();
    }

    public function getFactory() {
        if(!$this->currentFactoryKey || !array_key_exists($this->currentFactoryKey, $this->registeredFactories)) {
            throw new \Exception(__METHOD__ . ": '$this->currentFactoryKey' factory not found");
        }

        $factory = $this->registeredFactories[$this->currentFactoryKey];
        $this->currentFactory = $factory::getInstance();

        if(!$this->currentFactory) {
            throw new \Exception(__METHOD__ . ": invalid factory $this->currentFactoryKey");
        }

        return $this->currentFactory;
    }

    /**
     *
     * @param type $key factory identifier
     * @param type $factoryClass fqdn class name or object class that implements a Singleton pattern
     */
    public function registerFactory($key, $factoryClass) {
        $this->registeredFactories[$key] = $factoryClass;
    }

    /**
     *
     * @param type $factoryKey identifier of the factory to be unregistered
     */
    public function unregisterFactory($factoryKey) {
        if(array_key_exists($factoryKey, $this->registeredFactories)) {
            unset($this->registeredFactories[$factoryKey]);

            if($this->currentFactoryKey === $factoryKey) {
                $this->currentFactory = null;
            }
        }
    }
}
