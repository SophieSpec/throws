<?php

declare(strict_types=1);

namespace Sophie\Throws\ExceptionNet;

use Sophie\Throws\Exception\ShouldHaveNotThrownException;
use Sophie\Throws\Runnable\RunnableInterface;
use Throwable;

final class NoExceptionNet implements ExceptionNetInterface
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
            $classname = get_class($e);
            $message = $e->getMessage();
            throw new ShouldHaveNotThrownException(
                "'$classname' exception has been thrown with message '$message'",
                0,
                $e
            );
        }
    }
}
