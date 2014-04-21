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

/**
 * This controller handles various command-line tools
 *
 * @category VuFind2
 * @package  Controller
 * @author   Chris Hallberg <challber@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     http://vufind.org/wiki/vufind2:building_a_controller Wiki
 */
class HarvestController extends AbstractActionController
{
    /**
     * Harvest OAI-PMH records.
     *
     * @return \Zend\Console\Response
     */
    public function oaiAction()
    {


        $oaiConfig = $this->getServiceLocator()->get('FSW\Config')->get('oai');

        foreach ($oaiConfig as $sectionName => $oaiSection) {

            if (isset($oaiSection->active) && $oaiSection->active && $sectionName == 'Zora') {

                $zoraFacade = $this->getServiceLocator()->get('FSW\Services\Facade\ZoraFacade');
                //$zoraFacade->processOAIItem();
                $zoraFacade->insertIntoFSWExtended();
                //$oaiClient = $zoraFacade->getOAIClient();

                //missing set config, do something
                //$oaiClient->setStartDate($this->params()->fromQuery('from',null));
                //$oaiClient->setEndDate($this->params()->fromQuery('until',null));


                //$oaiClient->launch();

            }
        }



        // All done.
        //Console::writeLine(
        //    "Completed without errors -- {$processed} source(s) processed."
        //);
        return $this->getSuccessResponse();
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
