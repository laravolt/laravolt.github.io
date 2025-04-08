---
title: Form Component
description: Populate form fields from configuration file
extends: _layouts.documentation
section: content
---

# Form Component

###### resources/views/user/create.blade.php
```html
<x-volt-form :schema="config('form.user')" />
```



###### config/form/user.php

```php
<?php
return [        
  [
    'name' => 'name',
    'type' => \Laravolt\Fields\Field::TEXT,
    'label' => 'Nama Lengkap',
  ],
  [
    'name' => 'email',
    'type' => \Laravolt\Fields\Field::TEXT,
    'label' => 'Email',
    'rules' => ['required', 'email'],
  ],
];
```

