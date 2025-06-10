<?php

use CodelyTv\CodingStyle;
use PhpCsFixer\Fixer\ClassNotation\FinalClassFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([__DIR__ . '/src']);

    $ecsConfig->sets([CodingStyle::DEFAULT]);

    $ecsConfig->skip([
        FinalClassFixer::class => [
            __DIR__ . '/src/Shared/Types/Domain/',
        ],
        \PhpCsFixer\Fixer\ClassNotation\SelfStaticAccessorFixer::class => [
            __DIR__ . '/src/Shared/Types/Domain/',
        ],
    ]);
};