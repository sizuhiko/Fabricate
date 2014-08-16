#!/bin/bash

if [ "$PHPCS" = '2' ]; then
	pear install PHP_CodeSniffer	
	phpenv rehash
	exit 0
fi