<?php

$finder = Symfony\CS\Config::create()->getFinder();
$finder->setDir(__DIR__);

$rules = [
    // symfony fixers
    'array_element_no_space_before_comma',
    'array_element_white_space_after_comma',
    'duplicate_semicolon',
    'extra_empty_lines',
    'function_typehint_space',
    'multiline_array_trailing_comma',
    'namespace_no_leading_whitespace',
    'new_with_braces',
    'no_blank_lines_after_class_opening',
    'no_empty_lines_after_phpdocs',
    'phpdoc_no_package',
    'phpdoc_scalar',
    'phpdoc_separation',
    'phpdoc_types',
    'remove_leading_slash_use',
    'remove_lines_between_uses',
    'return',
    'short_bool_cast',
    'single_quote',
    'spaces_before_semicolon',
    'spaces_cast',
    'standardize_not_equal',
    'unalign_double_arrow',
    'unalign_equals',
    'unneeded_control_parentheses',
    'unused_use',
    'whitespacy_lines',
    // contrib fixers
    'concat_with_spaces',
    'multiline_spaces_before_semicolon',
    'no_blank_lines_before_namespace',
    'ordered_use',
    'phpdoc_order',
    'short_array_syntax',
];

$cacheDir = getenv('TRAVIS') ? getenv('HOME') . '/.php-cs-fixer' : __DIR__;

return Symfony\CS\Config::create()
    ->fixers($rules)
    ->finder($finder);
