<?php

namespace Phecks\Checks\Console;

use Illuminate\Support\Str;
use Juampi92\Phecks\Domain\Contracts\Check;
use Juampi92\Phecks\Domain\DTOs\FileMatch;
use Juampi92\Phecks\Domain\MatchCollection;
use Juampi92\Phecks\Domain\Pipes\Filters\WhereExtendsClassFilter;
use Juampi92\Phecks\Domain\Sources\ClassSource;
use Juampi92\Phecks\Domain\Violations\ViolationBuilder;
use Roave\BetterReflection\Reflection\ReflectionClass;

/**
 * @implements Check<ReflectionClass>
 */
class ConsoleClassesMustBeSuffixedWithCommandCheck implements Check
{
    public function __construct(
        private readonly ClassSource $source,
    ) {}

    /**
     * This method will get all the possible matches.
     *
     */
    public function getMatches(): MatchCollection
    {
        return $this->source
            ->directory('./app/Console')
            ->run()
            ->reject(fn (ReflectionClass $class): bool => $class->isAbstract())
            ->pipe(new WhereExtendsClassFilter(\Illuminate\Console\Command::class));
    }

    /**
     * processMatch will check if the matches are
     * actual violations, and format them properly.
     *
     * @param ReflectionClass $match
     * @return \Juampi92\Phecks\Domain\Violations\ViolationBuilder[]
     */
    public function processMatch($match, FileMatch $file): array
    {
        if (Str::endsWith($match->getName(), 'Command')) {
            return [];
        }

        return [
            ViolationBuilder::make()->message('Command classes must be suffixed with \'Command\''),
        ];
    }
}
