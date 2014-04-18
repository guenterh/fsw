<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 10.04.14
 * Time: 23:57
 */

namespace FSW\Services\Config;

use Zend\Config\Config, Zend\Config\Reader\Ini as IniReader,
    Zend\ServiceManager\AbstractFactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface;


class PluginFactory implements AbstractFactoryInterface {


    protected $iniReader;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Use ASCII 0 as a nest separator; otherwise some of the unusual key names
        // we have (i.e. in WorldCat.ini search options) will get parsed in
        // unexpected ways.
        $this->iniReader = new IniReader();
        $this->iniReader->setNestSeparator(chr(0));
    }


    /**
     * Load the specified configuration file.
     *
     * @param string $filename config file name
     * @param string $path     path relative to VuFind base (optional; defaults
     * to config/vufind
     *
     * @return Config
     */
    protected function loadConfigFile($filename, $path = '/config/fsw/')
    {

        $fullpath = APP_PATH . $path . $filename . '.ini';

        // Return empty configuration if file does not exist:
        if (!file_exists($fullpath)) {
            return new Config(array());
        } else {
            $test = new Config($this->iniReader->fromFile($fullpath), true);
            return $test;
        }

    }



    /**
     * Determine if we can create a service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return true;
    }

    /**
     * Create service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return mixed
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return $this->loadConfigFile($requestedName);
    }
}