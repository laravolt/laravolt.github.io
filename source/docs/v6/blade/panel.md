---
title: Panel Component
description: A panel is used to create a grouping of related content 
extends: _layouts.documentation
section: content
---

# Panel

### Basic Panel

```html
<x-volt-panel title="Title">

  Panel content goes here
    
</x-volt-panel>
```



### Full Featured Panel

```html
<x-volt-panel
	title="Title"
  description="Optional description"
  icon="umbrella"
>

  
  <x-slot name="action">
    <x-volt-link-button icon="plus" url="#">New</x-volt-link-button>
  </x-slot>
    
  Panel content goes here
  
  <x-slot name="footer">
    Optional footer
  </x-slot>  
  
</x-volt-panel>
```
