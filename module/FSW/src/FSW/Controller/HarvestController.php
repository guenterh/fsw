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

/**
 * This controller handles various command-line tools
 *
 * @category VuFind2
 * @package  Controller
 * @author   Chris Hallberg <challber@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     http://vufind.org/wiki/vufind2:building_a_controller Wiki
 */
class HarvestController extends BaseController
{
    /**
     * Harvest OAI-PMH records.
     *
     * @return \Zend\Console\Response
     */
    public function oaiAction()
    {


        $oaiConfig = $this->getServiceLocator()->get('FSW\Config')->get('oai');

        $zoraFacade = null;
        foreach ($oaiConfig as $sectionName => $oaiSection) {

            if (isset($oaiSection->active) && $oaiSection->active && $sectionName == 'Zora') {

                $zoraFacade = $this->getServiceLocator()->get('FSW\Services\Facade\ZoraFacade');
                //$zoraFacade->processOAIItem();
                //$zoraFacade->insertIntoFSWExtended();
                $oaiClient = $zoraFacade->getOAIClient();

                //missing set config, do something
                //todo: Abfrage, on ich einen Consolerequest habe, in diesem Fall existiert fromQuery nicht
                //$oaiClient->setStartDate($this->params()->fromQuery('from','1900-01-01'));
                //$oaiClient->setEndDate($this->params()->fromQuery('until','2050-12-31'));

                $oaiClient->setStartDate('1900-01-01');
                $oaiClient->setEndDate('2050-12-31');
                if ($oaiSection->usedSets) {
                    $sets = explode('###',$oaiSection->usedSets);
                    foreach($sets as $set) {

                        $oaiClient->setConfig('target', array('set' => $set,
                                                'url' => $oaiSection->url));
                        $oaiClient->launch();
                    }
                } else {
                    $oaiClient->launch();
                }


                //$oaiClient->launch();

            }
        }
        //delete FROM `fsw_zora_doc`;
        //delete FROM `fsw_zora_doctype`;
        //delete FROM `fsw_relation_zora_author_zora_doc`;
        //delete FROM `fsw_cover`;

        $test = $zoraFacade->getMessages();

        return new ViewModel(array('messages' => $zoraFacade->getMessages()));

        // All done.
        //Console::writeLine(
        //    "Completed without errors -- {$processed} source(s) processed."
        //);
        //$r = new \Zend\Http\Response();
        //$r->setStatusCode(503);
        //return $r;
        //return $this->getSuccessResponse();

    }

    /**
     * Merge harvested MARC records into a single <collection>
     *
     * @return \Zend\Console\Response
     * @author Thomas Schwaerzler <thomas.schwaerzler@uibk.ac.at>
     */
    public function mergemarcAction()
    {
        //we don't need this
        //but we need something with EventManager
        //inform a Listener sending the harvested records

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
