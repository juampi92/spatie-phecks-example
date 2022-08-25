<?php

namespace Phecks\Checks\Artisan;

use Illuminate\Support\Str;
use Juampi92\Phecks\Domain\Contracts\Check;
use Juampi92\Phecks\Domain\DTOs\FileMatch;
use Juampi92\Phecks\Domain\MatchCollection;
use Juampi92\Phecks\Domain\Sources\ArtisanListSource;
use Juampi92\Phecks\Domain\Sources\ValueObjects\ArtisanCommandInfo;
use Juampi92\Phecks\Domain\Violations\ViolationBuilder;
use Phecks\Support\StringCase;

/**
 * @implements Check<ArtisanCommandInfo>
 */
class CommandNamesShouldUseKebabCaseCheck implements Check
{
    public function __construct(
        private readonly ArtisanListSource $source
    ) {}

    /**
     * Use a Source to find matches.
     * You can filter, reject and
     *
     * @return MatchCollection
     */
    public function getMatches(): MatchCollection
    {
        return $this->source->run();
    }

    /**
     * Process here the output of the method getMatches.
     * This method must return an array of ViolationBuilder instances.
     * Ignore the match returning an empty array.
     *
     * @param ArtisanCommandInfo $match
     * @param FileMatch $file
     * @return array<ViolationBuilder>
     */
    public function processMatch($match, FileMatch $file): array
    {
        $sections = Str::of($match->name)->explode(':');

        if ($sections->every(fn (string $section) => StringCase::of($section)->isKebabCase())) {
            return [];
        }

        return [
            ViolationBuilder::make()->message("The signature '{$match->name}' must use kebab-case."),
        ];
    }
}
