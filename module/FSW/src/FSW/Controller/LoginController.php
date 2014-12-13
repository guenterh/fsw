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
use FSW\Form\LoginForm;
use FSW\Model\User;
use FSW\Services\OAI;
use Zend\Console\Console;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use FSW\Exception\Auth as AuthException;

/**
 * This controller handles various command-line tools
 *
 * @category VuFind2
 * @package  Controller
 * @author   Chris Hallberg <challber@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     http://vufind.org/wiki/vufind2:building_a_controller Wiki
 */



class LoginController extends BaseController {
    public function loginAction()
    {

        if ($this->getRequest()->isGet()) {

            $form = new LoginForm();
            $user = new User();
            $user->setId(0);
            $form->bind($user);

        } else {

            //run validate and save
            $form = new LoginForm();
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                //$this->getMediumTable()->saveMedium($medium);
                try {
                    $this->getAuthManager()->login($this->getRequest());
                    $url = $this->followup()->retrieve('url');
                    if (empty($url) || strlen($url) == 0) {
                        $config = $this->fswConfig->get('config');
                        $url = $config->Site->afterLoginRoute;
                    }
                    return $this->redirect()->toUrl($url);


                } catch (AuthException   $e) {
                    $this->processAuthenticationException($e);
                }
            } else {
                $test =  $form->getMessages();
                $eins = "";
            }


        }


        return new ViewModel(array(
            'form' => $form
        ));


    }

    public function logoutAction() {

        $config = $this->fswConfig->get('config');

        $url = $this->followup()->retrieve('url');
        if (empty($url) || strlen($url) == 0) {

        }
        if (isset($config->Site->logOutRoute)) {

            //$logoutTarget = $this->getServerUrl($config->Site->logOutRoute);
            $logoutTarget = $config->Site->logOutRoute;
        } else {
            $logoutTarget = $this->getRequest()->getServer()->get('HTTP_REFERER');
            if (empty($logoutTarget)) {
                $logoutTarget = $this->getServerUrl('home');
            }

            // If there is an auth_method parameter in the query, we should strip
            // it out. Otherwise, the user may get stuck in an infinite loop of
            // logging out and getting logged back in when using environment-based
            // authentication methods like Shibboleth.
            $logoutTarget = preg_replace(
                '/([?&])auth_method=[^&]*&?/', '$1', $logoutTarget
            );
            $logoutTarget = rtrim($logoutTarget, '?');
        }

        return $this->redirect()
            ->toUrl($this->getAuthManager()->logout($logoutTarget));


    }


    protected function processAuthenticationException(AuthException $e)
    {
        $msg = $e->getMessage();
        // If a Shibboleth-style login has failed and the user just logged
        // out, we need to override the error message with a more relevant
        // one:
        if ($msg == 'authentication_error_admin'
            && $this->getAuthManager()->userHasLoggedOut()
            //&& $this->getSessionInitiator()
        ) {
            $msg = 'authentication_error_loggedout';
        }
        $this->flashMessenger()->setNamespace('error')->addMessage($msg);
    }



}
