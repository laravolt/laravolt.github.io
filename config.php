<?php

return [
    'baseUrl' => '',
    'production' => false,
    'siteName' => 'Laravolt',
    'siteDescription' => 'Platform untuk mengembangkan sistem informasi dalam 2 minggu',

    // collections
    'collections' => ['docs', 'guidelines', 'snippets', 'studi-kasus'],

    // navigation menu
    'navigation' => require_once('navigation.php'),

    // helpers
    'isActive' => function ($page, $path) {
        return ends_with(trimPath($page->getPath()), trimPath($path));
    },
    'isActiveParent' => function ($page, $menuItem) {
        if (is_object($menuItem) && $menuItem->children) {
            return $menuItem->children->contains(function ($child) use ($page) {
                return trimPath($page->getPath()) == trimPath($child);
            });
        }
    },
    'url' => function ($page, $path) {
        return starts_with($path, 'http') ? $path : '/' . trimPath($path);
    },
];
