<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 1/7/14
 * Time: 9:37 PM
 */

namespace FSW\Model;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use FSW\Model\VeranstaltungKolloquium;

class Kolloqium extends BaseModel implements InputFilterAwareInterface{


    private $resourceKolloqium;
    private $veranstaltung = array();

    public $id;
    public $id_kolloquium;
    public $titel;

    protected $inputFilter;



    /**
     * Set input filter
     *
     * @param  InputFilterInterface $inputFilter
     * @return InputFilterAwareInterface
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("not used");
    }

    /**
     * Retrieve input filter
     *
     * @return InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {

            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                    'name'     => 'idkolloquium',
                    'required' => true,
                    'filters'  => array(
                        array('name' => 'Int'),
                    ),
                )
            );

            $inputFilter->add(array(
                'name'     => 'titel',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 10000,
                        ),
                    ),
                ),
            ));

            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
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
     * @param mixed $id_kolloquium
     */
    public function setId_kolloquium($id_kolloquium)
    {
        $this->id_kolloquium = $id_kolloquium;
    }

    /**
     * @return mixed
     */
    public function getId_kolloquium()
    {
        return $this->id_kolloquium;
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
    public function getTitel()
    {
        return $this->titel;
    }


    /**
     * Get list label key
     *
     * @return    String
     */
    public function getListLabel()
    {
        return $this->titel;
    }

    public function initFromFile($resource) {
        $this->resourceKolloqium = $resource;
    }


    public function parseFromFile() {

        foreach($this->resourceKolloqium->children() as $attr=>$val)
        {


            switch ($attr) {
                case "idKolloqium":
                    $this->id_kolloquium = (string) $val;
                    break;
                case "titelKolloqium":
                    $this->titel = (string) $val;
                    break;
                case "Veranstaltung":
                    $oVeranstaltung = new VeranstaltungKolloquium();
                    $oVeranstaltung->initFromSource($val);
                    $oVeranstaltung->parse();
                    $this->veranstaltung[] = $oVeranstaltung;


                    break;
                default:
                    //todo: error logging
            }

        }


    }

    /**
     * @return mixed
     */
    public function getVeranstaltung()
    {
        return $this->veranstaltung;
    }

    /**
     * @param mixed $veranstaltung
     */
    public function setVeranstaltung($veranstaltung)
    {


        if (!is_array($veranstaltung) && $veranstaltung instanceof  VeranstaltungKolloquium ) {
            $this->veranstaltung = array($veranstaltung);
        } else if (is_array($veranstaltung)){
            $this->veranstaltung = $veranstaltung;
        }

    }


    public function addVeranstaltung($veranstaltung)
    {
        if ($veranstaltung  instanceof VeranstaltungKolloquium) {
            if (!is_array($this->veranstaltung)) {
                $this->veranstaltung = array();
            }
            $this->veranstaltung[] = $veranstaltung;

        }

    }





}