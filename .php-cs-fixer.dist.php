<?php

use PhpCsFixerCustomFixers\Fixer\ConstructorEmptyBracesFixer;
use PhpCsFixerCustomFixers\Fixer\EmptyFunctionBodyFixer;
use PhpCsFixerCustomFixers\Fixer\MultilinePromotedPropertiesFixer;
use PhpCsFixerCustomFixers\Fixer\NoPhpStormGeneratedCommentFixer;
use PhpCsFixerCustomFixers\Fixer\ReadonlyPromotedPropertiesFixer;
use PhpCsFixerCustomFixers\Fixer\SingleSpaceAfterStatementFixer;
use PhpCsFixerCustomFixers\Fixer\StringableInterfaceFixer;

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__.DIRECTORY_SEPARATOR.'src');

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->registerCustomFixers(new PhpCsFixerCustomFixers\Fixers())
    ->setRules([
        '@Symfony' => true,
        'phpdoc_separation' => false,
        'declare_strict_types' => true,
        MultilinePromotedPropertiesFixer::name() => true,
        ConstructorEmptyBracesFixer::name() => true,
        EmptyFunctionBodyFixer::name() => true,
        NoPhpStormGeneratedCommentFixer::name() => true,
        ReadonlyPromotedPropertiesFixer::name() => true,
        SingleSpaceAfterStatementFixer::name() => true,
        StringableInterfaceFixer::name() => true,
    ])
    ->setFinder($finder);
