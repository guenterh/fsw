<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 17.11.14
 * Time: 20:44
 */

namespace FSWPresentation\View\Helper;


use Zend\Form\Element\DateTime;
use Zend\View\Helper\AbstractHelper;



class InternalExternalLink extends AbstractHelper{

    public function __invoke() {
        return $this;

    }

    public function createLink ($link, $subject)
    {
        if ($this->isExternalLink($link))
        {
            $fullLink =    '<a  title="Teaser Link" class="www" href="' . $this->view->changeTohttps($link) . '" target="_blank" >'  . $subject  .   "</a>";
        } else {
            $fullLink = "<a class='internal displayParent' href='" . $this->view->changeTohttps($link) . "' >"  . $subject  .   "</a>";
        }

        return $fullLink;

    }


    protected function isExternalLink ($link)
    {
        return !stristr($link, 'fsw.uzh.ch') ? true : false;
        //return false;

    }

} 