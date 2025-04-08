<?php

use Illuminate\Support\Str;

return [
    'baseUrl' => 'http://localhost:3000',
    'production' => false,
    'siteName' => 'Laravolt',
    'siteDescription' => 'Platform untuk mengembangkan sistem informasi dalam 2 minggu',
    'prettyUrls' => true,
    'versions' => [
        'v4' => '4.x',
        'v5' => '5.x',
        'v6' => '6.x',
    ],
    'defaultVersion' => 'v6',
    'selectedVersion' => function ($page) {
        return explode('/', $page->getPath())[2] ?? $page->defaultVersion;
    },
    'navigation' => require('navigation.php'),

    'isActive' => function ($page, $path) {
        return str_ends_with(trimPath($page->getPath()), trimPath($path));
    },
    'isDocs' => function ($page) {
        return (explode('/', $page->getPath())[1] ?? null) === 'docs';
    },
    'isActiveParent' => function ($page, $menuItem) {
        if (is_object($menuItem) && $menuItem->children) {
            return $menuItem->children->contains(
                function ($child) use ($page) {
                    return trimPath($page->getPath()) === trimPath($child);
                }
            );
        }
    },
    'url' => function ($page, $path) {
        return (Str::startsWith($path, 'http://') || Str::startsWith($path, 'https://')) ? $path : '/'.trimPath($path);
    },
    'isUrl' => function ($page, $path) {
        return Str::startsWith($path, 'http://') || Str::startsWith($path, 'https://');
    },
    'link' => function ($page, $path) {
        return $page->baseUrl.'/docs/'.$page->selectedVersion().'/'.$path.($page->prettyUrls ? '' : '.html');
    },
];
