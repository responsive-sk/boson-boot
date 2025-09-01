<?php declare(strict_types = 1);

return [
	'lastFullAnalysisTime' => 1756744071,
	'meta' => array (
  'cacheVersion' => 'v12-linesToIgnore',
  'phpstanVersion' => '1.12.28',
  'phpVersion' => 80411,
  'projectConfig' => '{conditionalTags: {PHPStan\\Rules\\DisallowedConstructs\\DisallowedLooseComparisonRule: {phpstan.rules.rule: %strictRules.disallowedLooseComparison%}, PHPStan\\Rules\\BooleansInConditions\\BooleanInBooleanAndRule: {phpstan.rules.rule: %strictRules.booleansInConditions%}, PHPStan\\Rules\\BooleansInConditions\\BooleanInBooleanNotRule: {phpstan.rules.rule: %strictRules.booleansInConditions%}, PHPStan\\Rules\\BooleansInConditions\\BooleanInBooleanOrRule: {phpstan.rules.rule: %strictRules.booleansInConditions%}, PHPStan\\Rules\\BooleansInConditions\\BooleanInElseIfConditionRule: {phpstan.rules.rule: %strictRules.booleansInConditions%}, PHPStan\\Rules\\BooleansInConditions\\BooleanInIfConditionRule: {phpstan.rules.rule: %strictRules.booleansInConditions%}, PHPStan\\Rules\\BooleansInConditions\\BooleanInTernaryOperatorRule: {phpstan.rules.rule: %strictRules.booleansInConditions%}, PHPStan\\Rules\\Cast\\UselessCastRule: {phpstan.rules.rule: %strictRules.uselessCast%}, PHPStan\\Rules\\Classes\\RequireParentConstructCallRule: {phpstan.rules.rule: %strictRules.requireParentConstructorCall%}, PHPStan\\Rules\\DisallowedConstructs\\DisallowedBacktickRule: {phpstan.rules.rule: %strictRules.disallowedConstructs%}, PHPStan\\Rules\\DisallowedConstructs\\DisallowedEmptyRule: {phpstan.rules.rule: %strictRules.disallowedConstructs%}, PHPStan\\Rules\\DisallowedConstructs\\DisallowedImplicitArrayCreationRule: {phpstan.rules.rule: %strictRules.disallowedConstructs%}, PHPStan\\Rules\\DisallowedConstructs\\DisallowedShortTernaryRule: {phpstan.rules.rule: %strictRules.disallowedConstructs%}, PHPStan\\Rules\\ForeachLoop\\OverwriteVariablesWithForeachRule: {phpstan.rules.rule: %strictRules.overwriteVariablesWithLoop%}, PHPStan\\Rules\\ForLoop\\OverwriteVariablesWithForLoopInitRule: {phpstan.rules.rule: %strictRules.overwriteVariablesWithLoop%}, PHPStan\\Rules\\Functions\\ArrayFilterStrictRule: {phpstan.rules.rule: %strictRules.strictArrayFilter%}, PHPStan\\Rules\\Functions\\ClosureUsesThisRule: {phpstan.rules.rule: %strictRules.closureUsesThis%}, PHPStan\\Rules\\Methods\\WrongCaseOfInheritedMethodRule: {phpstan.rules.rule: %strictRules.matchingInheritedMethodNames%}, PHPStan\\Rules\\Operators\\OperandInArithmeticPostDecrementRule: {phpstan.rules.rule: %strictRules.numericOperandsInArithmeticOperators%}, PHPStan\\Rules\\Operators\\OperandInArithmeticPostIncrementRule: {phpstan.rules.rule: %strictRules.numericOperandsInArithmeticOperators%}, PHPStan\\Rules\\Operators\\OperandInArithmeticPreDecrementRule: {phpstan.rules.rule: %strictRules.numericOperandsInArithmeticOperators%}, PHPStan\\Rules\\Operators\\OperandInArithmeticPreIncrementRule: {phpstan.rules.rule: %strictRules.numericOperandsInArithmeticOperators%}, PHPStan\\Rules\\Operators\\OperandsInArithmeticAdditionRule: {phpstan.rules.rule: %strictRules.numericOperandsInArithmeticOperators%}, PHPStan\\Rules\\Operators\\OperandsInArithmeticDivisionRule: {phpstan.rules.rule: %strictRules.numericOperandsInArithmeticOperators%}, PHPStan\\Rules\\Operators\\OperandsInArithmeticExponentiationRule: {phpstan.rules.rule: %strictRules.numericOperandsInArithmeticOperators%}, PHPStan\\Rules\\Operators\\OperandsInArithmeticModuloRule: {phpstan.rules.rule: %strictRules.numericOperandsInArithmeticOperators%}, PHPStan\\Rules\\Operators\\OperandsInArithmeticMultiplicationRule: {phpstan.rules.rule: %strictRules.numericOperandsInArithmeticOperators%}, PHPStan\\Rules\\Operators\\OperandsInArithmeticSubtractionRule: {phpstan.rules.rule: %strictRules.numericOperandsInArithmeticOperators%}, PHPStan\\Rules\\StrictCalls\\DynamicCallOnStaticMethodsRule: {phpstan.rules.rule: %strictRules.strictCalls%}, PHPStan\\Rules\\StrictCalls\\DynamicCallOnStaticMethodsCallableRule: {phpstan.rules.rule: %strictRules.strictCalls%}, PHPStan\\Rules\\StrictCalls\\StrictFunctionCallsRule: {phpstan.rules.rule: %strictRules.strictCalls%}, PHPStan\\Rules\\SwitchConditions\\MatchingTypeInSwitchCaseConditionRule: {phpstan.rules.rule: %strictRules.switchConditionsMatchingType%}, PHPStan\\Rules\\VariableVariables\\VariableMethodCallRule: {phpstan.rules.rule: %strictRules.noVariableVariables%}, PHPStan\\Rules\\VariableVariables\\VariableMethodCallableRule: {phpstan.rules.rule: %strictRules.noVariableVariables%}, PHPStan\\Rules\\VariableVariables\\VariableStaticMethodCallRule: {phpstan.rules.rule: %strictRules.noVariableVariables%}, PHPStan\\Rules\\VariableVariables\\VariableStaticMethodCallableRule: {phpstan.rules.rule: %strictRules.noVariableVariables%}, PHPStan\\Rules\\VariableVariables\\VariableStaticPropertyFetchRule: {phpstan.rules.rule: %strictRules.noVariableVariables%}, PHPStan\\Rules\\VariableVariables\\VariableVariablesRule: {phpstan.rules.rule: %strictRules.noVariableVariables%}, PHPStan\\Rules\\VariableVariables\\VariablePropertyFetchRule: {phpstan.rules.rule: %strictRules.noVariableVariables%}}, parameters: {polluteScopeWithLoopInitialAssignments: false, polluteScopeWithAlwaysIterableForeach: false, checkAlwaysTrueCheckTypeFunctionCall: true, checkAlwaysTrueInstanceof: true, checkAlwaysTrueStrictComparison: true, checkAlwaysTrueLooseComparison: true, checkDynamicProperties: %featureToggles.bleedingEdge%, checkExplicitMixedMissingReturn: true, checkFunctionNameCase: true, checkInternalClassCaseSensitivity: true, reportMaybesInMethodSignatures: true, reportStaticMethodSignatures: true, reportMaybesInPropertyPhpDocTypes: true, reportWrongPhpDocTypeInVarTag: %featureToggles.bleedingEdge%, featureToggles: {illegalConstructorMethodCall: %featureToggles.bleedingEdge%}, strictRules: {allRules: false, disallowedLooseComparison: true, booleansInConditions: true, uselessCast: true, requireParentConstructorCall: true, disallowedConstructs: %strictRules.allRules%, overwriteVariablesWithLoop: %strictRules.allRules%, closureUsesThis: %strictRules.allRules%, matchingInheritedMethodNames: %strictRules.allRules%, numericOperandsInArithmeticOperators: %strictRules.allRules%, strictCalls: true, switchConditionsMatchingType: %strictRules.allRules%, noVariableVariables: true, strictArrayFilter: [%strictRules.allRules%, %featureToggles.bleedingEdge%]}, level: max, paths: [/home/dan/Desktop/08/apache-htmx/src], excludePaths: {analyseAndScan: [/home/dan/Desktop/08/apache-htmx/vendor, /home/dan/Desktop/08/apache-htmx/storage, /home/dan/Desktop/08/apache-htmx/database/*.sqlite], analyse: []}, bootstrapFiles: [/home/dan/Desktop/08/apache-htmx/vendor/autoload.php], checkMissingIterableValueType: true, checkGenericClassInNonGenericObjectType: true, typeAliases: {TemplateData: "array<string, mixed>", RouteParams: "array<string, string>", ValidationRules: "array<string, array<int|string, mixed>>"}, tmpDir: /home/dan/Desktop/08/apache-htmx/storage/phpstan}, services: [{class: PHPStan\\Rules\\BooleansInConditions\\BooleanRuleHelper}, {class: PHPStan\\Rules\\Operators\\OperatorRuleHelper}, {class: PHPStan\\Rules\\VariableVariables\\VariablePropertyFetchRule, arguments: {universalObjectCratesClasses: %universalObjectCratesClasses%}}, {class: PHPStan\\Rules\\DisallowedConstructs\\DisallowedLooseComparisonRule}, {class: PHPStan\\Rules\\BooleansInConditions\\BooleanInBooleanAndRule, arguments: {bleedingEdge: %featureToggles.bleedingEdge%}}, {class: PHPStan\\Rules\\BooleansInConditions\\BooleanInBooleanNotRule}, {class: PHPStan\\Rules\\BooleansInConditions\\BooleanInBooleanOrRule, arguments: {bleedingEdge: %featureToggles.bleedingEdge%}}, {class: PHPStan\\Rules\\BooleansInConditions\\BooleanInElseIfConditionRule}, {class: PHPStan\\Rules\\BooleansInConditions\\BooleanInIfConditionRule}, {class: PHPStan\\Rules\\BooleansInConditions\\BooleanInTernaryOperatorRule}, {class: PHPStan\\Rules\\Cast\\UselessCastRule, arguments: {treatPhpDocTypesAsCertain: %treatPhpDocTypesAsCertain%, treatPhpDocTypesAsCertainTip: %tips.treatPhpDocTypesAsCertain%}}, {class: PHPStan\\Rules\\Classes\\RequireParentConstructCallRule}, {class: PHPStan\\Rules\\DisallowedConstructs\\DisallowedBacktickRule}, {class: PHPStan\\Rules\\DisallowedConstructs\\DisallowedEmptyRule}, {class: PHPStan\\Rules\\DisallowedConstructs\\DisallowedImplicitArrayCreationRule}, {class: PHPStan\\Rules\\DisallowedConstructs\\DisallowedShortTernaryRule}, {class: PHPStan\\Rules\\ForeachLoop\\OverwriteVariablesWithForeachRule}, {class: PHPStan\\Rules\\ForLoop\\OverwriteVariablesWithForLoopInitRule}, {class: PHPStan\\Rules\\Functions\\ArrayFilterStrictRule, arguments: {treatPhpDocTypesAsCertain: %treatPhpDocTypesAsCertain%, checkNullables: %checkNullables%, treatPhpDocTypesAsCertainTip: %tips.treatPhpDocTypesAsCertain%}}, {class: PHPStan\\Rules\\Functions\\ClosureUsesThisRule}, {class: PHPStan\\Rules\\Methods\\WrongCaseOfInheritedMethodRule}, {class: PHPStan\\Rules\\Operators\\OperandInArithmeticPostDecrementRule}, {class: PHPStan\\Rules\\Operators\\OperandInArithmeticPostIncrementRule}, {class: PHPStan\\Rules\\Operators\\OperandInArithmeticPreDecrementRule}, {class: PHPStan\\Rules\\Operators\\OperandInArithmeticPreIncrementRule}, {class: PHPStan\\Rules\\Operators\\OperandsInArithmeticAdditionRule, arguments: {bleedingEdge: %featureToggles.bleedingEdge%}}, {class: PHPStan\\Rules\\Operators\\OperandsInArithmeticDivisionRule, arguments: {bleedingEdge: %featureToggles.bleedingEdge%}}, {class: PHPStan\\Rules\\Operators\\OperandsInArithmeticExponentiationRule, arguments: {bleedingEdge: %featureToggles.bleedingEdge%}}, {class: PHPStan\\Rules\\Operators\\OperandsInArithmeticModuloRule, arguments: {bleedingEdge: %featureToggles.bleedingEdge%}}, {class: PHPStan\\Rules\\Operators\\OperandsInArithmeticMultiplicationRule, arguments: {bleedingEdge: %featureToggles.bleedingEdge%}}, {class: PHPStan\\Rules\\Operators\\OperandsInArithmeticSubtractionRule, arguments: {bleedingEdge: %featureToggles.bleedingEdge%}}, {class: PHPStan\\Rules\\StrictCalls\\DynamicCallOnStaticMethodsRule}, {class: PHPStan\\Rules\\StrictCalls\\DynamicCallOnStaticMethodsCallableRule}, {class: PHPStan\\Rules\\StrictCalls\\StrictFunctionCallsRule}, {class: PHPStan\\Rules\\SwitchConditions\\MatchingTypeInSwitchCaseConditionRule}, {class: PHPStan\\Rules\\VariableVariables\\VariableMethodCallRule}, {class: PHPStan\\Rules\\VariableVariables\\VariableMethodCallableRule}, {class: PHPStan\\Rules\\VariableVariables\\VariableStaticMethodCallRule}, {class: PHPStan\\Rules\\VariableVariables\\VariableStaticMethodCallableRule}, {class: PHPStan\\Rules\\VariableVariables\\VariableStaticPropertyFetchRule}, {class: PHPStan\\Rules\\VariableVariables\\VariableVariablesRule}]}',
  'analysedPaths' => 
  array (
    0 => '/home/dan/Desktop/08/apache-htmx/src/Blog/Domain/ValueObject',
  ),
  'scannedFiles' => 
  array (
    '/home/dan/Desktop/08/apache-htmx/src/Blog/Application/ArticleController.php' => 'ef82d6e63e6a641b18a1bfd46dc81214cfe42df8',
    '/home/dan/Desktop/08/apache-htmx/src/Blog/Application/ArticleService.php' => 'f97d0a264851c148d66698ef01bc46b4a623477c',
    '/home/dan/Desktop/08/apache-htmx/src/Blog/Application/Command/Article/CreateArticleCommand.php' => '3c3273792a31ebd68334b9126c9fc04427249154',
    '/home/dan/Desktop/08/apache-htmx/src/Blog/Application/Command/Article/DeleteArticleCommand.php' => 'a39cdfce7eb5d144431e6633761ab5dd094eccc7',
    '/home/dan/Desktop/08/apache-htmx/src/Blog/Application/Command/Article/UpdateArticleCommand.php' => 'cfc6cfe74d857fa8c6ccf49026cc669611a42d9e',
    '/home/dan/Desktop/08/apache-htmx/src/Blog/Application/Command/Search/SearchArticlesCommand.php' => '36335b9a9082a2993fb9e138e4688c5e72056be6',
    '/home/dan/Desktop/08/apache-htmx/src/Blog/Application/Query/Article/GetArticleBySlugQuery.php' => '3ab17695108be8ab1d7534022b3c2e5264de700c',
    '/home/dan/Desktop/08/apache-htmx/src/Blog/Application/Query/Article/GetArticleQuery.php' => 'eeb89248761635914eb8d5f6c8d8f3262eceac82',
    '/home/dan/Desktop/08/apache-htmx/src/Blog/Application/Query/Article/GetArticlesByCategoryQuery.php' => 'c29a8d23022a0998668303cfd2400828dfa6a6a7',
    '/home/dan/Desktop/08/apache-htmx/src/Blog/Application/Query/Article/GetArticlesQuery.php' => '962b39ad5fb16bc87750862249f33c846187a8ea',
    '/home/dan/Desktop/08/apache-htmx/src/Blog/Application/Query/Handler/GetArticleBySlugQueryHandler.php' => 'f13bb8ce46876cbbeae5a7ea0a8b839d9285004b',
    '/home/dan/Desktop/08/apache-htmx/src/Blog/Application/Query/Handler/GetArticlesByCategoryQueryHandler.php' => 'ffdb60b438664b97843d201de00c463923888a67',
    '/home/dan/Desktop/08/apache-htmx/src/Blog/Application/Query/Handler/GetArticlesQueryHandler.php' => '794dcae73c29ec6088c314028a155a369c68a8e0',
    '/home/dan/Desktop/08/apache-htmx/src/Blog/Application/SearchController.php' => '132594f18cab3b269e79c1175aa9346e012c994d',
    '/home/dan/Desktop/08/apache-htmx/src/Blog/Application/Service/ArticleApplicationService.php' => '419afb7942c79fddf6577a9baf7d43ba4884226f',
    '/home/dan/Desktop/08/apache-htmx/src/Blog/Domain/Article.php' => 'c78917a96d0a7bb61b646bf7c9add7d87179ae2a',
    '/home/dan/Desktop/08/apache-htmx/src/Blog/Domain/ArticleRepository.php' => '6f4a61634243ed2a4eadb17bed08ea6c323688c8',
    '/home/dan/Desktop/08/apache-htmx/src/Blog/Domain/ArticleStatus.php' => '3391d5895ef36b0444fab2940dc340e468546fdd',
    '/home/dan/Desktop/08/apache-htmx/src/Blog/Domain/Author.php' => '1a10c66c744f5eebc3cea65c2bbddabb0e032dd6',
    '/home/dan/Desktop/08/apache-htmx/src/Blog/Infrastructure/AuthorRepository.php' => 'e83854324232a5c9eb56693f611332612be031bf',
    '/home/dan/Desktop/08/apache-htmx/src/Blog/Infrastructure/SqliteArticleRepository.php' => 'c9b030e698cfdd1a0cf93983ddd244d3d5cb8e33',
    '/home/dan/Desktop/08/apache-htmx/src/Blog/Presentation/Request/ArticleRequest.php' => '1b4edcdb51853ddb42c7966b350c566599e49216',
    '/home/dan/Desktop/08/apache-htmx/src/Blog/Presentation/Response/ArticleResponse.php' => '712b1fea938b0b872f0a0062a0b5564dedc7df2c',
    '/home/dan/Desktop/08/apache-htmx/src/Blog/Presentation/Response/ArticlesResponse.php' => '0037dcc05ab60452763c74594e871620e9456ab2',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Application/Controller/AbstractController.php' => '92314afdd6d409b325561a4e4b7bb3150ed37e2b',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Application/DocsController.php' => '4639d5047d498c2fbb3a0f20bf69a56a6f313627',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Application/HomeController.php' => 'be608484331c3beabc6272dc2272788a5b61909d',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Application/PageController.php' => '4f7ed8c71a1c334b15a3ad02ffacf07e33a70bb4',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Application/Service/CommandBusInterface.php' => 'c80a831a39ba1dd74d89ecfb8f6c74ac733cdd7e',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Application/Service/QueryBusInterface.php' => 'f929dffccb40f3db48540932601328c84b879b12',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Application/Service/SimpleCommandBus.php' => '145d8a1b7f4820ca4331d2074669939796ebde25',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Application/Service/SimpleQueryBus.php' => 'd36829b6843b611e752a283281e5c4de5fca57b6',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Application/Traits/HasDatabase.php' => 'f2a9d7c472a695da21b442c93a671675f5d97762',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Application/Traits/HasValidation.php' => '585831d536f8e754c60d9bf9ac9c5a4fcedcc7ad',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Domain/ValueObject/ValueObject.php' => '627973e5f9cd8f67030a679f7c1445914ca266e5',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Application.php' => 'f61d19913adabfdc160e4e55c2a060cc4bba79f7',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Caching/CacheInterface.php' => '9eef37e495740b558fd6507ec7d7c5601d26dad1',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Caching/FileCache.php' => 'cf286593287a11f52cb645fbddc58a07e5e8c500',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Caching/QueryCache.php' => '94a0ccddfa3cc48cd5a60553a133a47c2469723e',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Config.php' => '249ecd1bf16838373f9a97b47195496551d7ba08',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/ContainerInterface.php' => '15afa125bfbfe9fccecaec1ddc73e07947d46169',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Environment.php' => '7006801a0241f84ab7358d2151599538284c647d',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/ErrorHandler.php' => '28677dc493d0227a26a5755aab9bef485200bdd8',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Exception/ServiceNotFoundException.php' => 'b83cda786b46c66d7b599f910e4b898406564d39',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Http/ApiKernel.php' => 'd0281d6d8af237ed59e08b9f1e2f6b86c3dbfe50',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Http/Kernel.php' => 'ecf0c6eabe67ab72e0118a48cefff58c1851f186',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Http/Middleware/CorsMiddleware.php' => 'a1f76192881b795f8c99b6048fc7afb94540553e',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Http/Middleware/CsrfMiddleware.php' => 'd39b78c9183a6955b3460fb0875a178bb327e6e1',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Http/Middleware/JsonMiddleware.php' => 'f57f9631405728ab73aac5628cfb2a37b7a16f5e',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Http/Middleware/LoggingMiddleware.php' => 'ce2040fc7bcef5c1f6dc80f8e152f9f385316e7a',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Http/Middleware/MiddlewareInterface.php' => '6fb193953e636065ef0b2232b69a3184b46a8a1c',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Http/Middleware/MiddlewareStack.php' => 'd1fde11b78ae3ab217f96c551e36d0e7f49cf293',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Http/Middleware/RateLimitMiddleware.php' => '3a4d400f1003dcf432da50392a4be627bc8010ad',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Http/Middleware/RequestHandlerMiddleware.php' => '00828bd3315ce8099adcef892754dd14ca00b523',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Http/Middleware/SecurityHeadersMiddleware.php' => '3fca2c06c849b634a103c1895bd9e4b174ed82b8',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Http/Psr15/Middleware/Psr15LoggingMiddleware.php' => '4a8a62b44a3a89d96bcc6e215ca9a077d38be4db',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Http/Psr15/Psr15Kernel.php' => 'bc5abdc15f4aa8934e04c889fe3baf0ac76ac5a5',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Http/Psr15/Psr15MiddlewareAdapter.php' => '33b502ce67444f7154f4ee7b2361ca953195b999',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Http/Psr15/Psr15MiddlewareStack.php' => 'fcf59b2a73c514075ae7e80b0014918ee8e64174',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Http/Psr15/Psr15RequestHandler.php' => 'c13de590ab5395c26676c0325fe1874111e0455f',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Http/Psr15/PsrRequestAdapter.php' => 'd30e4b1b46717cdc81d86c4176274107ae842a12',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Http/Psr15/PsrResponseAdapter.php' => 'b7490cd3a38aec1b1f3cd7894e67709791ebc13f',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Http/RequestHandler.php' => 'c79812630c9173ac9c4646d953a6bf436f4602e9',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Http/Router.php' => '00b0e1180ce3698b4d3785e6505ababcdb0133b0',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Http/RouterWithMiddleware.php' => '827866ce73ffcced9ec6694346bcc94eec88f29d',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Logger.php' => 'd645cbf4dab8b01a3e7c56556949568f93ace6de',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Monitoring/CompressionMiddleware.php' => 'fa2d28450006764ab6b63ce1426f26d8a0f1c0e6',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Monitoring/PerformanceMonitor.php' => 'b1bfe61da38a5b3cf173a479ee654252656f394a',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Path/FilePathCache.php' => 'b1b6a9108b60463c8d353cb1a19d62baf028a735',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Path/PathCacheInterface.php' => 'eebbf89ea35ae7ed0aafd9fd2b935305c3d7ff39',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Path/PathEvent.php' => '42503a3ae59bb7b09a575768a3003893a1b1787a',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Path/PathEventInterface.php' => 'e70f069d642eba9a7ce41f21694fd70d68321701',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Path/PathResolverInterface.php' => '3619a7db44a8b6abcac4418f91a69d664a697348',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/PathManager.php' => 'ddda4fc7c870f58b6b7b5bae18c8d07f0fc114f1',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Persistence/Database.php' => '4575eee73238612d6166020faa95b76d688197ac',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Security/CsrfProtection.php' => '4c2e4aaa5e4480dea07797364cd3f78554c8255e',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Security/InputValidator.php' => '5c039e2af68d80fb9561a8cb5f4018283ea1c232',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Security/RateLimiter.php' => 'b5b41f06835910bb26c795b91f8639c9cecec1a9',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Security/SessionManager.php' => '96247f551ff2ff04e1bfdc8aa4eea3242d4c904d',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/ServiceFactory.php' => 'c7524a78a56add3da7de901abe105618e258c4e1',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/ServiceProviderInterface.php' => 'a93bcc645d0a446a35b11fe22d88b08fe79deb74',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Templating/Assets/AssetManager.php' => '88dfebf02bf67e40b1487886ea4aa5f5183f81ba',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Templating/TemplateEngine.php' => '9d23efad4ded6863b4e3beb7511d5a7a0509eeb7',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Templating/TemplateEngineWithCache.php' => '6bfaf63d15f90535215edbf6f05db87ccc9488df',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Infrastructure/Templating/ThemeManager.php' => '5225e18c52d26e68c297b63ccb2b508049866f79',
    '/home/dan/Desktop/08/apache-htmx/src/Shared/Presentation/Request/PaginationRequest.php' => '9ea1ac8a0c719db2b670265057e0bb5151731708',
  ),
  'composerLocks' => 
  array (
    '/home/dan/Desktop/08/apache-htmx/composer.lock' => '8452f14f94b128394728a29a66ab2c77699d7f44',
  ),
  'composerInstalled' => 
  array (
    '/home/dan/Desktop/08/apache-htmx/vendor/composer/installed.php' => 
    array (
      'versions' => 
      array (
        'behat/behat' => 
        array (
          'pretty_version' => 'v3.23.0',
          'version' => '3.23.0.0',
          'reference' => 'c465af8756adaaa6d962c3176a0a6c594361809b',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../behat/behat',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'behat/gherkin' => 
        array (
          'pretty_version' => 'v4.14.0',
          'version' => '4.14.0.0',
          'reference' => '34c9b59c59355a7b4c53b9f041c8dbd1c8acc3b4',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../behat/gherkin',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'clue/ndjson-react' => 
        array (
          'pretty_version' => 'v1.3.0',
          'version' => '1.3.0.0',
          'reference' => '392dc165fce93b5bb5c637b67e59619223c931b0',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../clue/ndjson-react',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'composer/pcre' => 
        array (
          'pretty_version' => '3.3.2',
          'version' => '3.3.2.0',
          'reference' => 'b2bed4734f0cc156ee1fe9c0da2550420d99a21e',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/./pcre',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'composer/semver' => 
        array (
          'pretty_version' => '3.4.4',
          'version' => '3.4.4.0',
          'reference' => '198166618906cb2de69b95d7d47e5fa8aa1b2b95',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/./semver',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'composer/xdebug-handler' => 
        array (
          'pretty_version' => '3.0.5',
          'version' => '3.0.5.0',
          'reference' => '6c1925561632e83d60a44492e0b344cf48ab85ef',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/./xdebug-handler',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'evenement/evenement' => 
        array (
          'pretty_version' => 'v3.0.2',
          'version' => '3.0.2.0',
          'reference' => '0a16b0d71ab13284339abb99d9d2bd813640efbc',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../evenement/evenement',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'fidry/cpu-core-counter' => 
        array (
          'pretty_version' => '1.3.0',
          'version' => '1.3.0.0',
          'reference' => 'db9508f7b1474469d9d3c53b86f817e344732678',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../fidry/cpu-core-counter',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'friendsofphp/php-cs-fixer' => 
        array (
          'pretty_version' => 'v3.86.0',
          'version' => '3.86.0.0',
          'reference' => '4a952bd19dc97879b0620f495552ef09b55f7d36',
          'type' => 'application',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../friendsofphp/php-cs-fixer',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'league/plates' => 
        array (
          'pretty_version' => 'v3.6.0',
          'version' => '3.6.0.0',
          'reference' => '12ee65166adbc6fb5916fb80b0c0758e49a2d996',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../league/plates',
          'aliases' => 
          array (
          ),
          'dev_requirement' => false,
        ),
        'myclabs/deep-copy' => 
        array (
          'pretty_version' => '1.13.4',
          'version' => '1.13.4.0',
          'reference' => '07d290f0c47959fd5eed98c95ee5602db07e0b6a',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../myclabs/deep-copy',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'nikic/fast-route' => 
        array (
          'pretty_version' => 'v1.3.0',
          'version' => '1.3.0.0',
          'reference' => '181d480e08d9476e61381e04a71b34dc0432e812',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../nikic/fast-route',
          'aliases' => 
          array (
          ),
          'dev_requirement' => false,
        ),
        'nikic/php-parser' => 
        array (
          'pretty_version' => 'v5.6.1',
          'version' => '5.6.1.0',
          'reference' => 'f103601b29efebd7ff4a1ca7b3eeea9e3336a2a2',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../nikic/php-parser',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'phar-io/manifest' => 
        array (
          'pretty_version' => '2.0.4',
          'version' => '2.0.4.0',
          'reference' => '54750ef60c58e43759730615a392c31c80e23176',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../phar-io/manifest',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'phar-io/version' => 
        array (
          'pretty_version' => '3.2.1',
          'version' => '3.2.1.0',
          'reference' => '4f7fd7836c6f332bb2933569e566a0d6c4cbed74',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../phar-io/version',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'phpstan/phpstan' => 
        array (
          'pretty_version' => '1.12.28',
          'version' => '1.12.28.0',
          'reference' => 'fcf8b71aeab4e1a1131d1783cef97b23a51b87a9',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../phpstan/phpstan',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'phpstan/phpstan-strict-rules' => 
        array (
          'pretty_version' => '1.6.2',
          'version' => '1.6.2.0',
          'reference' => 'b564ca479e7e735f750aaac4935af965572a7845',
          'type' => 'phpstan-extension',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../phpstan/phpstan-strict-rules',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'phpunit/php-code-coverage' => 
        array (
          'pretty_version' => '10.1.16',
          'version' => '10.1.16.0',
          'reference' => '7e308268858ed6baedc8704a304727d20bc07c77',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../phpunit/php-code-coverage',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'phpunit/php-file-iterator' => 
        array (
          'pretty_version' => '4.1.0',
          'version' => '4.1.0.0',
          'reference' => 'a95037b6d9e608ba092da1b23931e537cadc3c3c',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../phpunit/php-file-iterator',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'phpunit/php-invoker' => 
        array (
          'pretty_version' => '4.0.0',
          'version' => '4.0.0.0',
          'reference' => 'f5e568ba02fa5ba0ddd0f618391d5a9ea50b06d7',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../phpunit/php-invoker',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'phpunit/php-text-template' => 
        array (
          'pretty_version' => '3.0.1',
          'version' => '3.0.1.0',
          'reference' => '0c7b06ff49e3d5072f057eb1fa59258bf287a748',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../phpunit/php-text-template',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'phpunit/php-timer' => 
        array (
          'pretty_version' => '6.0.0',
          'version' => '6.0.0.0',
          'reference' => 'e2a2d67966e740530f4a3343fe2e030ffdc1161d',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../phpunit/php-timer',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'phpunit/phpunit' => 
        array (
          'pretty_version' => '10.5.53',
          'version' => '10.5.53.0',
          'reference' => '32768472ebfb6969e6c7399f1c7b09009723f653',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../phpunit/phpunit',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'psr/container' => 
        array (
          'pretty_version' => '2.0.2',
          'version' => '2.0.2.0',
          'reference' => 'c71ecc56dfe541dbd90c5360474fbc405f8d5963',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../psr/container',
          'aliases' => 
          array (
          ),
          'dev_requirement' => false,
        ),
        'psr/container-implementation' => 
        array (
          'dev_requirement' => true,
          'provided' => 
          array (
            0 => '1.1|2.0',
          ),
        ),
        'psr/event-dispatcher' => 
        array (
          'pretty_version' => '1.0.0',
          'version' => '1.0.0.0',
          'reference' => 'dbefd12671e8a14ec7f180cab83036ed26714bb0',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../psr/event-dispatcher',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'psr/event-dispatcher-implementation' => 
        array (
          'dev_requirement' => true,
          'provided' => 
          array (
            0 => '1.0',
          ),
        ),
        'psr/http-message' => 
        array (
          'pretty_version' => '2.0',
          'version' => '2.0.0.0',
          'reference' => '402d35bcb92c70c026d1a6a9883f06b2ead23d71',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../psr/http-message',
          'aliases' => 
          array (
          ),
          'dev_requirement' => false,
        ),
        'psr/http-server-handler' => 
        array (
          'pretty_version' => '1.0.2',
          'version' => '1.0.2.0',
          'reference' => '84c4fb66179be4caaf8e97bd239203245302e7d4',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../psr/http-server-handler',
          'aliases' => 
          array (
          ),
          'dev_requirement' => false,
        ),
        'psr/log' => 
        array (
          'pretty_version' => '3.0.2',
          'version' => '3.0.2.0',
          'reference' => 'f16e1d5863e37f8d8c2a01719f5b34baa2b714d3',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../psr/log',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'psr/log-implementation' => 
        array (
          'dev_requirement' => true,
          'provided' => 
          array (
            0 => '1.0|2.0|3.0',
          ),
        ),
        'react/cache' => 
        array (
          'pretty_version' => 'v1.2.0',
          'version' => '1.2.0.0',
          'reference' => 'd47c472b64aa5608225f47965a484b75c7817d5b',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../react/cache',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'react/child-process' => 
        array (
          'pretty_version' => 'v0.6.6',
          'version' => '0.6.6.0',
          'reference' => '1721e2b93d89b745664353b9cfc8f155ba8a6159',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../react/child-process',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'react/dns' => 
        array (
          'pretty_version' => 'v1.13.0',
          'version' => '1.13.0.0',
          'reference' => 'eb8ae001b5a455665c89c1df97f6fb682f8fb0f5',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../react/dns',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'react/event-loop' => 
        array (
          'pretty_version' => 'v1.5.0',
          'version' => '1.5.0.0',
          'reference' => 'bbe0bd8c51ffc05ee43f1729087ed3bdf7d53354',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../react/event-loop',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'react/promise' => 
        array (
          'pretty_version' => 'v3.3.0',
          'version' => '3.3.0.0',
          'reference' => '23444f53a813a3296c1368bb104793ce8d88f04a',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../react/promise',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'react/socket' => 
        array (
          'pretty_version' => 'v1.16.0',
          'version' => '1.16.0.0',
          'reference' => '23e4ff33ea3e160d2d1f59a0e6050e4b0fb0eac1',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../react/socket',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'react/stream' => 
        array (
          'pretty_version' => 'v1.4.0',
          'version' => '1.4.0.0',
          'reference' => '1e5b0acb8fe55143b5b426817155190eb6f5b18d',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../react/stream',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'responsive-sk/slim4-paths' => 
        array (
          'pretty_version' => '6.0.0',
          'version' => '6.0.0.0',
          'reference' => 'dbe889195ebee4d3f0f8b590815447be0e111382',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../responsive-sk/slim4-paths',
          'aliases' => 
          array (
          ),
          'dev_requirement' => false,
        ),
        'sebastian/cli-parser' => 
        array (
          'pretty_version' => '2.0.1',
          'version' => '2.0.1.0',
          'reference' => 'c34583b87e7b7a8055bf6c450c2c77ce32a24084',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../sebastian/cli-parser',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'sebastian/code-unit' => 
        array (
          'pretty_version' => '2.0.0',
          'version' => '2.0.0.0',
          'reference' => 'a81fee9eef0b7a76af11d121767abc44c104e503',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../sebastian/code-unit',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'sebastian/code-unit-reverse-lookup' => 
        array (
          'pretty_version' => '3.0.0',
          'version' => '3.0.0.0',
          'reference' => '5e3a687f7d8ae33fb362c5c0743794bbb2420a1d',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../sebastian/code-unit-reverse-lookup',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'sebastian/comparator' => 
        array (
          'pretty_version' => '5.0.3',
          'version' => '5.0.3.0',
          'reference' => 'a18251eb0b7a2dcd2f7aa3d6078b18545ef0558e',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../sebastian/comparator',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'sebastian/complexity' => 
        array (
          'pretty_version' => '3.2.0',
          'version' => '3.2.0.0',
          'reference' => '68ff824baeae169ec9f2137158ee529584553799',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../sebastian/complexity',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'sebastian/diff' => 
        array (
          'pretty_version' => '5.1.1',
          'version' => '5.1.1.0',
          'reference' => 'c41e007b4b62af48218231d6c2275e4c9b975b2e',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../sebastian/diff',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'sebastian/environment' => 
        array (
          'pretty_version' => '6.1.0',
          'version' => '6.1.0.0',
          'reference' => '8074dbcd93529b357029f5cc5058fd3e43666984',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../sebastian/environment',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'sebastian/exporter' => 
        array (
          'pretty_version' => '5.1.2',
          'version' => '5.1.2.0',
          'reference' => '955288482d97c19a372d3f31006ab3f37da47adf',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../sebastian/exporter',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'sebastian/global-state' => 
        array (
          'pretty_version' => '6.0.2',
          'version' => '6.0.2.0',
          'reference' => '987bafff24ecc4c9ac418cab1145b96dd6e9cbd9',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../sebastian/global-state',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'sebastian/lines-of-code' => 
        array (
          'pretty_version' => '2.0.2',
          'version' => '2.0.2.0',
          'reference' => '856e7f6a75a84e339195d48c556f23be2ebf75d0',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../sebastian/lines-of-code',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'sebastian/object-enumerator' => 
        array (
          'pretty_version' => '5.0.0',
          'version' => '5.0.0.0',
          'reference' => '202d0e344a580d7f7d04b3fafce6933e59dae906',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../sebastian/object-enumerator',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'sebastian/object-reflector' => 
        array (
          'pretty_version' => '3.0.0',
          'version' => '3.0.0.0',
          'reference' => '24ed13d98130f0e7122df55d06c5c4942a577957',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../sebastian/object-reflector',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'sebastian/recursion-context' => 
        array (
          'pretty_version' => '5.0.1',
          'version' => '5.0.1.0',
          'reference' => '47e34210757a2f37a97dcd207d032e1b01e64c7a',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../sebastian/recursion-context',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'sebastian/type' => 
        array (
          'pretty_version' => '4.0.0',
          'version' => '4.0.0.0',
          'reference' => '462699a16464c3944eefc02ebdd77882bd3925bf',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../sebastian/type',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'sebastian/version' => 
        array (
          'pretty_version' => '4.0.1',
          'version' => '4.0.1.0',
          'reference' => 'c51fa83a5d8f43f1402e3f32a005e6262244ef17',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../sebastian/version',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'symfony/config' => 
        array (
          'pretty_version' => 'v7.3.2',
          'version' => '7.3.2.0',
          'reference' => 'faef36e271bbeb74a9d733be4b56419b157762e2',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../symfony/config',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'symfony/console' => 
        array (
          'pretty_version' => 'v7.3.3',
          'version' => '7.3.3.0',
          'reference' => 'cb0102a1c5ac3807cf3fdf8bea96007df7fdbea7',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../symfony/console',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'symfony/dependency-injection' => 
        array (
          'pretty_version' => 'v7.3.3',
          'version' => '7.3.3.0',
          'reference' => 'ab6c38dad5da9b15b1f7afb2f5c5814112e70261',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../symfony/dependency-injection',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'symfony/deprecation-contracts' => 
        array (
          'pretty_version' => 'v3.6.0',
          'version' => '3.6.0.0',
          'reference' => '63afe740e99a13ba87ec199bb07bbdee937a5b62',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../symfony/deprecation-contracts',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'symfony/event-dispatcher' => 
        array (
          'pretty_version' => 'v7.3.3',
          'version' => '7.3.3.0',
          'reference' => 'b7dc69e71de420ac04bc9ab830cf3ffebba48191',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../symfony/event-dispatcher',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'symfony/event-dispatcher-contracts' => 
        array (
          'pretty_version' => 'v3.6.0',
          'version' => '3.6.0.0',
          'reference' => '59eb412e93815df44f05f342958efa9f46b1e586',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../symfony/event-dispatcher-contracts',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'symfony/event-dispatcher-implementation' => 
        array (
          'dev_requirement' => true,
          'provided' => 
          array (
            0 => '2.0|3.0',
          ),
        ),
        'symfony/filesystem' => 
        array (
          'pretty_version' => 'v7.3.2',
          'version' => '7.3.2.0',
          'reference' => 'edcbb768a186b5c3f25d0643159a787d3e63b7fd',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../symfony/filesystem',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'symfony/finder' => 
        array (
          'pretty_version' => 'v7.3.2',
          'version' => '7.3.2.0',
          'reference' => '2a6614966ba1074fa93dae0bc804227422df4dfe',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../symfony/finder',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'symfony/options-resolver' => 
        array (
          'pretty_version' => 'v7.3.3',
          'version' => '7.3.3.0',
          'reference' => '0ff2f5c3df08a395232bbc3c2eb7e84912df911d',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../symfony/options-resolver',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'symfony/polyfill-ctype' => 
        array (
          'pretty_version' => 'v1.33.0',
          'version' => '1.33.0.0',
          'reference' => 'a3cc8b044a6ea513310cbd48ef7333b384945638',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../symfony/polyfill-ctype',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'symfony/polyfill-intl-grapheme' => 
        array (
          'pretty_version' => 'v1.33.0',
          'version' => '1.33.0.0',
          'reference' => '380872130d3a5dd3ace2f4010d95125fde5d5c70',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../symfony/polyfill-intl-grapheme',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'symfony/polyfill-intl-normalizer' => 
        array (
          'pretty_version' => 'v1.33.0',
          'version' => '1.33.0.0',
          'reference' => '3833d7255cc303546435cb650316bff708a1c75c',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../symfony/polyfill-intl-normalizer',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'symfony/polyfill-mbstring' => 
        array (
          'pretty_version' => 'v1.33.0',
          'version' => '1.33.0.0',
          'reference' => '6d857f4d76bd4b343eac26d6b539585d2bc56493',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../symfony/polyfill-mbstring',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'symfony/polyfill-php80' => 
        array (
          'pretty_version' => 'v1.33.0',
          'version' => '1.33.0.0',
          'reference' => '0cc9dd0f17f61d8131e7df6b84bd344899fe2608',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../symfony/polyfill-php80',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'symfony/polyfill-php81' => 
        array (
          'pretty_version' => 'v1.33.0',
          'version' => '1.33.0.0',
          'reference' => '4a4cfc2d253c21a5ad0e53071df248ed48c6ce5c',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../symfony/polyfill-php81',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'symfony/process' => 
        array (
          'pretty_version' => 'v7.3.3',
          'version' => '7.3.3.0',
          'reference' => '32241012d521e2e8a9d713adb0812bb773b907f1',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../symfony/process',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'symfony/service-contracts' => 
        array (
          'pretty_version' => 'v3.6.0',
          'version' => '3.6.0.0',
          'reference' => 'f021b05a130d35510bd6b25fe9053c2a8a15d5d4',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../symfony/service-contracts',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'symfony/service-implementation' => 
        array (
          'dev_requirement' => true,
          'provided' => 
          array (
            0 => '1.1|2.0|3.0',
          ),
        ),
        'symfony/stopwatch' => 
        array (
          'pretty_version' => 'v7.3.0',
          'version' => '7.3.0.0',
          'reference' => '5a49289e2b308214c8b9c2fda4ea454d8b8ad7cd',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../symfony/stopwatch',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'symfony/string' => 
        array (
          'pretty_version' => 'v7.3.3',
          'version' => '7.3.3.0',
          'reference' => '17a426cce5fd1f0901fefa9b2a490d0038fd3c9c',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../symfony/string',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'symfony/translation' => 
        array (
          'pretty_version' => 'v7.3.3',
          'version' => '7.3.3.0',
          'reference' => 'e0837b4cbcef63c754d89a4806575cada743a38d',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../symfony/translation',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'symfony/translation-contracts' => 
        array (
          'pretty_version' => 'v3.6.0',
          'version' => '3.6.0.0',
          'reference' => 'df210c7a2573f1913b2d17cc95f90f53a73d8f7d',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../symfony/translation-contracts',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'symfony/translation-implementation' => 
        array (
          'dev_requirement' => true,
          'provided' => 
          array (
            0 => '2.3|3.0',
          ),
        ),
        'symfony/var-exporter' => 
        array (
          'pretty_version' => 'v7.3.3',
          'version' => '7.3.3.0',
          'reference' => 'd4dfcd2a822cbedd7612eb6fbd260e46f87b7137',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../symfony/var-exporter',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'symfony/yaml' => 
        array (
          'pretty_version' => 'v7.3.3',
          'version' => '7.3.3.0',
          'reference' => 'd4f4a66866fe2451f61296924767280ab5732d9d',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../symfony/yaml',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
        'theseer/tokenizer' => 
        array (
          'pretty_version' => '1.2.3',
          'version' => '1.2.3.0',
          'reference' => '737eda637ed5e28c3413cb1ebe8bb52cbf1ca7a2',
          'type' => 'library',
          'install_path' => '/home/dan/Desktop/08/apache-htmx/vendor/composer/../theseer/tokenizer',
          'aliases' => 
          array (
          ),
          'dev_requirement' => true,
        ),
      ),
    ),
  ),
  'executedFilesHashes' => 
  array (
    '/home/dan/Desktop/08/apache-htmx/vendor/autoload.php' => '6b72d3d30ac0ef972ef0dc06b80e527a1d85a2ba',
    'phar:///home/dan/Desktop/08/apache-htmx/vendor/phpstan/phpstan/phpstan.phar/stubs/runtime/Attribute.php' => 'eaf9127f074e9c7ebc65043ec4050f9fed60c2bb',
    'phar:///home/dan/Desktop/08/apache-htmx/vendor/phpstan/phpstan/phpstan.phar/stubs/runtime/ReflectionAttribute.php' => '0b4b78277eb6545955d2ce5e09bff28f1f8052c8',
    'phar:///home/dan/Desktop/08/apache-htmx/vendor/phpstan/phpstan/phpstan.phar/stubs/runtime/ReflectionIntersectionType.php' => 'a3e6299b87ee5d407dae7651758edfa11a74cb11',
    'phar:///home/dan/Desktop/08/apache-htmx/vendor/phpstan/phpstan/phpstan.phar/stubs/runtime/ReflectionUnionType.php' => '1b349aa997a834faeafe05fa21bc31cae22bf2e2',
  ),
  'phpExtensions' => 
  array (
    0 => 'Core',
    1 => 'PDO',
    2 => 'Phar',
    3 => 'Reflection',
    4 => 'SPL',
    5 => 'SimpleXML',
    6 => 'Zend OPcache',
    7 => 'apcu',
    8 => 'bcmath',
    9 => 'bz2',
    10 => 'calendar',
    11 => 'ctype',
    12 => 'curl',
    13 => 'date',
    14 => 'dom',
    15 => 'exif',
    16 => 'fileinfo',
    17 => 'filter',
    18 => 'ftp',
    19 => 'gd',
    20 => 'gettext',
    21 => 'gmp',
    22 => 'hash',
    23 => 'iconv',
    24 => 'imagick',
    25 => 'intl',
    26 => 'json',
    27 => 'libxml',
    28 => 'mbstring',
    29 => 'mysqli',
    30 => 'mysqlnd',
    31 => 'openssl',
    32 => 'pcntl',
    33 => 'pcre',
    34 => 'pdo_mysql',
    35 => 'pdo_sqlite',
    36 => 'posix',
    37 => 'random',
    38 => 'readline',
    39 => 'session',
    40 => 'snmp',
    41 => 'soap',
    42 => 'sockets',
    43 => 'sqlite3',
    44 => 'standard',
    45 => 'tokenizer',
    46 => 'xml',
    47 => 'xmlreader',
    48 => 'xmlwriter',
    49 => 'zip',
    50 => 'zlib',
  ),
  'stubFiles' => 
  array (
  ),
  'level' => 'max',
),
	'projectExtensionFiles' => array (
),
	'errorsCallback' => static function (): array { return array (
); },
	'locallyIgnoredErrorsCallback' => static function (): array { return array (
); },
	'linesToIgnore' => array (
),
	'unmatchedLineIgnores' => array (
),
	'collectedDataCallback' => static function (): array { return array (
); },
	'dependencies' => array (
  '/home/dan/Desktop/08/apache-htmx/src/Blog/Domain/ValueObject/ArticleContent.php' => 
  array (
    'fileHash' => '498175044746e44421272c1a00453d8f801c36d6',
    'dependentFiles' => 
    array (
    ),
  ),
  '/home/dan/Desktop/08/apache-htmx/src/Blog/Domain/ValueObject/ArticleId.php' => 
  array (
    'fileHash' => '90ae4824a695b3f5a78c8fefa074ac917f2802c7',
    'dependentFiles' => 
    array (
    ),
  ),
  '/home/dan/Desktop/08/apache-htmx/src/Blog/Domain/ValueObject/ArticleStatus.php' => 
  array (
    'fileHash' => '36774d06da01803dee6629e2a6ed994165bf29d1',
    'dependentFiles' => 
    array (
    ),
  ),
  '/home/dan/Desktop/08/apache-htmx/src/Blog/Domain/ValueObject/ArticleTitle.php' => 
  array (
    'fileHash' => 'a22dcf74529a5009dc9a77c34864aafa7a4d77eb',
    'dependentFiles' => 
    array (
    ),
  ),
),
	'exportedNodesCallback' => static function (): array { return array (
  '/home/dan/Desktop/08/apache-htmx/src/Blog/Domain/ValueObject/ArticleContent.php' => 
  array (
    0 => 
    \PHPStan\Dependency\ExportedNode\ExportedClassNode::__set_state(array(
       'name' => 'Boson\\Blog\\Domain\\ValueObject\\ArticleContent',
       'phpDoc' => 
      \PHPStan\Dependency\ExportedNode\ExportedPhpDocNode::__set_state(array(
         'phpDocString' => '/**
 * Article Content Value Object
 */',
         'namespace' => 'Boson\\Blog\\Domain\\ValueObject',
         'uses' => 
        array (
          'valueobject' => 'Boson\\Shared\\Domain\\ValueObject\\ValueObject',
          'inputvalidator' => 'Boson\\Shared\\Infrastructure\\Security\\InputValidator',
        ),
         'constUses' => 
        array (
        ),
      )),
       'abstract' => false,
       'final' => true,
       'extends' => NULL,
       'implements' => 
      array (
        0 => 'Boson\\Shared\\Domain\\ValueObject\\ValueObject',
      ),
       'usedTraits' => 
      array (
      ),
       'traitUseAdaptations' => 
      array (
      ),
       'statements' => 
      array (
        0 => 
        \PHPStan\Dependency\ExportedNode\ExportedMethodNode::__set_state(array(
           'name' => 'fromString',
           'phpDoc' => NULL,
           'byRef' => false,
           'public' => true,
           'private' => false,
           'abstract' => false,
           'final' => false,
           'static' => true,
           'returnType' => 'self',
           'parameters' => 
          array (
            0 => 
            \PHPStan\Dependency\ExportedNode\ExportedParameterNode::__set_state(array(
               'name' => 'value',
               'type' => 'string',
               'byRef' => false,
               'variadic' => false,
               'hasDefault' => false,
               'attributes' => 
              array (
              ),
            )),
          ),
           'attributes' => 
          array (
          ),
        )),
        1 => 
        \PHPStan\Dependency\ExportedNode\ExportedMethodNode::__set_state(array(
           'name' => 'value',
           'phpDoc' => NULL,
           'byRef' => false,
           'public' => true,
           'private' => false,
           'abstract' => false,
           'final' => false,
           'static' => false,
           'returnType' => 'string',
           'parameters' => 
          array (
          ),
           'attributes' => 
          array (
          ),
        )),
        2 => 
        \PHPStan\Dependency\ExportedNode\ExportedMethodNode::__set_state(array(
           'name' => 'toString',
           'phpDoc' => NULL,
           'byRef' => false,
           'public' => true,
           'private' => false,
           'abstract' => false,
           'final' => false,
           'static' => false,
           'returnType' => 'string',
           'parameters' => 
          array (
          ),
           'attributes' => 
          array (
          ),
        )),
        3 => 
        \PHPStan\Dependency\ExportedNode\ExportedMethodNode::__set_state(array(
           'name' => 'equals',
           'phpDoc' => NULL,
           'byRef' => false,
           'public' => true,
           'private' => false,
           'abstract' => false,
           'final' => false,
           'static' => false,
           'returnType' => 'bool',
           'parameters' => 
          array (
            0 => 
            \PHPStan\Dependency\ExportedNode\ExportedParameterNode::__set_state(array(
               'name' => 'other',
               'type' => '?Boson\\Shared\\Domain\\ValueObject\\ValueObject',
               'byRef' => false,
               'variadic' => false,
               'hasDefault' => false,
               'attributes' => 
              array (
              ),
            )),
          ),
           'attributes' => 
          array (
          ),
        )),
        4 => 
        \PHPStan\Dependency\ExportedNode\ExportedMethodNode::__set_state(array(
           'name' => '__toString',
           'phpDoc' => NULL,
           'byRef' => false,
           'public' => true,
           'private' => false,
           'abstract' => false,
           'final' => false,
           'static' => false,
           'returnType' => 'string',
           'parameters' => 
          array (
          ),
           'attributes' => 
          array (
          ),
        )),
      ),
       'attributes' => 
      array (
      ),
    )),
  ),
  '/home/dan/Desktop/08/apache-htmx/src/Blog/Domain/ValueObject/ArticleId.php' => 
  array (
    0 => 
    \PHPStan\Dependency\ExportedNode\ExportedClassNode::__set_state(array(
       'name' => 'Boson\\Blog\\Domain\\ValueObject\\ArticleId',
       'phpDoc' => 
      \PHPStan\Dependency\ExportedNode\ExportedPhpDocNode::__set_state(array(
         'phpDocString' => '/**
 * Article ID Value Object
 */',
         'namespace' => 'Boson\\Blog\\Domain\\ValueObject',
         'uses' => 
        array (
          'valueobject' => 'Boson\\Shared\\Domain\\ValueObject\\ValueObject',
          'inputvalidator' => 'Boson\\Shared\\Infrastructure\\Security\\InputValidator',
        ),
         'constUses' => 
        array (
        ),
      )),
       'abstract' => false,
       'final' => true,
       'extends' => NULL,
       'implements' => 
      array (
        0 => 'Boson\\Shared\\Domain\\ValueObject\\ValueObject',
      ),
       'usedTraits' => 
      array (
      ),
       'traitUseAdaptations' => 
      array (
      ),
       'statements' => 
      array (
        0 => 
        \PHPStan\Dependency\ExportedNode\ExportedMethodNode::__set_state(array(
           'name' => 'fromInt',
           'phpDoc' => NULL,
           'byRef' => false,
           'public' => true,
           'private' => false,
           'abstract' => false,
           'final' => false,
           'static' => true,
           'returnType' => 'self',
           'parameters' => 
          array (
            0 => 
            \PHPStan\Dependency\ExportedNode\ExportedParameterNode::__set_state(array(
               'name' => 'value',
               'type' => 'int',
               'byRef' => false,
               'variadic' => false,
               'hasDefault' => false,
               'attributes' => 
              array (
              ),
            )),
          ),
           'attributes' => 
          array (
          ),
        )),
        1 => 
        \PHPStan\Dependency\ExportedNode\ExportedMethodNode::__set_state(array(
           'name' => 'fromString',
           'phpDoc' => NULL,
           'byRef' => false,
           'public' => true,
           'private' => false,
           'abstract' => false,
           'final' => false,
           'static' => true,
           'returnType' => 'self',
           'parameters' => 
          array (
            0 => 
            \PHPStan\Dependency\ExportedNode\ExportedParameterNode::__set_state(array(
               'name' => 'value',
               'type' => 'string',
               'byRef' => false,
               'variadic' => false,
               'hasDefault' => false,
               'attributes' => 
              array (
              ),
            )),
          ),
           'attributes' => 
          array (
          ),
        )),
        2 => 
        \PHPStan\Dependency\ExportedNode\ExportedMethodNode::__set_state(array(
           'name' => 'value',
           'phpDoc' => NULL,
           'byRef' => false,
           'public' => true,
           'private' => false,
           'abstract' => false,
           'final' => false,
           'static' => false,
           'returnType' => 'int',
           'parameters' => 
          array (
          ),
           'attributes' => 
          array (
          ),
        )),
        3 => 
        \PHPStan\Dependency\ExportedNode\ExportedMethodNode::__set_state(array(
           'name' => 'toInt',
           'phpDoc' => NULL,
           'byRef' => false,
           'public' => true,
           'private' => false,
           'abstract' => false,
           'final' => false,
           'static' => false,
           'returnType' => 'int',
           'parameters' => 
          array (
          ),
           'attributes' => 
          array (
          ),
        )),
        4 => 
        \PHPStan\Dependency\ExportedNode\ExportedMethodNode::__set_state(array(
           'name' => 'toString',
           'phpDoc' => NULL,
           'byRef' => false,
           'public' => true,
           'private' => false,
           'abstract' => false,
           'final' => false,
           'static' => false,
           'returnType' => 'string',
           'parameters' => 
          array (
          ),
           'attributes' => 
          array (
          ),
        )),
        5 => 
        \PHPStan\Dependency\ExportedNode\ExportedMethodNode::__set_state(array(
           'name' => 'equals',
           'phpDoc' => NULL,
           'byRef' => false,
           'public' => true,
           'private' => false,
           'abstract' => false,
           'final' => false,
           'static' => false,
           'returnType' => 'bool',
           'parameters' => 
          array (
            0 => 
            \PHPStan\Dependency\ExportedNode\ExportedParameterNode::__set_state(array(
               'name' => 'other',
               'type' => '?Boson\\Shared\\Domain\\ValueObject\\ValueObject',
               'byRef' => false,
               'variadic' => false,
               'hasDefault' => false,
               'attributes' => 
              array (
              ),
            )),
          ),
           'attributes' => 
          array (
          ),
        )),
        6 => 
        \PHPStan\Dependency\ExportedNode\ExportedMethodNode::__set_state(array(
           'name' => '__toString',
           'phpDoc' => NULL,
           'byRef' => false,
           'public' => true,
           'private' => false,
           'abstract' => false,
           'final' => false,
           'static' => false,
           'returnType' => 'string',
           'parameters' => 
          array (
          ),
           'attributes' => 
          array (
          ),
        )),
      ),
       'attributes' => 
      array (
      ),
    )),
  ),
  '/home/dan/Desktop/08/apache-htmx/src/Blog/Domain/ValueObject/ArticleStatus.php' => 
  array (
    0 => 
    \PHPStan\Dependency\ExportedNode\ExportedClassNode::__set_state(array(
       'name' => 'Boson\\Blog\\Domain\\ValueObject\\ArticleStatus',
       'phpDoc' => 
      \PHPStan\Dependency\ExportedNode\ExportedPhpDocNode::__set_state(array(
         'phpDocString' => '/**
 * Article Status Value Object
 */',
         'namespace' => 'Boson\\Blog\\Domain\\ValueObject',
         'uses' => 
        array (
          'valueobject' => 'Boson\\Shared\\Domain\\ValueObject\\ValueObject',
          'inputvalidator' => 'Boson\\Shared\\Infrastructure\\Security\\InputValidator',
        ),
         'constUses' => 
        array (
        ),
      )),
       'abstract' => false,
       'final' => true,
       'extends' => NULL,
       'implements' => 
      array (
        0 => 'Boson\\Shared\\Domain\\ValueObject\\ValueObject',
      ),
       'usedTraits' => 
      array (
      ),
       'traitUseAdaptations' => 
      array (
      ),
       'statements' => 
      array (
        0 => 
        \PHPStan\Dependency\ExportedNode\ExportedClassConstantsNode::__set_state(array(
           'constants' => 
          array (
            0 => 
            \PHPStan\Dependency\ExportedNode\ExportedClassConstantNode::__set_state(array(
               'name' => 'DRAFT',
               'value' => '\'draft\'',
               'attributes' => 
              array (
              ),
            )),
          ),
           'public' => true,
           'private' => false,
           'final' => false,
           'phpDoc' => NULL,
        )),
        1 => 
        \PHPStan\Dependency\ExportedNode\ExportedClassConstantsNode::__set_state(array(
           'constants' => 
          array (
            0 => 
            \PHPStan\Dependency\ExportedNode\ExportedClassConstantNode::__set_state(array(
               'name' => 'PUBLISHED',
               'value' => '\'published\'',
               'attributes' => 
              array (
              ),
            )),
          ),
           'public' => true,
           'private' => false,
           'final' => false,
           'phpDoc' => NULL,
        )),
        2 => 
        \PHPStan\Dependency\ExportedNode\ExportedClassConstantsNode::__set_state(array(
           'constants' => 
          array (
            0 => 
            \PHPStan\Dependency\ExportedNode\ExportedClassConstantNode::__set_state(array(
               'name' => 'ARCHIVED',
               'value' => '\'archived\'',
               'attributes' => 
              array (
              ),
            )),
          ),
           'public' => true,
           'private' => false,
           'final' => false,
           'phpDoc' => NULL,
        )),
        3 => 
        \PHPStan\Dependency\ExportedNode\ExportedMethodNode::__set_state(array(
           'name' => 'fromString',
           'phpDoc' => NULL,
           'byRef' => false,
           'public' => true,
           'private' => false,
           'abstract' => false,
           'final' => false,
           'static' => true,
           'returnType' => 'self',
           'parameters' => 
          array (
            0 => 
            \PHPStan\Dependency\ExportedNode\ExportedParameterNode::__set_state(array(
               'name' => 'value',
               'type' => 'string',
               'byRef' => false,
               'variadic' => false,
               'hasDefault' => false,
               'attributes' => 
              array (
              ),
            )),
          ),
           'attributes' => 
          array (
          ),
        )),
        4 => 
        \PHPStan\Dependency\ExportedNode\ExportedMethodNode::__set_state(array(
           'name' => 'value',
           'phpDoc' => NULL,
           'byRef' => false,
           'public' => true,
           'private' => false,
           'abstract' => false,
           'final' => false,
           'static' => false,
           'returnType' => 'string',
           'parameters' => 
          array (
          ),
           'attributes' => 
          array (
          ),
        )),
        5 => 
        \PHPStan\Dependency\ExportedNode\ExportedMethodNode::__set_state(array(
           'name' => 'toString',
           'phpDoc' => NULL,
           'byRef' => false,
           'public' => true,
           'private' => false,
           'abstract' => false,
           'final' => false,
           'static' => false,
           'returnType' => 'string',
           'parameters' => 
          array (
          ),
           'attributes' => 
          array (
          ),
        )),
        6 => 
        \PHPStan\Dependency\ExportedNode\ExportedMethodNode::__set_state(array(
           'name' => 'equals',
           'phpDoc' => NULL,
           'byRef' => false,
           'public' => true,
           'private' => false,
           'abstract' => false,
           'final' => false,
           'static' => false,
           'returnType' => 'bool',
           'parameters' => 
          array (
            0 => 
            \PHPStan\Dependency\ExportedNode\ExportedParameterNode::__set_state(array(
               'name' => 'other',
               'type' => '?Boson\\Shared\\Domain\\ValueObject\\ValueObject',
               'byRef' => false,
               'variadic' => false,
               'hasDefault' => false,
               'attributes' => 
              array (
              ),
            )),
          ),
           'attributes' => 
          array (
          ),
        )),
        7 => 
        \PHPStan\Dependency\ExportedNode\ExportedMethodNode::__set_state(array(
           'name' => '__toString',
           'phpDoc' => NULL,
           'byRef' => false,
           'public' => true,
           'private' => false,
           'abstract' => false,
           'final' => false,
           'static' => false,
           'returnType' => 'string',
           'parameters' => 
          array (
          ),
           'attributes' => 
          array (
          ),
        )),
        8 => 
        \PHPStan\Dependency\ExportedNode\ExportedMethodNode::__set_state(array(
           'name' => 'isDraft',
           'phpDoc' => NULL,
           'byRef' => false,
           'public' => true,
           'private' => false,
           'abstract' => false,
           'final' => false,
           'static' => false,
           'returnType' => 'bool',
           'parameters' => 
          array (
          ),
           'attributes' => 
          array (
          ),
        )),
        9 => 
        \PHPStan\Dependency\ExportedNode\ExportedMethodNode::__set_state(array(
           'name' => 'isPublished',
           'phpDoc' => NULL,
           'byRef' => false,
           'public' => true,
           'private' => false,
           'abstract' => false,
           'final' => false,
           'static' => false,
           'returnType' => 'bool',
           'parameters' => 
          array (
          ),
           'attributes' => 
          array (
          ),
        )),
        10 => 
        \PHPStan\Dependency\ExportedNode\ExportedMethodNode::__set_state(array(
           'name' => 'isArchived',
           'phpDoc' => NULL,
           'byRef' => false,
           'public' => true,
           'private' => false,
           'abstract' => false,
           'final' => false,
           'static' => false,
           'returnType' => 'bool',
           'parameters' => 
          array (
          ),
           'attributes' => 
          array (
          ),
        )),
      ),
       'attributes' => 
      array (
      ),
    )),
  ),
  '/home/dan/Desktop/08/apache-htmx/src/Blog/Domain/ValueObject/ArticleTitle.php' => 
  array (
    0 => 
    \PHPStan\Dependency\ExportedNode\ExportedClassNode::__set_state(array(
       'name' => 'Boson\\Blog\\Domain\\ValueObject\\ArticleTitle',
       'phpDoc' => 
      \PHPStan\Dependency\ExportedNode\ExportedPhpDocNode::__set_state(array(
         'phpDocString' => '/**
 * Article Title Value Object
 */',
         'namespace' => 'Boson\\Blog\\Domain\\ValueObject',
         'uses' => 
        array (
          'valueobject' => 'Boson\\Shared\\Domain\\ValueObject\\ValueObject',
          'inputvalidator' => 'Boson\\Shared\\Infrastructure\\Security\\InputValidator',
        ),
         'constUses' => 
        array (
        ),
      )),
       'abstract' => false,
       'final' => true,
       'extends' => NULL,
       'implements' => 
      array (
        0 => 'Boson\\Shared\\Domain\\ValueObject\\ValueObject',
      ),
       'usedTraits' => 
      array (
      ),
       'traitUseAdaptations' => 
      array (
      ),
       'statements' => 
      array (
        0 => 
        \PHPStan\Dependency\ExportedNode\ExportedMethodNode::__set_state(array(
           'name' => 'fromString',
           'phpDoc' => NULL,
           'byRef' => false,
           'public' => true,
           'private' => false,
           'abstract' => false,
           'final' => false,
           'static' => true,
           'returnType' => 'self',
           'parameters' => 
          array (
            0 => 
            \PHPStan\Dependency\ExportedNode\ExportedParameterNode::__set_state(array(
               'name' => 'value',
               'type' => 'string',
               'byRef' => false,
               'variadic' => false,
               'hasDefault' => false,
               'attributes' => 
              array (
              ),
            )),
          ),
           'attributes' => 
          array (
          ),
        )),
        1 => 
        \PHPStan\Dependency\ExportedNode\ExportedMethodNode::__set_state(array(
           'name' => 'value',
           'phpDoc' => NULL,
           'byRef' => false,
           'public' => true,
           'private' => false,
           'abstract' => false,
           'final' => false,
           'static' => false,
           'returnType' => 'string',
           'parameters' => 
          array (
          ),
           'attributes' => 
          array (
          ),
        )),
        2 => 
        \PHPStan\Dependency\ExportedNode\ExportedMethodNode::__set_state(array(
           'name' => 'toString',
           'phpDoc' => NULL,
           'byRef' => false,
           'public' => true,
           'private' => false,
           'abstract' => false,
           'final' => false,
           'static' => false,
           'returnType' => 'string',
           'parameters' => 
          array (
          ),
           'attributes' => 
          array (
          ),
        )),
        3 => 
        \PHPStan\Dependency\ExportedNode\ExportedMethodNode::__set_state(array(
           'name' => 'equals',
           'phpDoc' => NULL,
           'byRef' => false,
           'public' => true,
           'private' => false,
           'abstract' => false,
           'final' => false,
           'static' => false,
           'returnType' => 'bool',
           'parameters' => 
          array (
            0 => 
            \PHPStan\Dependency\ExportedNode\ExportedParameterNode::__set_state(array(
               'name' => 'other',
               'type' => '?Boson\\Shared\\Domain\\ValueObject\\ValueObject',
               'byRef' => false,
               'variadic' => false,
               'hasDefault' => false,
               'attributes' => 
              array (
              ),
            )),
          ),
           'attributes' => 
          array (
          ),
        )),
        4 => 
        \PHPStan\Dependency\ExportedNode\ExportedMethodNode::__set_state(array(
           'name' => '__toString',
           'phpDoc' => NULL,
           'byRef' => false,
           'public' => true,
           'private' => false,
           'abstract' => false,
           'final' => false,
           'static' => false,
           'returnType' => 'string',
           'parameters' => 
          array (
          ),
           'attributes' => 
          array (
          ),
        )),
      ),
       'attributes' => 
      array (
      ),
    )),
  ),
); },
];
