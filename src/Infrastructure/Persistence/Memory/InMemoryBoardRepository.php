<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Memory;


use App\Application\Command\BoardCommand;
use App\Domain\Repository\BoardRepository;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

final class InMemoryBoardRepository implements BoardRepository
{
    const PATH_DIR_SOURCES = __DIR__.'/Sources/';
    const PATH_SOURCES = __DIR__.'/Sources/Board.yml';

    private BoardCommand $boardCommand;




    public function getBoardData(): array
    {
        $result = [];
        $this->createFileData();

        $finder = new Finder();
        $finder->files()->in(self::PATH_DIR_SOURCES);
        if ($finder->hasResults()) {
            foreach ($finder as $file) {
                $config = Yaml::parseFile($file->getRealPath());
                $result['board'] = reset($config);
            }
        }

        return $result;
    }

    public function createFileData(): void
    {
        if (!file_exists(self::PATH_SOURCES)) {

            $yaml = Yaml::dump($this->boardCommand->toArray());
            file_put_contents(self::PATH_SOURCES, $yaml);
        }
    }
}