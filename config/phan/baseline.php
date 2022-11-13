<?php
/**
 * This is an automatically generated baseline for Phan issues.
 * When Phan is invoked with --load-baseline=path/to/baseline.php,
 * The pre-existing issues listed in this file won't be emitted.
 *
 * This file can be updated by invoking Phan with --save-baseline=path/to/baseline.php
 * (can be combined with --load-baseline)
 */
return [
    // # Issue statistics:
    // PhanUndeclaredMethod : 140+ occurrences
    // PhanUndeclaredStaticProperty : 45+ occurrences
    // PhanPluginNotFullyQualifiedFunctionCall : 25+ occurrences
    // PhanUnreferencedPublicMethod : 25+ occurrences
    // PhanPluginUnknownArrayMethodParamType : 15+ occurrences
    // PhanPluginDescriptionlessCommentOnPublicMethod : 10+ occurrences
    // PhanPluginWhitespaceTab : 10+ occurrences
    // PhanPluginDescriptionlessCommentOnPrivateMethod : 8 occurrences
    // PhanPluginDescriptionlessCommentOnProtectedMethod : 8 occurrences
    // PhanPluginNotFullyQualifiedOptimizableFunctionCall : 8 occurrences
    // PhanUnusedVariableCaughtException : 8 occurrences
    // PhanPluginNoCommentOnPublicMethod : 7 occurrences
    // PhanUndeclaredClassMethod : 7 occurrences
    // PhanPluginNoCommentOnPrivateMethod : 6 occurrences
    // PhanPluginUnknownMethodReturnType : 5 occurrences
    // PhanTypeArraySuspiciousNullable : 5 occurrences
    // PhanDeprecatedFunction : 4 occurrences
    // PhanRedundantArrayValuesCall : 3 occurrences
    // PhanUnreferencedProtectedMethod : 3 occurrences
    // PhanCommentParamOutOfOrder : 2 occurrences
    // PhanPluginDuplicateAdjacentStatement : 2 occurrences
    // PhanPluginUnknownArrayMethodReturnType : 2 occurrences
    // PhanTypeMismatchArgument : 2 occurrences
    // PhanUnextractableAnnotationSuffix : 2 occurrences
    // PhanPluginDescriptionlessCommentOnPrivateProperty : 1 occurrence
    // PhanPluginNoCommentOnClass : 1 occurrence
    // PhanPluginNoCommentOnProtectedMethod : 1 occurrence
    // PhanPluginNumericalComparison : 1 occurrence
    // PhanPluginSuspiciousParamOrderInternal : 1 occurrence
    // PhanPluginUnknownArrayPropertyType : 1 occurrence
    // PhanPluginWhitespaceTrailing : 1 occurrence
    // PhanReadOnlyPrivateProperty : 1 occurrence
    // PhanReadOnlyProtectedProperty : 1 occurrence
    // PhanUnextractableAnnotationElementName : 1 occurrence
    // PhanUnreferencedPrivateMethod : 1 occurrence
    // PhanUnreferencedProtectedProperty : 1 occurrence
    // PhanUnreferencedUseFunction : 1 occurrence

    // Currently, file_suppressions and directory_suppressions are the only supported suppressions
    'file_suppressions' => [
        'src/RoboFile.php' => ['PhanCommentParamOutOfOrder', 'PhanDeprecatedFunction', 'PhanPluginDescriptionlessCommentOnProtectedMethod', 'PhanPluginNoCommentOnPublicMethod', 'PhanPluginNotFullyQualifiedFunctionCall', 'PhanPluginNotFullyQualifiedOptimizableFunctionCall', 'PhanPluginUnknownArrayMethodParamType', 'PhanPluginUnknownArrayPropertyType', 'PhanPluginWhitespaceTab', 'PhanPluginWhitespaceTrailing', 'PhanReadOnlyProtectedProperty', 'PhanTypeArraySuspiciousNullable', 'PhanUnextractableAnnotationSuffix', 'PhanUnreferencedProtectedMethod', 'PhanUnreferencedProtectedProperty', 'PhanUnreferencedPublicMethod', 'PhanUnreferencedUseFunction', 'PhanUnusedVariableCaughtException'],
        'src/Traits/Build.php' => ['PhanPluginDescriptionlessCommentOnPrivateMethod', 'PhanPluginDescriptionlessCommentOnPrivateProperty', 'PhanPluginDescriptionlessCommentOnPublicMethod', 'PhanPluginWhitespaceTab', 'PhanReadOnlyPrivateProperty', 'PhanUndeclaredMethod', 'PhanUnreferencedPublicMethod'],
        'src/Traits/Clean.php' => ['PhanPluginDescriptionlessCommentOnPrivateMethod', 'PhanPluginDescriptionlessCommentOnPublicMethod', 'PhanPluginNoCommentOnPrivateMethod', 'PhanPluginNotFullyQualifiedFunctionCall', 'PhanPluginUnknownArrayMethodParamType', 'PhanPluginWhitespaceTab', 'PhanTypeMismatchArgument', 'PhanUndeclaredClassMethod', 'PhanUndeclaredMethod', 'PhanUndeclaredStaticProperty', 'PhanUnreferencedPublicMethod', 'PhanUnusedVariableCaughtException'],
        'src/Traits/Database.php' => ['PhanDeprecatedFunction', 'PhanPluginNoCommentOnPrivateMethod', 'PhanPluginNotFullyQualifiedFunctionCall', 'PhanPluginNotFullyQualifiedOptimizableFunctionCall', 'PhanPluginUnknownArrayMethodParamType', 'PhanPluginUnknownMethodReturnType', 'PhanPluginWhitespaceTab', 'PhanRedundantArrayValuesCall', 'PhanUndeclaredMethod', 'PhanUndeclaredStaticProperty', 'PhanUnreferencedPublicMethod', 'PhanUnusedVariableCaughtException'],
        'src/Traits/Development.php' => ['PhanPluginDescriptionlessCommentOnPublicMethod', 'PhanPluginNoCommentOnPublicMethod', 'PhanPluginUnknownMethodReturnType', 'PhanPluginWhitespaceTab', 'PhanUndeclaredMethod', 'PhanUnreferencedPublicMethod'],
        'src/Traits/Documentation.php' => ['PhanPluginNoCommentOnPublicMethod', 'PhanPluginUnknownMethodReturnType', 'PhanPluginWhitespaceTab', 'PhanUndeclaredMethod', 'PhanUndeclaredStaticProperty', 'PhanUnreferencedPublicMethod'],
        'src/Traits/Env.php' => ['PhanPluginNotFullyQualifiedFunctionCall', 'PhanPluginWhitespaceTab', 'PhanUndeclaredMethod', 'PhanUndeclaredStaticProperty', 'PhanUnreferencedPublicMethod'],
        'src/Traits/Maintenance.php' => ['PhanPluginDescriptionlessCommentOnPrivateMethod', 'PhanPluginDescriptionlessCommentOnPublicMethod', 'PhanPluginDuplicateAdjacentStatement', 'PhanPluginNoCommentOnClass', 'PhanPluginNotFullyQualifiedFunctionCall', 'PhanPluginNotFullyQualifiedOptimizableFunctionCall', 'PhanPluginNumericalComparison', 'PhanPluginUnknownArrayMethodParamType', 'PhanPluginWhitespaceTab', 'PhanUndeclaredClassMethod', 'PhanUndeclaredMethod', 'PhanUndeclaredStaticProperty', 'PhanUnextractableAnnotationElementName', 'PhanUnextractableAnnotationSuffix', 'PhanUnreferencedPublicMethod'],
        'src/Traits/QualityInsurance.php' => ['PhanPluginDescriptionlessCommentOnPrivateMethod', 'PhanPluginDescriptionlessCommentOnPublicMethod', 'PhanPluginNoCommentOnPublicMethod', 'PhanPluginWhitespaceTab', 'PhanUndeclaredMethod', 'PhanUnreferencedPublicMethod'],
        'src/Traits/Release.php' => ['PhanPluginDescriptionlessCommentOnPrivateMethod', 'PhanPluginDescriptionlessCommentOnProtectedMethod', 'PhanPluginNoCommentOnPrivateMethod', 'PhanPluginNoCommentOnProtectedMethod', 'PhanPluginNotFullyQualifiedFunctionCall', 'PhanPluginNotFullyQualifiedOptimizableFunctionCall', 'PhanPluginSuspiciousParamOrderInternal', 'PhanPluginUnknownArrayMethodParamType', 'PhanPluginUnknownArrayMethodReturnType', 'PhanPluginWhitespaceTab', 'PhanTypeMismatchArgument', 'PhanUndeclaredClassMethod', 'PhanUndeclaredMethod', 'PhanUndeclaredStaticProperty', 'PhanUnreferencedPrivateMethod', 'PhanUnreferencedPublicMethod', 'PhanUnusedVariableCaughtException'],
        'src/Traits/Setup.php' => ['PhanPluginWhitespaceTab', 'PhanUndeclaredMethod', 'PhanUndeclaredStaticProperty', 'PhanUnreferencedPublicMethod', 'PhanUnusedVariableCaughtException'],
        'src/Traits/Stage.php' => ['PhanPluginDescriptionlessCommentOnPrivateMethod', 'PhanPluginNoCommentOnPublicMethod', 'PhanPluginNotFullyQualifiedFunctionCall', 'PhanPluginNotFullyQualifiedOptimizableFunctionCall', 'PhanPluginUnknownMethodReturnType', 'PhanPluginWhitespaceTab', 'PhanRedundantArrayValuesCall', 'PhanUndeclaredMethod', 'PhanUndeclaredStaticProperty', 'PhanUnreferencedPublicMethod'],
        'src/Traits/Testing.php' => ['PhanPluginDescriptionlessCommentOnPublicMethod', 'PhanPluginNoCommentOnPublicMethod', 'PhanPluginWhitespaceTab', 'PhanUndeclaredMethod', 'PhanUnreferencedPublicMethod'],
        'src/Traits/Wordpress.php' => ['PhanPluginDescriptionlessCommentOnPublicMethod', 'PhanPluginWhitespaceTab', 'PhanUndeclaredMethod', 'PhanUndeclaredStaticProperty', 'PhanUnreferencedPublicMethod'],
    ],
    // 'directory_suppressions' => ['src/directory_name' => ['PhanIssueName1', 'PhanIssueName2']] can be manually added if needed.
    // (directory_suppressions will currently be ignored by subsequent calls to --save-baseline, but may be preserved in future Phan releases)
];
