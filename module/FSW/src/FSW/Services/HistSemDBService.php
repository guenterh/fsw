<?php
/**
 * Created by iwerk.ch fuer FSW, UZH Zürich.
 * author: Guenter Hipler 
 * Date: 3/16/14
 * Time: 7:47 PM
 * Copyright (C) Forschungsstelle fuer Sozial- und Wirtschaftsgeschichte der Uni Zuerich, Schweiz
 * http://www.fsw.uzh.ch
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License version 2,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @category 
 * @package  
 * @author   Guenter Hipler  <guenter.hipler@iwerk.ch>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     http://www.fsw.uzh.ch
 */

namespace FSW\Services;

use Zend\Db\Adapter\Adapter;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;


class HistSemDBService implements ServiceManagerAwareInterface {

    protected $adapter;
    protected $oldFSWadapter;

    protected $personenTableGateway;
    protected $kolloquienTableGateway;
    protected $kolloquienVeranstaltungenTableGateway;
    protected $forschungenTableGateway;
    protected $medienTableGateway;
    protected $fswPersonenExtendedGateway;

    protected $zoraDocTableGateway;
    protected $rollenTableGateway;

    protected $relationHSPersonFSWPersonTableGateway;



    protected $serviceManager;

    public function __construct(Adapter $adapter, Adapter $oldFSWDB) {


        $this->adapter = $adapter;
        $this->oldFSWadapter = $oldFSWDB;

    }

    public function getAdapter() {
        return $this->adapter;
    }


    public function getOldFSWAdapter() {
        return $this->oldFSWadapter;
    }



    public function getAktivitatetFacade() {
        return $this->adapter;
    }

    /**
     * Set service manager
     *
     * @param ServiceManager $serviceManager
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function getForschungFacade() {
        $aF = $this->serviceManager->get('FSW\Services\Facade\ForschungFacade');
        return $aF;
    }


    public function getPersonenGateway() {
        if (is_null($this->personenTableGateway)) {
            $this->personenTableGateway = $this->serviceManager->get('PersonTableGateway');
        }

        return $this->personenTableGateway;
    }

    public function getFSWPersonenExtendedGateway() {

        if (is_null($this->fswPersonenExtendedGateway) ) {

            $this->fswPersonenExtendedGateway = $this->serviceManager->get("PersonExtendedTableGateway");
        }

        return $this->fswPersonenExtendedGateway;
    }

    public function getKolloquienGateway() {
        if (is_null($this->kolloquienTableGateway)) {
            $this->kolloquienTableGateway = $this->serviceManager->get('KolloquiumTableGateway');
        }

        return $this->kolloquienTableGateway;
    }

    public function getRelationHSFSWPersonGateway () {

        if (is_null($this->relationHSPersonFSWPersonTableGateway)) {
            $this->relationHSPersonFSWPersonTableGateway = $this->serviceManager->get('RelationHSPersonFSWPersonTableGateway');
        }

        return $this->relationHSPersonFSWPersonTableGateway;

    }




    public function getKolloquienVeranstaltungenGateway() {
        if (is_null($this->kolloquienVeranstaltungenTableGateway)) {
            $this->kolloquienVeranstaltungenTableGateway = $this->serviceManager->get('KolloquiumVeranstaltungTableGateway');
        }

        return $this->kolloquienVeranstaltungenTableGateway;
    }

    public function getForschungenGateway() {
        if (is_null($this->forschungenTableGateway)) {
            $this->forschungenTableGateway = $this->serviceManager->get('ForschungTableGateway');
        }

        return $this->forschungenTableGateway;
    }


    public function getMedienGateway() {
        if (is_null($this->medienTableGateway)) {
            $this->medienTableGateway = $this->serviceManager->get('MediumTableGateway');
        }

        return $this->medienTableGateway;
    }

    public function getZoraDocGateway() {

        if (is_null($this->zoraDocTableGateway)) {
            $this->zoraDocTableGateway = $this->serviceManager->get("ZoraDocTableGateway");
        }

        return $this->zoraDocTableGateway;
    }



    public function getRollenGateway() {

        if (is_null($this->rollenTableGateway)) {
            $this->rollenTableGateway = $this->serviceManager->get("RollenTableGateway");
        }

        return $this->rollenTableGateway;
    }



} 