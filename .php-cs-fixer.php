<?php

use PhpCsFixer\Config;

return (new Config())
	->setRules([
		'@Symfony'                          => true,
		'@PSR2'                             => true,
		'no_useless_return'                 => true,
		'ternary_to_null_coalescing'        => true,
		'single_trait_insert_per_statement' => false,
		'binary_operator_spaces'            => [
			'operators' => [
				'='  => 'single_space',
				'=>' => 'align',
			],
		],
		'array_syntax'                      => ['syntax' => 'short'],
		'not_operator_with_successor_space' => true,
		'ordered_imports'                   => ['sort_algorithm' => 'length'],
		'phpdoc_var_without_name'           => false,
		'blank_line_after_namespace'        => true,
		'method_argument_space'             => [
			'on_multiline'                     => 'ensure_single_line', // Change to 'ensure_single_line'
			'keep_multiple_spaces_after_comma' => false,
		],
	])
	->setIndent("\t")
	->setLineEnding("\n");
