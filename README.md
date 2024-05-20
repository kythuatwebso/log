# LOG

## Install

```json
composer require friendsofwebso/log
```

## Quick Start

### Case 1

```php
\Webso\Log::make($yourLogPath)->info('Info');
```

### Case 2

```php
// Before add path in file config

\Webso\Log::info('message', ['data' => $something]);

// Log::debug('message', ['data' => $something]);
// Log::info('message', ['data' => $something]);
// Log::notice('message', ['data' => $something]);
// Log::warning('message', ['data' => $something]);
// Log::error('message', ['data' => $something]);
// Log::critical('message', ['data' => $something]);
// Log::alert('message', ['data' => $something]);
// Log::emergency('message', ['data' => $something]);
```
