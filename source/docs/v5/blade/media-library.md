---
title: Media Library Component
description: Display media library collection in a table
extends: _layouts.documentation
section: content
---

# Media Library

```html
<x-volt-media-library 
	:collection="auth()->user()->getMedia()" 
	:delete="true"
/>
```
