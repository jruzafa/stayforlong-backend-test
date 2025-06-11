<?php

use CodelyTv\CodingStyle;
use PhpCsFixer\Fixer\ClassNotation\FinalClassFixer;
use PhpCsFixer\Fixer\ClassNotation\SelfStaticAccessorFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([__DIR__ . '/src']);

    $ecsConfig->sets([CodingStyle::ALIGNED]);

    $ecsConfig->skip([
        FinalClassFixer::class => [
            __DIR__ . '/src/Shared/Types/Domain/',
        ],
        SelfStaticAccessorFixer::class => [
            __DIR__ . '/src/Shared/Types/Domain/',
        ],
    ]);
};