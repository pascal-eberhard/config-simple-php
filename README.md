# Simple Config tools

A simplest possible configuration handler. The "do it yourself"-way.

[![Build Status](https://travis-ci.com/pascal-eberhard/config-simple-php.svg?branch=master)](https://travis-ci.com/pascal-eberhard/config-simple-php)

## The problem

I started developing a [config-php](https://github.com/pascal-eberhard/config-php) project. A simple configuration handler, but with some automation. For example, to find the project directory.

But to do so, I needed I/O tools and started an [io-php](https://github.com/pascal-eberhard/io-php) project. For this some config tools would be nice... You see the circular reference?

Therefore let's first create a simplest possible configuration handler.

## Some shell commands

```bash
# All checks
composer checks

# One at a time, see composer.json "scripts"
```
