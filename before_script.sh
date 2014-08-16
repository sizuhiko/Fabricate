#!/bin/bash

if [ "$PHPCS" = '1' ]; then
	pear install PHP_CodeSniffer	
	git clone -b master https://github.com/cakephp/cakephp-codesniffer.git ../cakephp-codesniffer
	phpcs --config-set installed_paths ../cakephp-codesniffer
	exit 0
fi