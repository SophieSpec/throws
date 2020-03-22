<?php

declare(strict_types=1);

namespace Sophie\Throws\ExceptionNet;

use Sophie\Throws\Exception\ShouldHaveThrownException;
use Sophie\Throws\Runnable\RunnableInterface;
use Throwable;

final class AnyExceptionNet implements ExceptionNetInterface
{
    private RunnableInterface $runnable;

    public function __construct(RunnableInterface $runnable)
    {
        $this->runnable = $runnable;
    }

    public function catch(): void
    {
        try {
            $this->runnable->run();
        } catch (Throwable $e) {
            return;
        }
        throw new ShouldHaveThrownException('No exception has been thrown');
    }
}
