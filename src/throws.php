<?php

declare(strict_types=1);

namespace Sophie\Throws;

use Sophie\Throws\ExceptionNet\AnyExceptionNet;
use Sophie\Throws\ExceptionNet\SpecificExceptionNet;
use Sophie\Throws\Runnable\Runnable;

/**
 * Facade.
 */
function throws(callable $callable, string ...$types): void
{
    $class =
        count($types) ? SpecificExceptionNet::class : AnyExceptionNet::class;
    (
        new $class(
            new Runnable($callable),
            ...$types
        )
    )->catch();
}
