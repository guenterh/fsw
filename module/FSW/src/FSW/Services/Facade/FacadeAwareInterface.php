<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 4/28/14
 * Time: 11:14 PM
 */

namespace FSW\Services\Facade;


interface FacadeAwareInterface {


    public function setFacadeService(BaseFacade $facadeService);

} 