<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 10.04.14
 * Time: 23:56
 */

namespace FSW\Services\Config;

use Zend\ServiceManager\AbstractPluginManager as Base;
use Zend\ServiceManager\Exception;


class PluginManager extends Base {



    /**
     * Validate the plugin
     *
     * Checks that the filter loaded is either a valid callback or an instance
     * of FilterInterface.
     *
     * @param  mixed $plugin
     * @return void
     * @throws Exception\RuntimeException if invalid
     */
    public function validatePlugin($plugin)
    {
        // should be ok for everything
    }
}