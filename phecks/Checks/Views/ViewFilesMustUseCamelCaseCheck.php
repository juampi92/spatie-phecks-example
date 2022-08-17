<?php

namespace Phecks\Checks\Views;

use Illuminate\Support\Str;
use Juampi92\Phecks\Domain\Contracts\Check;
use Juampi92\Phecks\Domain\DTOs\FileMatch;
use Juampi92\Phecks\Domain\MatchCollection;
use Juampi92\Phecks\Domain\Sources\FileSource;
use Juampi92\Phecks\Domain\Violations\ViolationBuilder;
use Phecks\Support\StringCase;

/**
 * @implements Check<FileMatch>
 */
class ViewFilesMustUseCamelCaseCheck implements Check
{
    public function __construct(
        private readonly FileSource $source
    ) {
    }

    /**
     * Use a Source to find matches.
     * You can filter, reject and
     *
     * @return MatchCollection
     */
    public function getMatches(): MatchCollection
    {
        return $this->source
            ->directory('./resources/views')
            ->recursive()
            ->run();
    }

    /**
     * Process here the output of the method getMatches.
     * This method must return an array of ViolationBuilder instances.
     * Ignore the match returning an empty array.
     *
     * @param  FileMatch  $match
     * @param  FileMatch  $file
     * @return array<ViolationBuilder>
     */
    public function processMatch($match, FileMatch $file): array
    {
        $file = Str::of(pathinfo($match->file)['filename'])
            ->beforeLast('.blade');

        if (StringCase::of($file)->isCamelCase()) {
            return [];
        }

        return [
            ViolationBuilder::make()
                ->message('View files must use camel case names.'),
        ];
    }
}
