<?php

declare(strict_types=1);

namespace Sophie\Throws\Runnable;

final class Runnable implements RunnableInterface
{
    /**
     * @var callable
     */
    private $callable;

    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    public function run(): void
    {
        call_user_func($this->callable);
    }
}
