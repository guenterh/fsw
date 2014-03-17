<?php
/**
 * Created by iwerk.ch fuer FSW, UZH Zürich.
 * author: Guenter Hipler 
 * Date: 3/16/14
 * Time: 7:11 PM
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
use Zend\Db\Sql\Sql;

class HistSemDBAdapterFactory implements FactoryInterface{


    protected $histSemAdapter;

    protected function initialize(ServiceLocatorInterface $serviceLocator) {

        $config =   $serviceLocator->get("Config");
        $dbconfig = $config["fsw"]["db"];

        $this->histSemAdapter = new Adapter($dbconfig);


    }



    protected function getSQLAllExtendedFSWPerson() {
        $sql =  new Sql($this->histSemAdapter);
        $select = $sql->select();
        $select->from(array("pers"=>"Per_Personen"));
        $select->join(array("rolle" => "Per_Rolle"),
            "pers.pers_id = rolle.roll_Pers_id");

        $select->join(array( "fswpersex" => "FSW_Personen_Extended"),
            "fswpersex.persex_roll_id = rolle.roll_id");



        //$selectStatement = $sql->prepareStatementForSqlObject($select);

        return $select;


        //$select->where->equalTo('rolle.roll_hs_fsw','yes');
        //$select->where(array('rolle.roll_hs_fsw' => 'yes'));
        //$select->where(array("pers.pers_id" => 101));
        //$params = new ParameterContainer(array('?' => 'yes'));
        //$params = new ParameterContainer(array('yes'));
        //$params = array('rolle.roll_hs_fsw' => 'yes');
        //$result = $selectStatement->execute();

        //$query = $sql->getSqlStringForSqlObject($select);
        //$result = $histsemAdapter->query($query, $histsemAdapter::QUERY_MODE_EXECUTE);

        //Debug::dump($selectStatement->getSql());

        //foreach($result as $row) {
        //    Debug::dump($row);
        //}


        //foreach($result as $row) {
        //    Debug::dump($row);
        //}



    }


    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config =   $serviceLocator->get("Config");
        $dbconfig = $config["fsw"]["db"];

        return new Adapter($dbconfig);
    }
}