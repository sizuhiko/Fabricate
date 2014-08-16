#!/bin/bash

if [ "$PHPCS" = '2' ]; then
	pear install PHP_CodeSniffer	
	git clone -b master https://github.com/cakephp/cakephp-codesniffer.git ../cakephp-codesniffer
	phpcs --config-set installed_paths ../cakephp-codesniffer
	export PHPCS=1
	exit 0
fi