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
        //$this->checkLocalSetting();

        // Parse switches:
        /*
        $this->consoleOpts->addRules(
            array('from-s' => 'Harvest start date', 'until-s' => 'Harvest end date')
        );
        $from = $this->consoleOpts->getOption('from');
        $until = $this->consoleOpts->getOption('until');

        // Read Config files
        $configFile = \VuFind\Config\Locator::getConfigPath('oai.ini', 'harvest');
        $oaiSettings = @parse_ini_file($configFile, true);
        if (empty($oaiSettings)) {
            Console::writeLine("Please add OAI-PMH settings to oai.ini.");
            return $this->getFailureResponse();
        }

        // If first command line parameter is set, see if we can limit to just the
        // specified OAI harvester:
        $argv = $this->consoleOpts->getRemainingArgs();
        if (isset($argv[0])) {
            if (isset($oaiSettings[$argv[0]])) {
                $oaiSettings = array($argv[0] => $oaiSettings[$argv[0]]);
            } else {
                Console::writeLine("Could not load settings for {$argv[0]}.");
                return $this->getFailureResponse();
            }
        }
        */
        $oaiSettings = array(
            'zora' => array(
                'url' =>    'http://www.zora.uzh.ch/cgi/oai2',

            )
        );
        // Loop through all the settings and perform harvests:
        $processed = 0;
        $from = '2014-01-01';
        $until = '2014-04-15';
        $settings = array();
        $target = array();
        //http://www.zora.uzh.ch/cgi/oai2?verb=ListRecords&metadataPrefix=oai_dc&from=2009-10-01&until=2009-10-01
        /*
         * ; url = http://oai.myuniversity.edu/
; set = my_optional_set
; metadataPrefix = oai_dc
; idSearch[] = "/oai:myuniversity.edu:/"
; idReplace[] = "myprefix-"
; injectDate = false
; injectId = false
; injectSetName = false
; injectSetSpec = false
; injectHeaderElements[] = hierarchy
; dateGranularity = auto
; harvestedIdLog = harvest.log
; verbose = false
; sslverifypeer = true
; sanitize = true
; badXMLLog = bad.log
; httpUser = myUsername
; httpPass = myPassword
         */


        $zoraFacade = $this->getServiceLocator()->get('FSW\Services\Facade\ZoraFacade');

        $oaiClient = $zoraFacade->getOAIClient();

        $oaiConfig = $this->getServiceLocator()->get('FSW\Config')->get('oai');

        foreach ($oaiConfig as $sectionName => $oaiSection)
        {
            if (isset($oaiSection->active) && $oaiSection->active && $sectionName == 'Zora') {

                $from = $this->params()->fromQuery('from',null);
                $until = $this->params()->fromQuery('until',null);

                $a = $oaiConfig->Zora->toArray();

                foreach ($oaiSettings as $target => $settings) {
                    if (!empty($target) && !empty($settings)) {
                        //Console::writeLine("Processing {$target}...");
                        try {
                            $client = $this->getServiceLocator()->get('VuFind\Http')
                                ->createClient();
                            $harvest = new OAI($target, $settings, $client, $from, $until);
                            $harvest->launch();
                        } catch (\Exception $e) {
                            //Console::writeLine($e->getMessage());
                            return $this->getFailureResponse();
                        }
                        $processed++;
                    }
                }

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
