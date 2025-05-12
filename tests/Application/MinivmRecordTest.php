<?php

namespace Application;

use Clearvox\Asterisk\Dialplan\Application\MinivmRecord;
use PHPUnit\Framework\TestCase;

class MinivmRecordTest extends TestCase
{
    /**
     * @var MinivmRecord
     */
    public $minivmRecord;

    public function setUp(): void
    {
        $this->minivmRecord = new MinivmRecord('example@host.com', ['0']);
    }

    public function testGetName()
    {
        $this->assertEquals('MinivmRecord', $this->minivmRecord->getName());
    }

    public function testGetOptions()
    {
        $expected = ['0'];
        $this->assertEquals($expected, $this->minivmRecord->getOptions());
    }

    public function testGetData()
    {
        $expected = 'example@host.com,0';
        $this->assertEquals($expected, $this->minivmRecord->getData());
    }

    public function testToArray()
    {
        $expected = ['account' => 'example@host.com', 'options' => ['0']];
        $this->assertEquals($expected, $this->minivmRecord->toArray());
    }

    public function testToJson()
    {
        $expected = json_encode(['account' => 'example@host.com', 'options' => ['0']]);
        $this->assertEquals($expected, $this->minivmRecord->toJson());
    }
}