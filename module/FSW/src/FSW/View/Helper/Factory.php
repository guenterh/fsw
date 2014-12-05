<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 05.12.14
 * Time: 20:32
 */

namespace FSW\View\Helper;


use Zend\ServiceManager\ServiceLocatorAwareInterface;
use FSW\View\Helper\Veranstaltungen as HelperVeranstaltungen;

class Factory {


    public static function getVeranstaltungsHelper(ServiceLocatorAwareInterface $serviceLocator)
    {
        $veranstaltungen = $serviceLocator->getServiceLocator()->get('FSW\Model\Veranstaltungen');
        return new HelperVeranstaltungen($veranstaltungen);
    }


    public static function getHsFormsUrlHelper(ServiceLocatorAwareInterface $serviceLocator)
    {
        return new HSFormsLinks($serviceLocator->getServiceLocator()->get('FSW\Config')->get('config')->HSFormURLs);
    }


} 