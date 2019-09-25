#!/usr/bin/env sh
# Shell: (sh checkSyntax.sh)

# First simple syntax checks
binPHP=$(which php)
errorCount=0
rm -f temp-syntax-test-files.txt
find $(pwd) -iname "*.php" -type f -print | grep -Eiv "(var|vendor)/" | sort > temp-syntax-test-files.txt
for line in `cat temp-syntax-test-files.txt`
do
  count=$($binPHP -l $line | grep -iv "no syntax errors" | wc -l)
  errorCount=$(( $count + $errorCount ))
done

rm -f temp-syntax-test-files.txt
if [ $errorCount -gt 0 ]
then
  exit 1;
fi
exit 0;
