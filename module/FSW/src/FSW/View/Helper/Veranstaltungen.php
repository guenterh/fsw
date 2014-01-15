<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 1/15/14
 * Time: 9:21 PM
 */

namespace FSW\View\Helper;

use Zend\View\Helper\AbstractHelper;
use FSW\Model\Veranstaltungen as ModelVeranstaltungen;


class Veranstaltungen extends AbstractHelper {


    protected $veranstaltungen;


    public function __construct(ModelVeranstaltungen $veranstaltungen) {
        $this->veranstaltungen = $veranstaltungen;
    }



    /**
     * Merge author fields to a single list with urls
     *
     * @param    Array    $authors
     * @return    Array[]
     */
    public function __invoke($kolloquiumid)
    {
        $tVeranstaltungen = $this->veranstaltungen->getVeranstaltungen($kolloquiumid);

        return $tVeranstaltungen;
    }


} 