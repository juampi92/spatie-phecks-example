<?php

namespace Phecks\Checks\Routes;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Juampi92\Phecks\Domain\Contracts\Check;
use Juampi92\Phecks\Domain\DTOs\FileMatch;
use Juampi92\Phecks\Domain\MatchCollection;
use Juampi92\Phecks\Domain\Sources\RouteCommandSource;
use Juampi92\Phecks\Domain\Violations\ViolationBuilder;

class PublicFacingUrlsMustUseKebabCaseCheck implements Check
{
    private const EXCLUDE = [
        'api/',
        'telescope/',
        '_debugbar/',
        '_ignition/',
    ];

    public function __construct(
        private readonly RouteCommandSource $source
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
            ->run()
            ->reject(fn (array $routeInfo): bool => $this->shouldBeExcluded($routeInfo['uri']));
    }

    /**
     * Process here the output of the method getMatches.
     * This method must return an array of ViolationBuilder instances.
     * Ignore the match returning an empty array.
     *
     * @param  array{name: string, uri: string}  $match
     * @param  FileMatch  $file
     * @return array<ViolationBuilder>
     */
    public function processMatch($match, FileMatch $file): array
    {
        $violations = $this->getSegments($match['uri'])
            ->reject(
                fn (string $urlSegment) => Str::of($urlSegment)
                    ->camel()->kebab()
                    ->value() === $urlSegment
            );

        if ($violations->isEmpty()) {
            return [];
        }

        return $violations
            ->map(fn (string $segment) => ViolationBuilder::make()
                    ->message("The url segment '{$segment}' must be in kebab-case."),
            )
            ->all();
    }

    private function shouldBeExcluded(string $uri): bool
    {
        $uri = Str::of($uri)->finish('/');

        return $uri->startsWith(self::EXCLUDE);
    }

    /**
     * @param  string  $uri
     * @return Collection<string>
     */
    private function getSegments(string $uri): Collection
    {
        return Str::of($uri)
            ->replaceMatches('/\{([^}.])*}/', '')
            ->explode('/');
    }
}
