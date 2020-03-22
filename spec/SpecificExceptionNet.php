<?php

declare(strict_types=1);

namespace Spec\SpecificExceptionNet;

use Exception;
use Sophie\Throws\Exception\ShouldHaveNotThrownException;
use Sophie\Throws\Exception\ShouldHaveThrownException;
use Sophie\Throws\ExceptionNet\SpecificExceptionNet;
use Sophie\Throws\Runnable\RunnableInterface;

###########################################################################
# Prepare structs
###########################################################################

final class TestException extends Exception
{
}
final class OtherTestException extends Exception
{
}
final class AnotherTestException extends Exception
{
}

$notThrowingException = mock(RunnableInterface::class);
$notThrowingException
    ->shouldReceive('run');

$throwingTestException = mock(RunnableInterface::class);
$throwingTestException
    ->shouldReceive('run')
    ->andThrow(TestException::class);

$throwingOtherTestException = mock(RunnableInterface::class);
$throwingOtherTestException
    ->shouldReceive('run')
    ->andThrow(OtherTestException::class);

$throwingAnotherTestException = mock(RunnableInterface::class);
$throwingAnotherTestException
    ->shouldReceive('run')
    ->andThrow(AnotherTestException::class);

###########################################################################
# Should throw a ShouldHaveThrownException when no exception has been
# thrown from the callable
###########################################################################

try {
    (
        new SpecificExceptionNet(
            $notThrowingException,
            TestException::class,
            OtherTestException::class,
        )
    )->catch();
    assert(false);
} catch (ShouldHaveThrownException $e) {
}

###########################################################################
# Should not throw an exception when a handled TestException has been
# thrown from the callable
###########################################################################

(
    new SpecificExceptionNet(
        $throwingTestException,
        TestException::class,
        OtherTestException::class,
    )
)->catch();

###########################################################################
# Should not throw an exception when a handled OtherTestException has been
# thrown from the callable
###########################################################################

(
    new SpecificExceptionNet(
        $throwingOtherTestException,
        TestException::class,
        OtherTestException::class,
    )
)->catch();

###########################################################################
# Should throw a ShouldHaveNotThrownException when an unhandled
# AnotherTestException has been thrown from the callable
###########################################################################

try {
    (
        new SpecificExceptionNet(
            $throwingAnotherTestException,
            TestException::class,
            OtherTestException::class,
        )
    )->catch();
    assert(false);
} catch (ShouldHaveNotThrownException $e) {
}

###########################################################################
# Should not throw an exception when a handled exception's child
# has been thrown
###########################################################################

(
    new SpecificExceptionNet(
        $throwingAnotherTestException,
        Exception::class
    )
)->catch();
