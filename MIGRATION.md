# Migrating from Liaison CS Config Factory

The following were the changes implemented in considering the transition to NexusPHP CS Config:

## Added

- Public methods `forProjects` and `forLibrary` were added to `Factory` class.
- `forProjects` accepts no arguments and acts as the old `Factory::create`.
- `forLibrary` accepts two required and two optional arguments and behaves as the old `Factory::createForLibrary`.
- The `Nexus73` ruleset is added and meant for use in PHP 7.3+.
- `declare(strict_types=1)` was added to all PHP files for additional type safety.

## Changed

- Root namespace of `Liaison\CS\Config` was renamed to `Nexus\CsConfig`.
- `Factory::create` now returns an instance of `Factory` instead of `PhpCsFixer\Config`. This allows it
to be chained with either `forProjects` or `forLibrary` public methods.

## Removed

- `Factory::createForLibrary` was removed. Use the public method `forLibrary` to get similar effect.
- The `Liaison` and `CodeIgniter4` rulesets were removed.
- The deprecated `BaseRuleset` class was removed.
- Custom fixers were removed and moved to a new repository, [NexusPHP CS Fixers][1].

[1]: https://github.com/NexusPHP/cs-fixers

Please have a look at this library's [`.php_cs.dist`](.php_cs.dist) to have a glance of the new changes
in action. You can also refer to the [README](README.md) for additional details.
