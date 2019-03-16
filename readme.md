# Laravel Monolog processor tap

**Processor tap** enables you to easily specify Monolog processors which will add information to your log record.

```json
Log::info('Hello world!');

[2019-01-01 12:00:00] local.INFO: Hello world! {"memory_usage":"16 MB","uid":"e44d60c"}
```



## Requirements

Processor tap works with Laravel versions that support the [logging taps](https://laravel.com/docs/5.6/logging#advanced-monolog-channel-customization) (5.6+) .



## Installation



## Usage

Simply add the provided `MonologTap\MonologProcessors` tap to a logging channel. 

To specify the processors, add a comma-separated list of processor names as the tap attribute.

```php
'single' => [
    'driver' => 'single',
    'path' => storage_path('logs/laravel.log'),
    'level' => 'debug',
    'tap' => ['MonologTap\MonologProcessors:uid,memory_usage']
],
```

The processor name is the snake_name of the Monolog's processor class without the processor suffix. (e.g. `uid` refers to the UidProcessor and `memory_usage` to the MemoryUsageProcessor).



### Supported processors

| Processor         | Description                                                  |
| ----------------- | ------------------------------------------------------------ |
| git               | Injects Git branch and Git commit SHA in all records         |
| introspection     | Injects line/file:class/function where the log message came from |
| memory_peak_usage | Injects memory_get_peak_usage in all records                 |
| memory_usage      | Injects memory_get_usage in all records                      |
| mercurial         | Injects Hg branch and Hg revision number in all records      |
| process_id        | Adds value of getmypid into records                          |
| psr_log_message   | Processes a record's message according to PSR-3 rules        |
| uid               | Adds a unique identifier into records                        |
| web               | Injects url/method and remote IP of the current web request in all records |



## Testing

```
phpunit
```



## License

The MIT License (MIT). See the license file for more information.