<?php

declare(strict_types=1);

use Sophie\Throws\Exception\ShouldHaveNotThrownException;
use Sophie\Throws\ExceptionNet\NoExceptionNet;
use Sophie\Throws\Runnable\RunnableInterface;

###########################################################################
# Prepare structs
###########################################################################

$notThrowingRunnable = mock(RunnableInterface::class);
$notThrowingRunnable
    ->shouldReceive('run');

$throwingRunnable = mock(RunnableInterface::class);
$throwingRunnable
    ->shouldReceive('run')
    ->andThrow(Exception::class);

###########################################################################
# Should not throw an exception when no exception has been
# thrown from the callable
###########################################################################

(
    new NoExceptionNet($notThrowingRunnable)
)->catch();

###########################################################################
# Should throw a ShouldHaveNotThrownException when an exception has been
# thrown from the callable
###########################################################################

try {
    (
        new NoExceptionNet($throwingRunnable)
    )->catch();
    assert(false);
} catch (ShouldHaveNotThrownException $e) {
}
