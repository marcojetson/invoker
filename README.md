Invoker
=======

Invoke PHP callables using associative arrays

Usage
-----

Use _invoke_ providing a callable and the arguments as an associative array

```php
<?php

function person($name, $age)
{
}

$invoker = new Invoker();
$invoker->invoke('person', ['age' => 29, 'name' => 'Marco']);
```

Supports optional arguments

```php
<?php

function person($name, $age = 29)
{
}

$invoker = new Invoker();
$invoker->invoke('person', ['name' => 'Marco']);
```

Callables
---------

In addition to PHP callables you can use the following forms as first argument:

- A class name implementing the ___invoke_ magic method
- A string containing _class::method_

You can implement Resolver interface and inject it into _Invoker_'s constructor for adding your own forms

```php
$invoker = new Invoker(new MyResolver());
```