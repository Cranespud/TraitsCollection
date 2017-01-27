<?php

namespace Cranespud\TraitsCollection\Patterns\Creational;

trait AbstractFactory {
    public static function getInstance() {
        echo __CLASS__;
    }
}



