# NexusPHP CS Config

This library provides a factory for custom rulesets for [`friendsofphp/php-cs-fixer`][1].

[1]: https://github.com/FriendsOfPHP/PHP-CS-Fixer

*This is the drop-in replacement for [Liaison CS Config](https://github.com/paulbalandan/liaison-cs-config).*

## Installation

You can add this library as a local, per-project dependency to your project
using [Composer](https://getcomposer.org/):

    composer require nexusphp/cs-config

If you only need this library during development, for instance to run your project's test suite,
then you should add it as a development-time dependency:

    composer require --dev nexusphp/cs-config

## Configuration

* Create a `.php_cs.dist` at the root of your project:

```php
<?php

use Nexus\CS-Config\Factory;
use Nexus\CS-Config\Ruleset\Nexus73;

return Factory::create(new Nexus73());

```

* Include the cache file in your `.gitignore`. By
default, the cache file will be saved in the project root.

```diff
vendor/

+# php-cs-fixer
+.php_cs
+.php_cs.cache
```
