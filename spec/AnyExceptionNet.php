<?php

declare(strict_types=1);

use Sophie\Throws\Exception\ShouldHaveThrownException;
use Sophie\Throws\ExceptionNet\AnyExceptionNet;
use Sophie\Throws\Runnable\RunnableInterface;

###########################################################################
# Prepare structs
###########################################################################

$throwingRunnable = mock(RunnableInterface::class);
$throwingRunnable
    ->shouldReceive('run')
    ->andThrow(Exception::class);

$notThrowingRunnable = mock(RunnableInterface::class);
$notThrowingRunnable
    ->shouldReceive('run');

###########################################################################
# Should not throw an exception when an exception has been
# thrown from the callable
###########################################################################

(
    new AnyExceptionNet($throwingRunnable)
)->catch();

###########################################################################
# Should throw a ShouldHaveThrownException when no exception has been
# thrown from the callable
###########################################################################

try {
    (
        new AnyExceptionNet($notThrowingRunnable)
    )->catch();
    assert(false);
} catch (ShouldHaveThrownException $e) {
}
