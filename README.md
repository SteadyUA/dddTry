### Instructions

- To check the requirements and generate autoload, run
```
$ composer install
```
- Configuration file
```
config.php
```
- To reset the message bus and storage, run
```
$ php bin/reset.php
```
- Message consumer command example
```
$ php bin/fibConsumer.php [--count=] [--sleep=20000]
```
- Message generator command example
```
$ php bin/fibGenerator.php [--count=] [--sleep=20000]
```
