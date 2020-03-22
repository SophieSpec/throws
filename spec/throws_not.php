<?php

declare(strict_types=1);

namespace Spec\throws_not;

use Exception;
use Sophie\Throws\Exception\ShouldHaveNotThrownException;
use function Sophie\Throws\throws_not;

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

###########################################################################
# Should not throw an exception since the callable does not have
# thrown any exception
###########################################################################

throws_not(
    function () {
    }
);

###########################################################################
# Should throw a ShouldHaveNotThrownException since the callable
# has thrown an exception
###########################################################################

try {
    throws_not(
        function () {
            throw new TestException;
        }
    );
    assert(false);
} catch (ShouldHaveNotThrownException $e) {
}

###########################################################################
# Should not throw an exception since the callable has
# not thrown any handled exception
###########################################################################

throws_not(
    function () {
    },
    TestException::class,
    OtherTestException::class
);

###########################################################################
# Should throw a ShouldHaveNotThrownException since the callable has
# thrown a handled TestException
###########################################################################

try {
    throws_not(
        function () {
            throw new TestException;
        },
        TestException::class,
        OtherTestException::class
    );
    assert(false);
} catch (ShouldHaveNotThrownException $e) {
}

###########################################################################
# Should throw a ShouldHaveNotThrownException since the callable has
# thrown a handled OtherTestException
###########################################################################

try {
    throws_not(
        function () {
            throw new OtherTestException;
        },
        TestException::class,
        OtherTestException::class
    );
    assert(false);
} catch (ShouldHaveNotThrownException $e) {
}

###########################################################################
# Should not throw an exception since the callable has thrown
# an unhandled AnotherTestException
###########################################################################

throws_not(
    function () {
        throw new AnotherTestException;
    },
    TestException::class,
    OtherTestException::class
);

###########################################################################
# Should throw a ShouldHaveNotThrownException since the callable has
# thrown a handled exception's child
###########################################################################

try {
    throws_not(
        function () {
            throw new AnotherTestException;
        },
        Exception::class
    );
    assert(false);
} catch (ShouldHaveNotThrownException $e) {
}
