<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 1/15/14
 * Time: 9:45 PM
 */

namespace FSW\Model;


class Veranstaltungen {

    protected $veranstaltungenTable;

    public function __construct(KolloqiumVeranstaltungTable $veranstaltungenTable) {

        $this->veranstaltungenTable = $veranstaltungenTable;

    }

    public function getVeranstaltungen ($kolloquiumID) {

        $veranstaltungen = $this->veranstaltungenTable->getKolloquiumVeranstaltungen($kolloquiumID);
        return $veranstaltungen;
    }

} 