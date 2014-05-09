<?php
namespace FSWTest\Model;

use FSW\Model\MediumTable;
use FSW\Model\Medium;
use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;

class MediumTableTest extends PHPUnit_Framework_TestCase
{
    public function testFetchAllReturnsAllAlbums()
    {

        /*
        $resultSet        = new ResultSet();
        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway',
            array('select'), array(), '', false);
        $mockTableGateway->expects($this->once())
            ->method('select')
            ->with()
            ->will($this->returnValue($resultSet));

        $mediumTable = new MediumTable($mockTableGateway);

        $this->assertSame($resultSet, $mediumTable->fetchAll());
        */
    }

    public function testCanRetrieveAnMediumByItsId()
    {
        /*
        $medium = new Medium();
        $medium->exchangeArray(array('medienid'     => 104,
            'sendetitel' => 'ein sendetitel',
            'gespraechstitel'  => 'ein Gespraechstitel'));

        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Medium());
        $resultSet->initialize(array($medium));

        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
        $mockTableGateway->expects($this->once())
            ->method('select')
            ->with(array('medienid' => 104))
            ->will($this->returnValue($resultSet));

        $albumTable = new MediumTable($mockTableGateway);

        $this->assertSame($medium, $albumTable->getMedium(104));
        */
    }

}