<?php

namespace Phecks\Checks\Routes;

use Illuminate\Support\Str;
use Juampi92\Phecks\Domain\Contracts\Check;
use Juampi92\Phecks\Domain\DTOs\FileMatch;
use Juampi92\Phecks\Domain\MatchCollection;
use Juampi92\Phecks\Domain\Sources\RouteCommandSource;
use Juampi92\Phecks\Domain\Sources\ValueObjects\RouteInfo;
use Juampi92\Phecks\Domain\Violations\ViolationBuilder;

/**
 * @implements Check<RouteInfo>
 */
class RouteNamesMustUseCamelCaseCheck implements Check
{
    private const EXCLUDE = [
        'sanctum.*',
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
            ->reject(fn (RouteInfo $routeInfo) => empty($routeInfo->name))
            ->reject(
                fn (RouteInfo $route): bool => collect(self::EXCLUDE)
                    ->contains(fn ($pattern) => Str::is($pattern, $route->name ?: ''))
            );
    }

    /**
     * @param  RouteInfo  $match
     * @return array<ViolationBuilder>
     */
    public function processMatch($match, FileMatch $file): array
    {
        $violations = Str::of($match->name ?: '')
            ->explode('.')
            ->reject(fn (string $segment): bool => Str::of($segment)->camel()->value() === $segment);

        return $violations
            ->map(fn (string $segment) => ViolationBuilder::make()
                    ->message("The route name segment '{$segment}' must use camelCase.")
            )
            ->all();
    }
}
