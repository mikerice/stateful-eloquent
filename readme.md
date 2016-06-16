# Laravel 5 Eloquent State Machine

If you're familiar with my [AASM](https://github.com/aasm/aasm), then this is a similar take – just implemented in Laravel 5 for Eloquent classes.

## Installation

### Step 1: Install Through Composer

```
composer require mikerice/stateful-eloquent
```

### Step 2: Add the Service Provider

```php
MikeRice\Stateful\StatefulServiceProvider::class,
```

### Step 3: Update your Eloquent Model

Your models should use the Stateful trait and interface

```php
use MikeRice\Stateful\StatefulTrait;
use MikeRice\Stateful\StatefulInterface;

class Transaction extends Model implements StatefulInterface
{
    use StatefulTrait;
}
```

### Step 4: Create your Model States

Your models should have an array name `$states` that define your model states.

```php
/**
 * Transaction States
 *
 * @var array
 */
protected $states = [
    'draft' => ['inital' => true],
    'processing',
    'errored',
    'active',
    'closed' => ['final' => true]
];
```

### Step 5: Create your Model State Transitions

```php
/**
 * Transaction State Transitions
 *
 * @var array
 */
protected $transitions = [
    'process' => [
        'from' => ['draft', 'errored'],
        'to' => 'processing'
    ],
    'activate' => [
        'from' => 'processing',
        'to' => 'active'
    ],
    'fail' => [
        'from' => 'processing',
        'to' => 'errored'
    ],
    'close' => [
        'from' => 'active',
        'to' => 'close'
    ]
];
```

## Usage

```php
$transaction = new Transaction();

$transaction->process();

$transaction->isProcessing();
```
