<?php
/**
 * Created by PhpStorm.
 * User: guenterh
 * Date: 15.08.18
 * Time: 20:34
 */

namespace FSWPresentation\View\Helper;

use Zend\View\Helper\AbstractHelper;



class ChangeToHttps extends AbstractHelper
{
    public function __invoke($url) {
        return preg_replace('/http:/','https:',$url);
    }


}