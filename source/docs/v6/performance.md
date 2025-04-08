---
title: Performance
description: Boost performance by following this guideline
extends: _layouts.documentation
section: content
---

# Performance
Ada beberapa hal yang penting dilakukan agar performa aplikasi tetap baik.

## Laravel Built In Optimizer
```php
php artisan optimize
//php artisan optimize:clear
```

## Disable APP_DEBUG

###### .env
```dotenv
APP_DEBUG=false
```

## Cache Blade Iconset
```php
php artisan icon:cache
// php artisan icon:clear
```

## Cache Eloquent User Provider
###### config/auth.php
```php
'providers' => [
    'users' => [
        // default value
        //'driver' => 'eloquent',
        
        // change to this to reduce 1 query for each request
        'driver' => 'eloquent-cached',
        
        'model' => App\Models\User::class,
    ],
],
```
