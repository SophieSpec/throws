# Throws

It is a unit test tool to verify if a callable throws (or not) an exception.

## Install

```sh
composer require --dev sophie-spec/throws
```

Requires PHP >= 7.4.

## Use

Depending on the context, `throws()` and `throws_not()` can throw `ShouldHaveThrownException` or `ShouldHaveNotThrownException`.

```php
$legal_age = function ($age) {
    if ($age < 18) {
        throw new UnderLegalAgeException("Not a legal age");
    }
};

// It does not throw an exception since
// $legal_age throws an exception, as expected.
throws(fn() => $legal_age(5));

// Here, it throws a ShouldHaveThrownException.
throws(fn() => $legal_age(20));

// We can specify what exception we're expecting:
// since we tell to throws() to catch UnderLegalAgeException exceptions
// it won't throw an exception itself.
throws(fn() => $legal_age(5), UnderLegalAgeException::class);

// Of course, we can tell it to catch Exception exceptions,
// and it would catch UnderLegalAgeException as expected.
throws(fn() => $legal_age(5), Exception::class);

// Here, it would throw a ShouldHaveNotThrownException
// because we're catching SomeOtherException and nothing more.
throws(fn() => $legal_age(5), SomeOtherException::class);

// And, of course, you can catch several exception types.
throws(
    fn() => $legal_age(5),
    SomeOtherException::class,
    UnderLegalAgeException::class
);

// Here's the opposite of throws(), in this example
// it throws a ShouldHaveNotThrownException.
throws_not(fn() => $legal_age(5));

// Yay! $legal_age(20) does not throw an exception!
throws_not(fn() => $legal_age(20));

// Like throws(), we can specify some exception classes to not catch.
// Here, $legal_age(5) still throws an exception and since we're just
// verifying that it does not throw an InvalidArgumentException, so
// throws_not() does not throw a ShouldHaveNotThrownException.
throws_not(fn() => $legal_age(5), InvalidArgumentException::class);

// Now, it throws a ShouldHaveNotThrownException.
throws_not(fn() => $legal_age(5), UnderLegalAgeException::class);
```

**Please note, and it's very important, that `throws_not()` can lead to false positives. When you're trying to catch a specific exception, if another exception occurs it will be shut. Then, be sure to know what you're doing when using specific exceptions catching with `throws_not()`!**

## License

[MIT](http://dreamysource.mit-license.org).
