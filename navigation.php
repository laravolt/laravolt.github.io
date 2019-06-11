<?php

return [
    'Introduction'         => 'docs/introduction',
    'Installation'         => 'docs/installation',
    'Building Application' => 'docs/building-application',
    'Customizing The UI'   => 'docs/customizing-the-ui',
    'Guideline'            => [
        'url'      => 'docs/guidelines',
        'children' => [
            'Coding Standard' => 'docs/guidelines/coding-standard',
            'Git'             => 'docs/guidelines/git',
            'Model'           => 'docs/guidelines/model',
            'View'            => 'docs/guidelines/view',
            'Controller'      => 'docs/guidelines/controller',
        ],
    ],
    'Deployment'           => 'docs/deployment',
    'Troubleshooting'      => 'docs/troubleshooting',
    'Snippets'             => [
        'url'      => 'docs/snippets',
        'children' => [
            'Membuat Helper' => 'docs/snippets/membuat-helper',
        ],
    ],
    'Packages Documentation' => [
        'url'      => 'docs/packages',
        'children' => [
            // 'ACL'           => 'docs/acl',
            // 'Auth'          => 'docs/auth',
            // 'Avatar'        => 'docs/avatar',
            // 'Indonesia'     => 'docs/indonesia',
            // 'Password'      => 'docs/password',
            // 'Semantic Form' => 'docs/semantic-form',
            // 'Setting'       => 'docs/setting',
            // 'Suitable'      => 'docs/suitable',
            'Thunderclap'   => 'docs/packages/thunderclap',
        ],
    ],
];
