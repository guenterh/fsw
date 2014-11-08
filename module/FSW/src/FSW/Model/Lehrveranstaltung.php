<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 18.04.14
 * Time: 14:58
 */

namespace FSW\Model;


use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Lehrveranstaltung extends BaseModel implements InputFilterAwareInterface{






    public $id;

    public $von_zeit;
    public $bis_zeit;
    public $semester;
    public $titel;
    public $tag;
    public $vvzlink;
    public $olatlink;



    /**
     * Set input filter
     *
     * @param  InputFilterInterface $inputFilter
     * @return InputFilterAwareInterface
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        // TODO: Implement setInputFilter() method.
    }

    /**
     * Retrieve input filter
     *
     * @return InputFilterInterface
     */
    public function getInputFilter()
    {
        // TODO: Implement getInputFilter() method.
    }

    /**
     * Get record ID
     *
     * @return    Integer
     */
    public function getId()
    {
       $this->id;
    }

    /**
     * Get list label key
     *
     * @return    String
     */
    public function getListLabel()
    {
        // TODO: Implement getListLabel() method.
    }

    /**
     * @return mixed
     */
    public function getBis_zeit()
    {
        return $this->bis_zeit;
    }

    /**
     * @param mixed $bis_zeit
     */
    public function setBis_zeit($bis_zeit)
    {
        $this->bis_zeit = $bis_zeit;
    }

    /**
     * @return mixed
     */
    public function getOlatlink()
    {
        return $this->olatlink;
    }

    /**
     * @param mixed $olatlink
     */
    public function setOlatlink($olatlink)
    {
        $this->olatlink = $olatlink;
    }

    /**
     * @return mixed
     */
    public function getSemester()
    {
        return $this->semester;
    }

    /**
     * @param mixed $semester
     */
    public function setSemester($semester)
    {
        $this->semester = $semester;
    }

    /**
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param mixed $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return mixed
     */
    public function getTitel()
    {
        return $this->titel;
    }

    /**
     * @param mixed $titel
     */
    public function setTitel($titel)
    {
        $this->titel = $titel;
    }

    /**
     * @return mixed
     */
    public function getVon_zeit()
    {
        return $this->von_zeit;
    }

    /**
     * @param mixed $von_zeit
     */
    public function setVon_zeit($von_zeit)
    {
        $this->von_zeit = $von_zeit;
    }

    /**
     * @return mixed
     */
    public function getVvzlink()
    {
        return $this->vvzlink;
    }

    /**
     * @param mixed $vvzlink
     */
    public function setVvzlink($vvzlink)
    {
        $this->vvzlink = $vvzlink;
    }




}