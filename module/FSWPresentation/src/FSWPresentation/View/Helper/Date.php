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



class Date extends AbstractHelper{

    public function __invoke($dateString, $mode = 'medium') {

        if ($dateString == '0000-00-00 00:00:00') {
            return '-';
        }

        switch ($mode) {

            case 'long':
                $dateType = \IntlDateFormatter::LONG;
                $timeType = \IntlDateFormatter::LONG;
                break;
            case 'short';
                $dateType = \IntlDateFormatter::SHORT;
                $timeType = \IntlDateFormatter::SHORT;
                break;
            case 'dateonly';
                $dateType = \IntlDateFormatter::MEDIUM;
                $timeType = \IntlDateFormatter::NONE;
                break;
            default:
            case 'medium':
                $dateType = \IntlDateFormatter::MEDIUM;
                $timeType = \IntlDateFormatter::MEDIUM;
                break;

        }

        $dateTime = new \DateTime($dateString);
        return $this->getView()->dateFormat($dateTime,$dateType,$timeType);
    }


} 