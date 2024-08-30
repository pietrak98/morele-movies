<?php

use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\CodingStyle\Rector\FuncCall\CountArrayToEmptyArrayComparisonRector;
use Rector\CodingStyle\Rector\String_\SymplifyQuoteEscapeRector;
use Rector\CodingStyle\Rector\Use_\SeparateMultiUseImportsRector;
use Rector\Config\RectorConfig;
use Rector\Doctrine\Set\DoctrineSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Symfony\Set\SymfonySetList;

return RectorConfig::configure()
    ->withSymfonyContainerXml(__DIR__.DIRECTORY_SEPARATOR.'var'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'dev'.DIRECTORY_SEPARATOR.'App_KernelDevDebugContainer.xml')
    ->withCache(DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'rector', FileCacheStorage::class)
    ->withPaths([
        __DIR__.DIRECTORY_SEPARATOR.'src',
    ])
    ->withImportNames(true, true, false)
    ->withSets(
        [
            SetList::CODING_STYLE,
            SetList::CODE_QUALITY,
            SetList::PRIVATIZATION,
            SetList::TYPE_DECLARATION,
            SetList::EARLY_RETURN,
            SetList::INSTANCEOF,

            SymfonySetList::SYMFONY_CODE_QUALITY,
            SymfonySetList::SYMFONY_64,
            SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION,
            LevelSetList::UP_TO_PHP_80,
            LevelSetList::UP_TO_PHP_81,
            LevelSetList::UP_TO_PHP_82,
            LevelSetList::UP_TO_PHP_83,

            DoctrineSetList::DOCTRINE_CODE_QUALITY,
        ]
    )
    ->withRules([
    ])
    ->withSkip([
        SeparateMultiUseImportsRector::class,
        CountArrayToEmptyArrayComparisonRector::class,
        SymplifyQuoteEscapeRector::class,
    ]);
