# Variable Values

[![Build Status](https://travis-ci.org/micro-lib/variable-value.svg?branch=master)](https://travis-ci.org/micro-lib/variable-value)

Intention of Variable Values is to provide means for defined way of updating values of variables (for example configuration parameters) in long running processes.

For instance we might want to change connection timeout of our Http Client which is used php worker.
Once worker is started and configuration is read from, let's say some database there is no way of changing it other than restarting worker.
One solution would be to read configuration each time Http Client is trying to make a request. 
Although this is working solution it is not a very efficient one.

What if we get a way to read configuration from source in more smart way, like each n-th variable access or with some TTL value?

Variable Values brings this possibility.

## Installation
```
composer require micro-lib/variable-value
```

## Usage
Please check code samples in ```/examples``` folder.

In order to run examples please:
 - clone repository
 - run ```composer install```
 - run ```php ./examples/datetime.php```
 - run ```php ./examples/readnum.php```
