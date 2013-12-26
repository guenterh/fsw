<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 12/26/13
 * Time: 4:54 PM
 */

namespace FSW\Model;


class Medium {


    public $medienid;
    public $mit_id;
    public $sendetitel;
    public $gespraechstitel;
    public $link;
    public $icon;
    public $datum;
    public $medientyp;

    public function exchangeArray($data)
    {
        $this->medienid     = (isset($data['id'])) ? $data['id'] : null;
        $this->mit_id = (isset($data['mit_id'])) ? $data['mit_id'] : null;
        $this->sendetitel  = (isset($data['sendetitel'])) ? $data['sendetitel'] : null;
        $this->gespraechstitel  = (isset($data['gespraechstitel'])) ? $data['gespraechstitel'] : null;
        $this->link  = (isset($data['link'])) ? $data['link'] : null;
        $this->icon  = (isset($data['icon'])) ? $data['icon'] : null;
        $this->datum  = (isset($data['datum'])) ? $data['datum'] : null;
        $this->medientyp  = (isset($data['medientyp'])) ? $data['medientyp'] : null;


    }

} 