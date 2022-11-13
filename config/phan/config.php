<?php

/**
 * BooKa 13
 *
 * Copyright (c) 2007-2018 - David's Neighbour Part., Ltd.
 * All rights reserved.
 *
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 * Moral rights are preserved. Proprietary and confidential software.
 * Written by Patrick Kollitsch <patrick@davids-neighbour.com>
 *
 * PHP Version 8.1
 *
 * @author     Patrick Kollitsch <patrick@davids-neighbour.com>
 * @copyright  All rights reserved. 2007-2018 - David's Neighbour Part., Ltd.
 * @license    LICENSE.md
 * @package    codequality
 * @since      11.7.123
 * @version    11.9.65
 * @filesource
 */

declare(strict_types=1);

/**
 * This configuration will be read and overlaid on top of the
 * default configuration. Command line arguments will be applied
 * after this file is read.
 *
 * @see https://github.com/phan/phan
 * @see https://github.com/phan/phan/wiki/Phan-Config-Settings
 *
 */
return [
    "target_php_version" => '7.4',
    // A list of directories that should be parsed for class and method
    // information. After excluding the directories defined in
    // exclude_analysis_directory_list, the remaining files will be statically
    // analyzed for errors.
    //
    // Thus, both first-party and third-party code being used by your
    // application should be included in this list.
    'directory_list' => [
        'src/',
        'vendor/',
    ],
    // A directory list that defines files that will be excluded from static
    // analysis, but whose class and method information should be included.
    //
    // Generally, you'll want to include the directories for third-party code
    // (such as "vendor/") in this list.
    //
    // n.b.: If you'd like to parse but not analyze 3rd party code, directories
    //       containing that code should be added to the `directory_list` as to
    //       `exclude_analysis_directory_list`.
    "exclude_analysis_directory_list" => [
        'vendor/',
    ],
    // A regular expression to match files to be excluded from parsing and
    // analysis and will not be read at all.
    //
    // This is useful for excluding groups of test or example directories/files,
    // unanalyzable files, or files that can't be removed for whatever reason.
    // (e.g. '@Test\.php$@', or '@vendor/.*/(tests|Tests)/@')
    //
    'exclude_file_regex' => '@^vendor/.*/(tests|Tests)/@',
    // A list of plugin files to execute.
    // See https://github.com/phan/phan/tree/master/.phan/plugins for even more.
    // (Pass these in as relative paths. Base names without extensions such as
    // 'AlwaysReturnPlugin' can be used to refer to a plugin that is bundled
    // with Phan)
    'plugins' => [
        'AlwaysReturnPlugin',
        'DollarDollarPlugin',
        'DuplicateArrayKeyPlugin',
        'DuplicateExpressionPlugin',
        'HasPHPDocPlugin',
        'InvalidVariableIssetPlugin',
        'InvokePHPNativeSyntaxCheckPlugin',
        'NoAssertPlugin',
        'NonBoolBranchPlugin',
        'NonBoolInLogicalArithPlugin',
        'NotFullyQualifiedUsagePlugin',
        'NumericalComparisonPlugin',
        //'PHPUnitAssertionPlugin',
        //'PHPUnitNotDeadCodePlugin',
        'PregRegexCheckerPlugin',
        'PrintfCheckerPlugin',
        'SleepCheckerPlugin',
        'StrictLiteralComparisonPlugin',
        'SuspiciousParamOrderPlugin',
        'UnknownElementTypePlugin',
        'UnreachableCodePlugin',
        'UnusedSuppressionPlugin',
        'UseReturnValuePlugin',
        'WhitespacePlugin',
    ],
    // This hasn't been optimized yet, and is still experimental, but optimization is planned.
    // Set it to false or omit it.
    'simplify_ast' => false,
    // This is somewhat slow and doesn't work with multiple processes.
    // Set it to false or omit it.
    'dead_code_detection' => false,
    // Backwards Compatibility Checking. This is slow
    // and expensive, but you should consider running
    // it before upgrading your version of PHP to a
    // new version that has backward compatibility
    // breaks. (Also see target_php_version)
    'backward_compatibility_checks' => false,
    // If true, this run a quick version of checks that takes less
    // time at the cost of not running as thorough
    // an analysis. You should consider setting this
    // to true only when you wish you had more **undiagnosed** issues
    // to fix in your code base.
    'quick_mode' => true,
    // If enabled, check all methods that override a
    // parent method to make sure its signature is
    // compatible with the parent's. This check
    // can add quite a bit of time to the analysis.
    'analyze_signature_compatibility' => false,
    // The minimum severity level to report on. This can be
    // set to Issue::SEVERITY_LOW(0), Issue::SEVERITY_NORMAL(5) or
    // Issue::SEVERITY_CRITICAL(10). Setting it to only
    // critical issues is a good place to start on a big
    // sloppy mature code base.
    'minimum_severity' => 10,
    // If true, missing properties will be created when
    // they are first seen. If false, we'll report an
    // error message if there is an attempt to write
    // to a class property that wasn't explicitly
    // defined.
    'allow_missing_properties' => true,
    // Allow null to be cast as any type and for any
    // type to be cast to null. Setting this to false
    // will cut down on false positives.
    'null_casts_as_any_type' => true,
    // Allow null to be cast as any array-like type.
    // This is an incremental step in migrating away from null_casts_as_any_type.
    // If null_casts_as_any_type is true, this has no effect.
    'null_casts_as_array' => false,
    // Allow any array-like type to be cast to null.
    // This is an incremental step in migrating away from null_casts_as_any_type.
    // If null_casts_as_any_type is true, this has no effect.
    'array_casts_as_null' => false,
    // If enabled, scalars (int, float, bool, true, false, string, null)
    // are treated as if they can cast to each other.
    'scalar_implicit_cast' => true,
    // If this has entries, scalars (int, float, bool, true, false, string, null)
    // are allowed to perform the casts listed.
    // E.g. ['int' => ['float', 'string'], 'float' => ['int'], 'string' => ['int'], 'null' => ['string']]
    // allows casting null to a string, but not vice versa.
    // (subset of scalar_implicit_cast)
    'scalar_implicit_partial' => [],
    // If true, seemingly undeclared variables in the global
    // scope will be ignored. This is useful for projects
    // with complicated cross-file globals that you have no
    // hope of fixing.
    'ignore_undeclared_variables_in_global_scope' => true,
    // Added in 0.10.0. Set this to false to emit
    // PhanUndeclaredFunction issues for internal functions
    // that Phan has signatures for,
    // but aren't available in the codebase or the
    // internal functions used to run phan
    'ignore_undeclared_functions_with_known_signatures' => false,
    // Add any issue types (such as 'PhanUndeclaredMethod')
    // to this black-list to inhibit them from being reported.
    'suppress_issue_types' => [
    // 'PhanUndeclaredMethod',
    ],
    // If empty, no filter against issues types will be applied.
    // If this white-list is non-empty, only issues within the list
    // will be emitted by Phan.
    //    'whitelist_issue_types' => [
    //    // 'PhanAccessMethodPrivate',
    //    // 'PhanCompatiblePHP7',  // This only checks for **syntax** where the parsing may have changed. This check is enabled by `backward_compatibility_checks`
    //    // 'PhanDeprecatedFunctionInternal',  // Warns about a small number of functions deprecated in 7.0 and later.
    //    // 'PhanUndeclaredFunction',  // Check for removed functions such as split() that were deprecated in php 5.x and removed in php 7.0.
    //    ],

    'color_issue_messages_if_supported' => true,
    'color_scheme'=> ['FILE' => 'red'],
];
