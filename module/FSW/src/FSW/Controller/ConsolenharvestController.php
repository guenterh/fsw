<?php
/**
 * CLI Controller Module
 *
 * PHP version 5
 *
 * Copyright (C) Villanova University 2010.
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
 * @category VuFind2
 * @package  Controller
 * @author   Chris Hallberg <challber@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     http://vufind.org/wiki/vufind2:building_a_controller Wiki
 */
namespace FSW\Controller;
use FSW\Services\OAI;
use Zend\Console\Console;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;

/**
 * This controller handles various command-line tools
 *
 * @category VuFind2
 * @package  Controller
 * @author   Chris Hallberg <challber@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     http://vufind.org/wiki/vufind2:building_a_controller Wiki
 */
class ConsolenharvestController extends HarvestController
{
    /**
     * Harvest OAI-PMH records.
     *
     * @return \Zend\Console\Response
     */
    public function oaiconsoleAction()
    {
        $request = $this->getRequest();
        $args = $request->params();


        $oaiConfig = $this->getServiceLocator()->get('FSW\Config')->get('oai');
        $zoraConfig = $oaiConfig->Zora;


        //$from = $request->getParam('from', '1900-01-01') || $request->getParam('f', '1900-01-01');
        $from = $request->getParam('from');
        $until = $request->getParam('until');
        $until =    $until ? $until : '';
        $params = compact('from', 'until');

        $this->startHarvestingListRecords('Zora',$zoraConfig, $params);

        //$entities =  explode('##',$entitiesConcat);
        //$this->startHarvestingGetRecord($zoraConfig, $entities);

        $messages = $this->facade->getMessages();

        foreach ($messages as $message) {
            file_put_contents($zoraConfig->messagesFile,$message . "\n", FILE_APPEND );
        }

    }

    public function zoradeltaAction()
    {

        $adapter = $this->facade->getDBAdapter();
        $sql = "select oai_identifier from fsw_oai_identifier where oai_identifier not in (" ;
        $sql .= " select oai_identifier from fsw_zora_doc)";

        $result =  $adapter->query($sql,Adapter::QUERY_MODE_EXECUTE);

        $idParams = array();
        foreach ($result as $row) {

            $idParams[] = $row['oai_identifier'];

        }
        //ansonsten wird  der EventHandler processOAIItem mehrfach registsriert

        $oaiConfig = $this->getServiceLocator()->get('FSW\Config')->get('oai');
        $zoraConfig = $oaiConfig->Zora;
        $this->startHarvestingGetRecord('Zora',$zoraConfig, $idParams);



        $messages = $this->facade->getMessages();

        foreach ($messages as $message) {
            file_put_contents($zoraConfig->messagesFileDelta,$message . "\n", FILE_APPEND );
        }


    }

    public function getOldZoraIdsAction()
    {

        $oaiConfig = $this->getServiceLocator()->get('FSW\Config')->get('oai');
        $zoraFileDeltaIds = $oaiConfig->Zora->messagesFileDelta1;

        $adapter = $this->facade->getDBAdapter();
        //$sql = "select identifier from fswzora where identifier not in (" ;
        //$sql .= " select oai_identifier from fsw_zora_doc)";

        //$result =  $adapter->query($sql,Adapter::QUERY_MODE_EXECUTE);

        $handle = fopen($zoraFileDeltaIds, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $line = preg_replace('~[[:cntrl:]]~', '', $line);
                $sql = "insert into fsw_oai_identifier (oai_identifier) ";
                $sql .= " values ('" . $line . "')";
                $adapter->query($sql,Adapter::QUERY_MODE_EXECUTE);
            }
        } else {
            echo "error";
        }
        fclose($handle);

    }

    /**
     * Indicate failure.
     *
     * @return \Zend\Console\Response
     */
    protected function getFailureResponse()
    {
        return $this->getResponse()->setErrorLevel(1);
    }

    /**
     * Indicate success.
     *
     * @return \Zend\Console\Response
     */
    protected function getSuccessResponse()
    {
        return $this->getResponse()->setErrorLevel(0);
    }




}
