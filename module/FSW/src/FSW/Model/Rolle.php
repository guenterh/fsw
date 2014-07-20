<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 7/20/14
 * Time: 2:30 PM
 */

namespace FSW\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;



class Rolle extends BaseModel implements InputFilterAwareInterface  {

    protected  $roll_id;
    protected  $roll_pers_id;
    protected  $roll_abt_id;
    protected  $roll_arbe_id;
    protected  $roll_skv_id;
    protected  $roll_funk_id;
    protected  $roll_istangestellt;
    protected  $roll_anstellung;
    protected  $roll_persnr;
    protected  $roll_datestart;
    protected  $roll_dateend;
    protected  $roll_anstellungprozent;
    protected  $roll_befristet;
    protected  $roll_email;
    protected  $roll_telg;
    protected  $roll_url;
    protected  $roll_hs_fsw;
    protected  $roll_mund_pruf;
    protected  $roll_verteiler_skeinladung;
    protected  $roll_verteiler_mittelbau;
    protected  $roll_verteiler_skprotokoll;
    protected  $roll_verteiler_profs;
    protected  $roll_verteiler_koordag;
    protected  $roll_verteiler_koordma;
    protected  $roll_verteiler_koordnz;
    protected  $roll_changedate;
    protected  $roll_oldid;
    protected  $roll_fswfunktion;


    protected $inputFilter;


    /**
     * Get record ID
     *
     * @return    Integer
     */
    public function getId()
    {
        return $this->roll_id;
    }

    /**
     * Get list label key
     *
     * @return    String
     */
    public function getListLabel()
    {
        return $this->roll_id . ' ' . $this->roll_pers_id;
    }

    /**
     * Set input filter
     *
     * @param  InputFilterInterface $inputFilter
     * @return InputFilterAwareInterface
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
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
                'name'     => 'roll_id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));
        }

        return $this->inputFilter;
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
    public function getRoll_abt_id()
    {
        return $this->roll_abt_id;
    }

    /**
     * @param mixed $roll_anstellung
     */
    public function setRoll_anstellung($roll_anstellung)
    {
        $this->roll_anstellung = $roll_anstellung;
    }

    /**
     * @return mixed
     */
    public function getRoll_anstellung()
    {
        return $this->roll_anstellung;
    }

    /**
     * @param mixed $roll_anstellungprozent
     */
    public function setRoll_anstellungprozent($roll_anstellungprozent)
    {
        $this->roll_anstellungprozent = $roll_anstellungprozent;
    }

    /**
     * @return mixed
     */
    public function getRoll_anstellungprozent()
    {
        return $this->roll_anstellungprozent;
    }

    /**
     * @param mixed $roll_arbe_id
     */
    public function setRoll_arbe_id($roll_arbe_id)
    {
        $this->roll_arbe_id = $roll_arbe_id;
    }

    /**
     * @return mixed
     */
    public function getRoll_arbe_id()
    {
        return $this->roll_arbe_id;
    }

    /**
     * @param mixed $roll_befristet
     */
    public function setRoll_befristet($roll_befristet)
    {
        $this->roll_befristet = $roll_befristet;
    }

    /**
     * @return mixed
     */
    public function getRoll_befristet()
    {
        return $this->roll_befristet;
    }

    /**
     * @param mixed $roll_changedate
     */
    public function setRoll_changedate($roll_changedate)
    {
        $this->roll_changedate = $roll_changedate;
    }

    /**
     * @return mixed
     */
    public function getRoll_changedate()
    {
        return $this->roll_changedate;
    }

    /**
     * @param mixed $roll_dateend
     */
    public function setRoll_dateend($roll_dateend)
    {
        $this->roll_dateend = $roll_dateend;
    }

    /**
     * @return mixed
     */
    public function getRoll_dateend()
    {
        return $this->roll_dateend;
    }

    /**
     * @param mixed $roll_datestart
     */
    public function setRoll_datestart($roll_datestart)
    {
        $this->roll_datestart = $roll_datestart;
    }

    /**
     * @return mixed
     */
    public function getRoll_datestart()
    {
        return $this->roll_datestart;
    }

    /**
     * @param mixed $roll_email
     */
    public function setRoll_email($roll_email)
    {
        $this->roll_email = $roll_email;
    }

    /**
     * @return mixed
     */
    public function getRoll_email()
    {
        return $this->roll_email;
    }

    /**
     * @param mixed $roll_fswfunktion
     */
    public function setRoll_fswfunktion($roll_fswfunktion)
    {
        $this->roll_fswfunktion = $roll_fswfunktion;
    }

    /**
     * @return mixed
     */
    public function getRoll_fswfunktion()
    {
        return $this->roll_fswfunktion;
    }

    /**
     * @param mixed $roll_funk_id
     */
    public function setRoll_funk_id($roll_funk_id)
    {
        $this->roll_funk_id = $roll_funk_id;
    }

    /**
     * @return mixed
     */
    public function getRoll_funk_id()
    {
        return $this->roll_funk_id;
    }

    /**
     * @param mixed $roll_hs_fsw
     */
    public function setRoll_hs_fsw($roll_hs_fsw)
    {
        $this->roll_hs_fsw = $roll_hs_fsw;
    }

    /**
     * @return mixed
     */
    public function getRoll_hs_fsw()
    {
        return $this->roll_hs_fsw;
    }

    /**
     * @param mixed $roll_id
     */
    public function setRoll_id($roll_id)
    {
        $this->roll_id = $roll_id;
    }

    /**
     * @return mixed
     */
    public function getRoll_id()
    {
        return $this->roll_id;
    }

    /**
     * @param mixed $roll_istangestellt
     */
    public function setRoll_istangestellt($roll_istangestellt)
    {
        $this->roll_istangestellt = $roll_istangestellt;
    }

    /**
     * @return mixedm
     */
    public function getRoll_istangestellt()
    {
        return $this->roll_istangestellt;
    }

    /**
     * @param mixed $roll_mund_pruf
     */
    public function setRoll_mund_pruf($roll_mund_pruf)
    {
        $this->roll_mund_pruf = $roll_mund_pruf;
    }

    /**
     * @return mixed
     */
    public function getRoll_mund_pruf()
    {
        return $this->roll_mund_pruf;
    }

    /**
     * @param mixed $roll_oldid
     */
    public function setRoll_oldid($roll_oldid)
    {
        $this->roll_oldid = $roll_oldid;
    }

    /**
     * @return mixed
     */
    public function getRoll_oldid()
    {
        return $this->roll_oldid;
    }

    /**
     * @param mixed $roll_pers_id
     */
    public function setRoll_pers_id($roll_pers_id)
    {
        $this->roll_pers_id = $roll_pers_id;
    }

    /**
     * @return mixed
     */
    public function getRoll_pers_id()
    {
        return $this->roll_pers_id;
    }

    /**
     * @param mixed $roll_persnr
     */
    public function setRoll_persnr($roll_persnr)
    {
        $this->roll_persnr = $roll_persnr;
    }

    /**
     * @return mixed
     */
    public function getRoll_persnr()
    {
        return $this->roll_persnr;
    }

    /**
     * @param mixed $roll_skv_id
     */
    public function setRoll_skv_id($roll_skv_id)
    {
        $this->roll_skv_id = $roll_skv_id;
    }

    /**
     * @return mixed
     */
    public function getRoll_skv_id()
    {
        return $this->roll_skv_id;
    }

    /**
     * @param mixed $roll_telg
     */
    public function setRoll_telg($roll_telg)
    {
        $this->roll_telg = $roll_telg;
    }

    /**
     * @return mixed
     */
    public function getRoll_telg()
    {
        return $this->roll_telg;
    }

    /**
     * @param mixed $roll_url
     */
    public function setRoll_url($roll_url)
    {
        $this->roll_url = $roll_url;
    }

    /**
     * @return mixed
     */
    public function getRoll_url()
    {
        return $this->roll_url;
    }

    /**
     * @param mixed $roll_verteiler_koordag
     */
    public function setRoll_verteiler_koordag($roll_verteiler_koordag)
    {
        $this->roll_verteiler_koordag = $roll_verteiler_koordag;
    }

    /**
     * @return mixed
     */
    public function getRoll_verteiler_koordag()
    {
        return $this->roll_verteiler_koordag;
    }

    /**
     * @param mixed $roll_verteiler_koordma
     */
    public function setRoll_verteiler_koordma($roll_verteiler_koordma)
    {
        $this->roll_verteiler_koordma = $roll_verteiler_koordma;
    }

    /**
     * @return mixed
     */
    public function getRoll_verteiler_koordma()
    {
        return $this->roll_verteiler_koordma;
    }

    /**
     * @param mixed $roll_verteiler_koordnz
     */
    public function setRoll_verteiler_koordnz($roll_verteiler_koordnz)
    {
        $this->roll_verteiler_koordnz = $roll_verteiler_koordnz;
    }

    /**
     * @return mixed
     */
    public function getRoll_verteiler_koordnz()
    {
        return $this->roll_verteiler_koordnz;
    }

    /**
     * @param mixed $roll_verteiler_mittelbau
     */
    public function setRoll_verteiler_mittelbau($roll_verteiler_mittelbau)
    {
        $this->roll_verteiler_mittelbau = $roll_verteiler_mittelbau;
    }

    /**
     * @return mixed
     */
    public function getRoll_verteiler_mittelbau()
    {
        return $this->roll_verteiler_mittelbau;
    }

    /**
     * @param mixed $roll_verteiler_profs
     */
    public function setRoll_verteiler_profs($roll_verteiler_profs)
    {
        $this->roll_verteiler_profs = $roll_verteiler_profs;
    }

    /**
     * @return mixed
     */
    public function getRoll_verteiler_profs()
    {
        return $this->roll_verteiler_profs;
    }

    /**
     * @param mixed $roll_verteiler_skeinladung
     */
    public function setRoll_verteiler_skeinladung($roll_verteiler_skeinladung)
    {
        $this->roll_verteiler_skeinladung = $roll_verteiler_skeinladung;
    }

    /**
     * @return mixed
     */
    public function getRoll_verteiler_skeinladung()
    {
        return $this->roll_verteiler_skeinladung;
    }

    /**
     * @param mixed $roll_verteiler_skprotokoll
     */
    public function setRoll_verteiler_skprotokoll($roll_verteiler_skprotokoll)
    {
        $this->roll_verteiler_skprotokoll = $roll_verteiler_skprotokoll;
    }

    /**
     * @return mixed
     */
    public function getRoll_verteiler_skprotokoll()
    {
        return $this->roll_verteiler_skprotokoll;
    }




}