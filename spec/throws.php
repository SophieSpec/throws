<?php

declare(strict_types=1);

namespace Spec\throws;

use Exception;
use Sophie\Throws\Exception\ShouldHaveNotThrownException;
use Sophie\Throws\Exception\ShouldHaveThrownException;
use function Sophie\Throws\throws;

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
# Should not throw an exception when an exception has been thrown
# from the callable
###########################################################################

throws(
    function () {
        throw new TestException;
    }
);

###########################################################################
# Should throw a ShouldHaveThrownException when no exception has been
# thrown from the callable
###########################################################################

try {
    throws(
        function () {
        }
    );
    assert(false);
} catch (ShouldHaveThrownException $e) {
}

###########################################################################
# Should throw a ShouldHaveThrownException when no handled exception
# has been thrown from the callable
###########################################################################

try {
    throws(
        function () {
        },
        TestException::class,
        OtherTestException::class
    );
    assert(false);
} catch (ShouldHaveThrownException $e) {
}

###########################################################################
# Should not throw an exception when a handled TestException
# has been thrown from the callable
###########################################################################

throws(
    function () {
        throw new TestException;
    },
    TestException::class,
    OtherTestException::class
);

###########################################################################
# Should not throw an exception when a handled OtherTestException has
# been thrown from the callable
###########################################################################

throws(
    function () {
        throw new OtherTestException;
    },
    TestException::class,
    OtherTestException::class
);

###########################################################################
# Should throw a ShouldHaveNotThrownException when an unhandled
# AnotherTestException has been thrown from the callable
###########################################################################

try {
    throws(
        function () {
            throw new AnotherTestException;
        },
        TestException::class,
        OtherTestException::class
    );
    assert(false);
} catch (ShouldHaveNotThrownException $e) {
}

###########################################################################
# Should not throw an exception when a handled exception's child
# has been thrown
###########################################################################

throws(
    function () {
        throw new AnotherTestException;
    },
    Exception::class
);
