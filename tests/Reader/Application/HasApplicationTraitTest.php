<?php

namespace Reader\Application;

use Clearvox\Asterisk\Dialplan\Application\ApplicationInterface;
use Clearvox\Asterisk\Dialplan\Application\UndeterminedApplication;
use Clearvox\Asterisk\Dialplan\Reader\Application\ApplicationReaderInterface;
use Clearvox\Asterisk\Dialplan\Reader\Application\HasApplicationTrait;
use PHPUnit\Framework\TestCase;

class HasApplicationTraitTest extends TestCase
{
    public function testFindApplicationWithKnownApplication()
    {
        $hasApplication = $this->getObjectForTrait(HasApplicationTrait::class);

        $noOpApplication = $this->createMock(ApplicationReaderInterface::class);
        $noOpApplication
            ->expects($this->once())
            ->method('getMatchFormat')
            ->willReturn('/(NoOp)\((.+)\)/');

        $noOpMock = $this->createMock(ApplicationInterface::class);
        $noOpMock
            ->expects($this->once())
            ->method('getName')
            ->willReturn('NoOp');

        $noOpMock
            ->expects($this->once())
            ->method('getData')
            ->willReturn('this is an example');

        $noOpApplication
            ->expects($this->once())
            ->method('getInstance')
            ->willReturn($noOpMock);

        $applications = [];
        $applications[] = $noOpApplication;

        $application = $hasApplication->findApplication("NoOp(this is an example)", $applications);

        $this->assertTrue($application instanceof ApplicationInterface);
        $this->assertEquals('NoOp', $application->getName());
        $this->assertEquals('this is an example', $application->getData());
    }

    public function testFindApplicationWithUnknownApplication()
    {
        /** @var HasApplicationTrait $hasApplication */
        $hasApplication = $this->getObjectForTrait(HasApplicationTrait::class);

        $applications = [];
        $application  = $hasApplication->findApplication('Testing(hello there)', $applications);

        $this->assertTrue($application instanceof UndeterminedApplication);
        $this->assertEquals('Testing', $application->getName());
        $this->assertEquals('hello there', $application->getData());
    }
}