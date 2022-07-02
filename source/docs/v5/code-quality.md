---
title: Code Quality
description: Bad code never survive
extends: _layouts.documentation
section: content
---

# Code Quality

## Prolog

Bagaimana jika bug bisa terdeteksi tanpa harus menge-*run* program? Bagaimana jika bug bisa terdeteksi secara otomatis, tanpa harus melakukan *code review*?

![image-20201130074809347](../assets/uploads/larastan-restul.png)

Pesan di atas adalah contoh hasil *static code analysis* dengan **Larastan** terhadap kode yang sudah lolos *code review*. Larastan 1, code reviewer 0.

Kemampuan dan energi *code reviewer* (manusia) ada batasnya. Hal ini yang kadang menyebabkan kode yang buruk masih bisa lolos reviu dan naik ke *production*. Untuk itulah peran *tools* seperti Larastan menjadi sangat penting untuk menjaga kualitas kode. Selain karena bukan manusia (jadi tidak ada kata lelah), melakukan reviu kode dengan menggunakan *tools* juga lebih obyektif karena ada seperangkat *rules* yang terdefinisi dan telah disepakati sebelumnya.

Code reviewer bisa fokus mengurusi hal-hal penting lainnya, seperti:

1. Penamaan
2. Algoritma
3. Arsitektur *Class*
4. Dan hal-hal lain yang butuh *wisdom*.



## Code Style: Pint

### Tujuan

Memastikan cara penulisan kode seragam antar programmer meskipun menggunakan IDE/editor yang berbeda.

### Tools

https://github.com/laravel/pint

### Instalasi

```bash
composer require laravel/pint --dev
```

### Pemakaian

> 🌟 Jalankan perintah-perintah berikut ini dari folder aplikasi.

Melakukan *fixing* otomatis:

```bash
vendor/bin/pint
```

Melakukan pengecekan saja tanpa *fixing*, tambahkan opsi `--dry-run`:

```bash
vendor/bin/pint --test
```

Jika command-nya terlalu panjang untuk diingat, tambahkan shortcut/alias ke composer.json:

```json
"scripts": {
    "pint": [
        "vendor/bin/pint"
    ]
}
```

Selanjutnya, kita cukup memanggil alias yang sudah didefinisikan di atas:

```bash
composer pint
```

### Customize Config

###### pint.json

```json
{
    "preset": "psr12",
    "rules": {
        "simplified_null_return": true,
        "braces": false,
        "new_with_braces": {
            "anonymous_class": false,
            "named_class": false
        }
    }
}
```



## Code Style: PHP-CS-Fixer

### Tujuan

Dikarenakan **Pint** mengharuskan spesifikasi khusus minimal PHP 8.0, apabila ada *project* yang masih perlu menggunakan **PHP-CS-Fixer** karena masalah *compatibility* (masih menggunakan < PHP 8.0), kita bisa membuat konfigurasi **PHP-CS-Fixer** yang sejalan dengan **Pint**.

### Tools

https://github.com/FriendsOfPHP/PHP-CS-Fixer

### Instalasi

```bash
composer require friendsofphp/php-cs-fixer --dev
```

### Pemakaian

> 🌟 Jalankan perintah-perintah berikut ini dari folder aplikasi.

Melakukan *fixing* otomatis:

```bash
vendor/bin/php-cs-fixer fix --diff
```

Melakukan pengecekan saja tanpa *fixing*, tambahkan opsi `--dry-run`:

```bash
vendor/bin/php-cs-fixer fix --dry-run --diff
```

Jika command-nya terlalu panjang untuk diingat, tambahkan shortcut/alias ke composer.json:

```json
"scripts": {
    "cs-check": [
        "vendor/bin/php-cs-fixer fix --dry-run --diff"
    ],
    "cs-fix": [
        "vendor/bin/php-cs-fixer fix --diff"
    ]
}
```

Selanjutnya, kita cukup memanggil alias yang sudah didefinisikan di atas:

```bash
composer cs-check
composer cs-fix
```

### Customize Config

###### .php-cs-fixer.php

```php
<?php

$rules = [
    'array_indentation' => true,
    'array_syntax' => ['syntax' => 'short'],
    'binary_operator_spaces' => [
        'default' => 'single_space',
        'operators' => ['=>' => null],
    ],
    'blank_line_after_namespace' => true,
    'blank_line_after_opening_tag' => true,
    'blank_line_before_statement' => [
        'statements' => ['return'],
    ],
    'braces' => true,
    'cast_spaces' => true,
    'class_attributes_separation' => [
        'elements' => [
            'const' => 'one',
            'method' => 'one',
            'property' => 'one',
            'trait_import' => 'none',
        ],
    ],
    'class_definition' => [
        'multi_line_extends_each_single_line' => true,
        'single_item_single_line' => true,
        'single_line' => true,
    ],
    'clean_namespace' => true,
    'compact_nullable_typehint' => true,
    'concat_space' => [
        'spacing' => 'none',
    ],
    'constant_case' => ['case' => 'lower'],
    'declare_equal_normalize' => true,
    'elseif' => true,
    'encoding' => true,
    'full_opening_tag' => true,
    'fully_qualified_strict_types' => true,
    'function_declaration' => true,
    'function_typehint_space' => true,
    'general_phpdoc_tag_rename' => true,
    'heredoc_to_nowdoc' => true,
    'include' => true,
    'increment_style' => ['style' => 'post'],
    'indentation_type' => true,
    'integer_literal_case' => true,
    'lambda_not_used_import' => true,
    'linebreak_after_opening_tag' => true,
    'line_ending' => true,
    'lowercase_cast' => true,
    'lowercase_keywords' => true,
    'lowercase_static_reference' => true,
    'magic_method_casing' => true,
    'magic_constant_casing' => true,
    'method_argument_space' => [
        'on_multiline' => 'ignore',
    ],
    'multiline_whitespace_before_semicolons' => [
        'strategy' => 'no_multi_line',
    ],
    'native_function_casing' => true,
    'native_function_type_declaration_casing' => true,
    'no_alias_functions' => true,
    'no_extra_blank_lines' => [
        'tokens' => [
            'extra',
            'throw',
            'use',
        ],
    ],
    'no_alias_language_construct_call' => true,
    'no_alternative_syntax' => true,
    'no_binary_string' => true,
    'no_blank_lines_after_class_opening' => true,
    'no_blank_lines_after_phpdoc' => true,
    'no_closing_tag' => true,
    'no_empty_phpdoc' => true,
    'no_empty_statement' => true,
    'no_leading_import_slash' => true,
    'no_leading_namespace_whitespace' => true,
    'no_mixed_echo_print' => [
        'use' => 'echo',
    ],
    'no_multiline_whitespace_around_double_arrow' => true,
    'no_short_bool_cast' => true,
    'no_singleline_whitespace_before_semicolons' => true,
    'no_spaces_after_function_name' => true,
    'no_space_around_double_colon' => true,
    'no_spaces_around_offset' => [
        'positions' => ['inside', 'outside'],
    ],
    'no_spaces_inside_parenthesis' => true,
    'no_trailing_comma_in_list_call' => true,
    'no_trailing_comma_in_singleline_array' => true,
    'no_trailing_whitespace' => true,
    'no_trailing_whitespace_in_comment' => true,
    'no_unneeded_control_parentheses' => [
        'statements' => ['break', 'clone', 'continue', 'echo_print', 'return', 'switch_case', 'yield'],
    ],
    'no_unneeded_curly_braces' => true,
    'no_unset_cast' => true,
    'no_unreachable_default_argument_value' => true,
    'no_useless_return' => true,
    'no_whitespace_before_comma_in_array' => true,
    'no_whitespace_in_blank_line' => true,
    'no_unused_imports' => true,
    'normalize_index_brace' => true,
    'not_operator_with_successor_space' => true,
    'object_operator_without_whitespace' => true,
    'ordered_imports' => ['sort_algorithm' => 'alpha'],
    'psr_autoloading' => false,
    'phpdoc_indent' => true,
    'phpdoc_inline_tag_normalizer' => true,
    'phpdoc_no_access' => true,
    'phpdoc_no_package' => true,
    'phpdoc_no_useless_inheritdoc' => true,
    'phpdoc_scalar' => true,
    'phpdoc_single_line_var_spacing' => true,
    'phpdoc_summary' => false,
    'phpdoc_to_comment' => false,
    'phpdoc_tag_type' => true,
    'phpdoc_trim' => true,
    'phpdoc_types' => true,
    'phpdoc_var_without_name' => true,
    'return_type_declaration' => [
        'space_before' => 'none',
    ],
    'self_accessor' => true,
    'short_scalar_cast' => true,
    'simplified_null_return' => false,
    'single_blank_line_at_eof' => true,
    'single_blank_line_before_namespace' => true,
    'single_class_element_per_statement' => [
        'elements' => ['const', 'property'],
    ],
    'single_import_per_statement' => true,
    'single_line_after_imports' => true,
    'single_line_comment_style' => [
        'comment_types' => ['hash'],
    ],
    'single_quote' => true,
    'space_after_semicolon' => true,
    'standardize_not_equals' => true,
    'switch_case_semicolon_to_colon' => true,
    'switch_case_space' => true,
    'ternary_operator_spaces' => true,
    'trailing_comma_in_multiline' => ['elements' => ['arrays']],
    'trim_array_spaces' => true,
    'unary_operator_spaces' => true,
    'visibility_required' => [
        'elements' => ['method', 'property'],
    ],
    'whitespace_after_comma_in_array' => true,
    'Laravel/laravel_phpdoc_alignment' => true,
    'Laravel/laravel_phpdoc_order' => true,
    'Laravel/laravel_phpdoc_separation' => true,
];

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__.'/app',
        __DIR__.'/config',
        __DIR__.'/database',
        __DIR__.'/modules',
        __DIR__.'/resources',
        __DIR__.'/routes',
        __DIR__.'/tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new PhpCsFixer\Config())
    ->setFinder($finder)
    ->setRules($rules)
    ->setRiskyAllowed(true)
    ->setUsingCache(true)
    ->registerCustomFixers([
        // Laravel...
        new \Laravolt\Pint\Fixers\LaravelPhpdocOrderFixer(),
        new \Laravolt\Pint\Fixers\LaravelPhpdocOrderFixer(),
        new \Laravolt\Pint\Fixers\LaravelPhpdocOrderFixer(),
    ]);
```



## Static Analysis

### Tujuan

Menemukan bug sebelum bug menemukan kita.

### Tools

- https://phpstan.org/
- https://github.com/nunomaduro/larastan

### Instalasi

```bash
composer require nunomaduro/larastan --dev
composer require spaze/phpstan-disallowed-calls --dev 
```

### Konfigurasi

###### phpstan.neon

```yaml
includes:
  - ./vendor/nunomaduro/larastan/extension.neon
  - ./vendor/spaze/phpstan-disallowed-calls/extension.neon

parameters:
  paths:
    - app
    - config

  # The level 9 is the highest level
  level: 8

  disallowedFunctionCalls:
    - function: 'env()'
      message: 'use config() instead'
      allowIn:
        - config/*.php
```

### Pemakaian

```bash
vendor/bin/phpstan analyse
```



## Cognitive Complexity

### Tujuan

Memastikan kode mudah dibaca dan di-*maintain* untuk jangka waktu yang panjang.

### Tools

https://www.sonarlint.org/

### Instalasi

- https://blog.javan.co.id/meningkatkan-code-quality-dengan-plugin-sonarlint-di-intellij-idea-36705b6cd8fa
- https://blog.javan.co.id/cara-mudah-meningkatkan-kualitas-kode-menggunakan-sonar-37c6f8e0239b



## GrumPHP

### Tujuan

Menjalankan semua tools di atas setiap kali kita melakukan perubahan kode bisa jadi menyita cukup waktu dan berpotensi lupa. Oleh sebab itu, Laravolt sudah dilengkapi dengan GrumpPHP (https://github.com/phpro/grumphp) yang akan melakukan pengecekan secara otomatis setiak kali kita melakukan commit. Jika ada satu saja pengecekan yang gagal, maka commit tidak bisa dilakukan dan kita harus memperbaiki kode terlebih dahulu.

### Instalasi

```bash
composer require phpro/grumphp --dev
```

### Konfigurasi

###### grumphp.yml

```yaml
grumphp:
    tasks:
        phpcsfixer:
            config: .php-cs-fixer.php
        phpstan:
            configuration: phpstan.neon
            use_grumphp_paths: false
```

### Pemakaian

#### Pengecekan Manual

```bash
vendor/bin/grumphp run
```

#### Otomatis

```bash
vendor/bin/grumphp git:init
```

Setelah kode di atas dijalankan, maka GrumPHP akan dijalankan secara otomatis sebelum commit.
