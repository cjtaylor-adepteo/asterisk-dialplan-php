<?php

use Clearvox\Asterisk\Dialplan\Reader\Application\NoOpReader;
use Clearvox\Asterisk\Dialplan\Reader\Line\ExtenLineReader;
use Clearvox\Asterisk\Dialplan\Reader\Reader;
use PHPUnit\Framework\TestCase;

class ReaderTest extends TestCase
{
    /**
     * @var Reader
     */
    public $reader;

    public function setUp()
    {
        $this->reader = new Reader([new ExtenLineReader([new NoOpReader])]);
    }

    public function testSimpleDialplan()
    {
        $dialplan = $this->reader->read(file_get_contents(__DIR__ . '/source-examples/simple-dialplan.txt'));

        $this->assertEquals('dialplan_context_1', $dialplan->getName());
        $this->assertEquals(3, count($dialplan->getLines()));
    }

    public function testAdvancedDialplan()
    {
        $dialplan = $this->reader->read(file_get_contents(__DIR__ . '/source-examples/advanced-dialplan.txt'));

        $this->assertEquals('ea91e4f9-633c-4fa6-b357-438078ecf585', $dialplan->getName());
        $this->assertEquals(28, count($dialplan->getLines()));
    }

    public function testExtendedDialplan()
    {
        $dialplan = $this->reader->read(file_get_contents(__DIR__ . '/source-examples/extended-dialplan.txt'));

        $this->assertEquals('something_unattached', $dialplan->getName());
        $this->assertTrue($dialplan->isExtended());
    }

    public function testNumberVariantDialplan()
    {
        $dialplan = $this->reader->read(file_get_contents(__DIR__ . '/source-examples/number-variant.txt'));

        $this->assertEquals('number_incoming', $dialplan->getName());
        $this->assertEquals(4, count($dialplan->getLines()));
    }
}