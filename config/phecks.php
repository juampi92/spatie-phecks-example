<?php

use Phecks\Checks;

return [
    /*
    |--------------------------------------------------------------------------
    | Checks
    |--------------------------------------------------------------------------
    |
    | List of Checks that will run on the current repository.
    | Feel free to group checks in sub-folders.
    |
    */

    'checks' => [
        Checks\Artisan\CommandNamesShouldUseKebabCaseCheck::class,
        Checks\Config\ConfigFilesMustUseRightCaseCheck::class,
        Checks\Config\ConfigKeysMustUseRightCaseCheck::class,
        Checks\Console\ConsoleClassesMustBeSuffixedWithCommandCheck::class,
        Checks\Controllers\ControllerMethodsMustStickToCrudCheck::class,
        Checks\Routes\PublicFacingUrlsMustUseKebabCaseCheck::class,
        Checks\Routes\RouteNamesMustUseCamelCaseCheck::class,
        Checks\Routes\RouteParametersMustUseCamelCaseCheck::class,
        Checks\Views\ViewFilesMustUseCamelCaseCheck::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Baseline
    |--------------------------------------------------------------------------
    |
    | Where the baseline is located.
    |
    */

    'baseline' => '.phecks.baseline.json',
];
