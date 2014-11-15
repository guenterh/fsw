<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 18.04.14
 * Time: 14:54
 */

namespace FSW\Model;


use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ZoraDocWithCover extends ZoraDoc {


    public $coverlink;

    /**
     * @return mixed
     */
    public function getCoverlink()
    {
        return $this->coverlink;
    }

    /**
     * @param mixed $coverlink
     */
    public function setCoverlink($coverlink)
    {
        $this->coverlink = $coverlink;
    }



}