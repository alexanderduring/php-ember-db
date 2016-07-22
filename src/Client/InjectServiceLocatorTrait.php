<?php

namespace EmberDb\Client;

trait InjectServiceLocatorTrait
{
    /** @var \EmberDb\Client\ServiceLocator */
    private $serviceLocator;



    /**
     * @param \EmberDb\Client\ServiceLocator $serviceLocator
     */
    public function injectServiceLocator(ServiceLocator $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }
}
