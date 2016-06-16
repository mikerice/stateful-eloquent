# Laravel 5 Eloquent State Machine

If you're familiar with my [AASM](https://github.com/aasm/aasm), then this is a similar take - just implemented in Eloquent for Laravel 5.

L5 includes a bunch of generators out of the box, so this package only needs to add a few things, like:

## Usage

### Step 1: Install Through Composer

```
composer require mikerice/staetful-eloquent
```

### Step 2: Add the Service Provider

```
MikeRice\Stateful\StatefulServiceProvider::class,
```


