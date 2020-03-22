<?php

declare(strict_types=1);

namespace Spec\NoSpecificExceptionNet;

use Exception;
use Sophie\Throws\Exception\ShouldHaveNotThrownException;
use Sophie\Throws\ExceptionNet\NoSpecificExceptionNet;
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
# Should not throw an exception when no exception has been
# thrown from the callable
###########################################################################

(
    new NoSpecificExceptionNet(
        $notThrowingException,
        TestException::class,
        OtherTestException::class,
    )
)->catch();

###########################################################################
# Should not throw an exception when an unhandled TestException has been
# thrown from the callable
###########################################################################

(
    new NoSpecificExceptionNet(
        $throwingTestException,
        OtherTestException::class,
        AnotherTestException::class,
    )
)->catch();

###########################################################################
# Should throw a ShouldHaveNotThrownException when a handled
# OtherTestException has been thrown from the callable
###########################################################################

try {
    (
        new NoSpecificExceptionNet(
            $throwingOtherTestException,
            OtherTestException::class,
            AnotherTestException::class,
        )
    )->catch();
    assert(false);
} catch (ShouldHaveNotThrownException $e) {
}

###########################################################################
# Should throw a ShouldHaveNotThrownException when a handled
# AnotherTestException has been thrown from the callable
###########################################################################

try {
    (
        new NoSpecificExceptionNet(
            $throwingAnotherTestException,
            OtherTestException::class,
            AnotherTestException::class,
        )
    )->catch();
    assert(false);
} catch (ShouldHaveNotThrownException $e) {
}

###########################################################################
# Should throw a ShouldHaveNotThrownException when a handled
# exception's child has been thrown from the callable
###########################################################################

try {
    (
        new NoSpecificExceptionNet(
            $throwingAnotherTestException,
            Exception::class
        )
    )->catch();
    assert(false);
} catch (ShouldHaveNotThrownException $e) {
}
