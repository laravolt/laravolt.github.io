---
title: Action Button
description: Page level actions
extends: _layouts.documentation
section: content
---

# Action Button

```html
<x-volt-app title="Posts">
    <x-slot name="actions">
        <x-volt-link-button
            url="{{ route('posts.create') }}"
            icon="plus"
            label="New Post"
        />
    </x-slot>
</x-volt-app>
```
