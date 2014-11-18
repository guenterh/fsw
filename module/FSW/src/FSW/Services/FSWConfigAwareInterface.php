<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 17.11.14
 * Time: 22:09
 */

namespace FSW\Services;

use Zend\Config\Config;
use FSW\Services\Config\PluginManager;

interface FSWConfigAwareInterface {


    public function setFSWConfigService(Pluginmanager $fswConfigPlugin);

} 