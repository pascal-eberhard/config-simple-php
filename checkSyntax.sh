#!/usr/bin/env sh
# Shell: (sh checkSyntax.sh | grep -iv "no syntax errors")

# First simple syntax checks
binPHP=$(which php)
rm -f temp-syntax-test-files.txt
find * -iname "*.php" -type f -print | grep -Eiv "(var|vendor)/" | sort > temp-syntax-test-files.txt
for line in `cat temp-syntax-test-files.txt`
do
  $binPHP -l $line
done

rm -f temp-syntax-test-files.txt
