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

class ZoraDoc extends BaseModel implements InputFilterAwareInterface{


    public $author;
    public $datestamp;
    public $id;
    public $oai_identifier;
    public $status;
    public $title;
    public $xmlrecord;
    public $year;



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
     * Get list label key
     *
     * @return    String
     */
    public function getListLabel()
    {
        // TODO: Implement getListLabel() method.
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $datestamp
     */
    public function setDatestamp($datestamp)
    {
        $this->datestamp = $datestamp;
    }

    /**
     * @return mixed
     */
    public function getDatestamp()
    {
        return $this->datestamp;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $oai_identifier
     */
    public function setOai_identifier($oai_identifier)
    {
        $this->oai_identifier = $oai_identifier;
    }

    /**
     * @return mixed
     */
    public function getOai_identifier()
    {
        return $this->oai_identifier;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $xmlrecord
     */
    public function setXmlrecord($xmlrecord)
    {
        $this->xmlrecord = $xmlrecord;
    }

    /**
     * @return mixed
     */
    public function getXmlrecord()
    {
        return $this->xmlrecord;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }



}