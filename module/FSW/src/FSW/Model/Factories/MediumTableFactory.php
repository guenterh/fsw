<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 3/11/14
 * Time: 7:53 PM
 */

namespace FSW\Model\Factories;
use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    FSW\Model\MediumTable;

class MediumTableFactory implements FactoryInterface {


    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        $tableGateway = $serviceLocator->get('MediumTableGateway');
        $table = new MediumTable($tableGateway);
        return $table;
    }


}