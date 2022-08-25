<?php

namespace Phecks\Checks\Config;

use Illuminate\Support\Str;
use Juampi92\Phecks\Domain\Contracts\Check;
use Juampi92\Phecks\Domain\DTOs\FileMatch;
use Juampi92\Phecks\Domain\MatchCollection;
use Juampi92\Phecks\Domain\Sources\FileSource;
use Juampi92\Phecks\Domain\Violations\ViolationBuilder;

/**
 * @implements Check<FileMatch>
 */
class ConfigFilesMustUseRightCaseCheck implements Check
{
    private const IGNORED_CONFIGS = [
        // List here your exceptions: (packages for example)
    ];

    public function __construct(
        private FileSource $source
    ) {
    }

    /**
     * @return MatchCollection<FileMatch>
     */
    public function getMatches(): MatchCollection
    {
        return $this->source
            ->directory('./config')
            ->run()
            ->reject(fn (FileMatch $match) => in_array(
                pathinfo($match->file)['filename'],
                self::IGNORED_CONFIGS
            ));
    }

    /**
     * @param  FileMatch  $match
     * @return array<ViolationBuilder>
     */
    public function processMatch($match, FileMatch $file): array
    {
        $filename = pathinfo($match->file)['filename'];
        $filenameKebab = Str::of($filename)->camel()->kebab()->value();

        if ($filenameKebab === $filename) {
            // File is already in kebab-case
            return [];
        }

        return [
            ViolationBuilder::make()
                ->message("Config files must be in kebab-case. Please rename to {$filenameKebab}"),
        ];
    }
}
