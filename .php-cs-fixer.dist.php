<?php declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
    ->name('*.php');

$config = new Config();

return $config
    ->setFinder($finder)
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'compact_nullable_type_declaration' => true,
        'concat_space' => ['spacing' => 'one'],
        'declare_strict_types' => true,
        'dir_constant' => true,
        'self_static_accessor' => false,
        'fully_qualified_strict_types' => true,
        'function_to_constant' => true,
        'type_declaration_spaces' => true,
        'header_comment' => false,
        'list_syntax' => ['syntax' => 'short'],
        'lowercase_cast' => true,
        'magic_method_casing' => true,
        'modernize_types_casting' => true,
        'multiline_comment_opening_closing' => true,
        'native_constant_invocation' => true,
        'no_alias_functions' => true,
        'no_alternative_syntax' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_empty_comment' => true,
        'no_empty_phpdoc' => true,
        'no_extra_blank_lines' => true,
        'no_leading_import_slash' => true,
        'no_leading_namespace_whitespace' => true,
        'no_spaces_around_offset' => true,
        'no_superfluous_phpdoc_tags' => ['allow_mixed' => true],
        'no_trailing_comma_in_singleline' => true,
        'no_unneeded_control_parentheses' => true,
        'no_unset_cast' => true,
        'no_unused_imports' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'no_whitespace_in_blank_line' => true,
        'normalize_index_brace' => true,
        'ordered_imports' => true,
        'php_unit_construct' => true,
        'php_unit_dedicate_assert' => ['target' => 'newest'],
        'php_unit_dedicate_assert_internal_type' => ['target' => 'newest'],
        'php_unit_expectation' => ['target' => 'newest'],
        'php_unit_mock' => ['target' => 'newest'],
        'php_unit_mock_short_will_return' => true,
        'php_unit_no_expectation_annotation' => ['target' => 'newest'],
        'php_unit_test_annotation' => ['style' => 'prefix'],
        'php_unit_test_case_static_method_calls' => ['call_type' => 'this'],
        'phpdoc_align' => ['align' => 'vertical'],
        'phpdoc_line_span' => ['method' => 'multi', 'property' => 'multi'],
        'phpdoc_no_package' => true,
        'phpdoc_no_useless_inheritdoc' => true,
        'phpdoc_scalar' => true,
        'phpdoc_separation' => true,
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_trim' => true,
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'phpdoc_types' => true,
        'phpdoc_types_order' => ['null_adjustment' => 'always_last', 'sort_algorithm' => 'none'],
        'phpdoc_var_without_name' => true,
        'return_assignment' => true,
        'short_scalar_cast' => true,
        'single_trait_insert_per_statement' => true,
        'standardize_not_equals' => true,
        'static_lambda' => true,
        'ternary_to_null_coalescing' => true,
        'trim_array_spaces' => true,
        'array_indentation' => true,
        'trailing_comma_in_multiline' => true,
        'visibility_required' => true,
        'yoda_style' => false,
    ]);
