# Simple Config tools

A simplest possible configuration handler. The do it yourself way.

## The problem

I started developing a [config-php](https://github.com/pascal-eberhard/config-php) project. A simple configuration handler, but with some automation. For example, to find the project directory.

But to do so, I needed I/O tools and started an [io-php](https://github.com/pascal-eberhard/io-php) project. For this some config tools would be nice... You see the circular reference?

Therefore let's first create a simplest possible configuration handler.

## Some shell commands

```bash
# Check syntax (A bit weird commands in the .sh file, because currently running at windows)
sh checkSyntax.sh | grep -iv "no syntax errors"

# Unit tests
vendor/bin/phpunit -vv

# Code sniff/automatic corrections
vendor/bin/phpcbf --standard=PSR2 resources src

# Code sniff/checks
vendor/bin/phpcs --standard=PSR2 resources src
```
