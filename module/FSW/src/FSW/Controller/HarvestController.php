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

use FSW\Form\HarvestFormEntities;
use FSW\Form\HarvestFormFromUntil;
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

    /*
     * @var \FSW\Services\OAI
     *
     */
    protected $oaiClient;

    public function indexAction () {

        $fromUntilForm = new HarvestFormFromUntil();
        $entitiesForm = new HarvestFormEntities();


        return new ViewModel(
            array(
                'formFromUntil'  => $fromUntilForm,
                'formEntities'  =>  $entitiesForm
            )
        );

    }




    protected function startHarvestingListRecords($configName,\Zend\Config\Config $config, $params) {


        if (!isset($params['from'])) {

            throw new \Exception('mandatory parameter from not given');
        }

        $this->oaiClient = $this->facade->getOAIClient();


        $this->oaiClient->setStartDate($params['from']);
        if (isset($params['until']) && strlen($params['until']) > 0) {
            $this->oaiClient->setEndDate($params['until']);
        }

        //$oaiClient->setEndDate('2050-12-31');
        $this->oaiClient->setVerbose($config->verbose);
        $this->oaiClient->setConfig($configName,$config->toArray());

        if ($config->usedSets) {
            $sets = explode('###',$config->usedSets);
            foreach($sets as $set) {

                $this->oaiClient->setOAISet($set);
                $this->oaiClient->launch();
            }
        }

    }



    protected function startHarvestingGetRecord( $params) {



        $this->oaiClient = $this->facade->getOAIClient();
        //$this->oaiClient->setUrlGetRecord($config->GetRecord);

        foreach($params as $entity) {
            $this->oaiClient->launchGetRecord(trim($entity));
        }

    }



    public function harvestFromUntilAction () {

        $fromUntilForm = new HarvestFormFromUntil();
        $entitiesForm = new HarvestFormEntities();

        $messages = array();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $this->params()->fromPost();

            $fromUntilForm->setData($data);
            if ($fromUntilForm->isValid()) {

                $oaiConfig = $this->getServiceLocator()->get('FSW\Config')->get('oai');
                $zoraConfig = $oaiConfig->Zora;
                $from = $data['harvest_from_until']['from'];
                $until = $data['harvest_from_until']['until'];

                $params = compact('from', 'until');

                $this->startHarvestingListRecords('Zora',$zoraConfig, $params);

                //$entities =  explode('##',$entitiesConcat);
                //$this->startHarvestingGetRecord($zoraConfig, $entities);

                $messages = $this->facade->getMessages();
            }

        }


        $viewModel = new ViewModel(
            array(
                'formFromUntil'  => $fromUntilForm,
                'formEntities'  =>  $entitiesForm,
                'messages'  => $messages

            )
        );
        return $viewModel;


    }

    public function harvestEntitiesAction () {

        $fromUntilForm = new HarvestFormFromUntil();
        $entitiesForm = new HarvestFormEntities();
        $messages = array();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $this->params()->fromPost();

            $entitiesForm->setData($data);

            if ($entitiesForm->isValid()) {
                //$oaiConfig = $this->getServiceLocator()->get('FSW\Config')->get('oai');
                //$zoraConfig = $oaiConfig->Zora;
                $entitiesConcat = $data['harvest_entities']['entities'];
                $entities =  explode('##',$entitiesConcat);
                $this->startHarvestingGetRecord($entities);

                $messages = $this->facade->getMessages();

            }

        }


        $viewModel = new ViewModel(
            array(
                'formFromUntil'  => $fromUntilForm,
                'formEntities'  =>  $entitiesForm,
                'messages'   => $messages
            )
        );
        return $viewModel;

    }


}
