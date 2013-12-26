<?php


namespace AlbumTest\Model;

use FSW\Model\Medium;
use PHPUnit_Framework_TestCase;

class AlbumTest extends PHPUnit_Framework_TestCase
{
    public function testAlbumInitialState()
    {
        $medien = new Medium();

        $this->assertNull($medien->datum, '"datum" should initially be null');
        $this->assertNull($medien->gespraechstitel, '"gespraechstitel" should initially be null');
        $this->assertNull($medien->icon, '"icon" should initially be null');
        $this->assertNull($medien->link, '"link" should initially be null');
        $this->assertNull($medien->medienid, '"medienid" should initially be null');
        $this->assertNull($medien->medientyp, '"medientyp" should initially be null');
        $this->assertNull($medien->mit_id, '"mit_id" should initially be null');
        $this->assertNull($medien->sendetitel, '"sendetitel" should initially be null');
    }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $medien = new Medium();
        $data  = array('gespraechstitel' => 'ein gespraechstitel',
        'mit_id'     => 123,
        'datum'  => '2012-12-12',
        'icon'  => 'ein icon',
        'link'  => 'ein link',


        );

        $medien->exchangeArray($data);

        $this->assertSame($data['gespraechstitel'], $medien->gespraechstitel, '"gespraechstitel" was not set correctly');
        $this->assertSame($data['mit_id'], $medien->mit_id, '"mit_id" was not set correctly');
        $this->assertSame($data['datum'], $medien->datum, '"datum" was not set correctly');
        $this->assertSame($data['icon'], $medien->icon, '"icon" was not set correctly');
        $this->assertSame($data['link'], $medien->link, '"link" was not set correctly');
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $medien = new Medium();

        $medien->exchangeArray(array('gespraechstitel' => 'neuer gespraechstitel',
        'mit_id'     => 789,
        'datum'  => '2013-12-24',
        'icon'   => 'neues icon' ,
        'link'   => 'neuer link')
        );
        $medien->exchangeArray(array());

        $this->assertNull($medien->sendetitel, '"sendetitel" should have defaulted to null');
        $this->assertNull($medien->mit_id, '"mit_id" should have defaulted to null');
        $this->assertNull($medien->medienid, '"medienid" should have defaulted to null');
    }
}