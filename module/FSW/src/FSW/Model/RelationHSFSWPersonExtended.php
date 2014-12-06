<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 12/26/13
 * Time: 4:54 PM
 */

namespace FSW\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


/*
 * fuer die Anzeige Beziehungen zwischen Rolle / Person / FSW Person / Extended
 */
class RelationHSFSWPersonExtended extends RelationHSFSWPerson {



    protected $roll_hs_fsw;
    protected $roll_abt_id;

    /**
     * @return mixed
     */
    public function getRoll_abt_id()
    {
        return $this->roll_abt_id;
    }

    /**
     * @param mixed $roll_abt_id
     */
    public function setRoll_abt_id($roll_abt_id)
    {
        $this->roll_abt_id = $roll_abt_id;
    }

    /**
     * @return mixed
     */
    public function getRoll_hs_fsw()
    {
        return $this->roll_hs_fsw;
    }

    /**
     * @param mixed $roll_hs_fsw
     */
    public function setRoll_hs_fsw($roll_hs_fsw)
    {
        $this->roll_hs_fsw = $roll_hs_fsw;
    }


} 