<?php

declare(strict_types=1);

namespace Sophie\Throws;

use Sophie\Throws\ExceptionNet\NoExceptionNet;
use Sophie\Throws\ExceptionNet\NoSpecificExceptionNet;
use Sophie\Throws\Runnable\Runnable;

/**
 * Facade.
 */
function throws_not(callable $callable, string ...$types): void
{
    $class =
        count($types) ? NoSpecificExceptionNet::class : NoExceptionNet::class;
    (
        new $class(
            new Runnable($callable),
            ...$types
        )
    )->catch();
}
