<?php

declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
    ->exclude('vendor');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR2' => true,
        '@PSR12:risky' => true,
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'trailing_comma_in_multiline' => ['after_heredoc' => true, 'elements' => []],
        'global_namespace_import' => ['import_classes' => true, 'import_functions' => false],
        'nullable_type_declaration_for_default_null_value' => ['use_nullable_type_declaration' => true],
        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
        'concat_space' => ['spacing' => 'one'],
        'types_spaces' => ['space' => 'single'],
        'native_function_invocation' => [
            'include' => ['@all'],
            'scope' => 'all'
        ],
    ])
    ->setFinder($finder);
