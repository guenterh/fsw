<?php
/**
 * Created by iwerk.ch fuer FSW, UZH Zürich.
 * author: Guenter Hipler 
 * Date: 3/16/14
 * Time: 1:39 PM
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

namespace FSW\Model\Factories\DB;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Debug\Debug;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use FSW\Model\Kolloqium;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\ParameterContainer;


class PersonenExtendedAdapterFactory extends HistSemDBAdapter implements  FactoryInterface {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        $this->initialize($serviceLocator);

        $select = $this->getSQLAllExtendedFSWPerson();

        $select->where(array("pers.pers_id", 101));

        //$select->

        $result =  $select->execute();

        foreach($result as $row) {
            Debug::dump($row);
        }

        return $result;


    }
}