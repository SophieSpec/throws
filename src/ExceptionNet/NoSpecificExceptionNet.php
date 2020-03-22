<?php

declare(strict_types=1);

namespace Sophie\Throws\ExceptionNet;

use Sophie\Throws\Exception\ShouldHaveNotThrownException;
use Sophie\Throws\Runnable\RunnableInterface;
use Throwable;

final class NoSpecificExceptionNet implements ExceptionNetInterface
{
    private RunnableInterface $runnable;
    private array $types;

    public function __construct(RunnableInterface $runnable, string ...$types)
    {
        $this->runnable = $runnable;
        $this->types = $types;
    }

    public function catch(): void
    {
        try {
            $this->runnable->run();
        } catch (Throwable $e) {
            /** @psalm-suppress MixedAssignment */
            foreach ($this->types as $type) {
                if ($e instanceof $type) {
                    $classname = get_class($e);
                    throw new ShouldHaveNotThrownException(
                        "Should have not thrown a '$classname' exception",
                        0,
                        $e
                    );
                }
            }
            return;
        }
    }
}
