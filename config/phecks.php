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
        Checks\Config\ConfigFilesMustUseRightCaseCheck::class,
        Checks\Config\ConfigKeysMustUseRightCaseCheck::class,
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
