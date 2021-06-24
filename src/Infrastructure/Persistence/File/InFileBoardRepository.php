<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\File;


use App\Domain\Model\Board;
use App\Domain\Repository\BoardRepository;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class InFileBoardRepository implements BoardRepository
{
    const PATH_DIR_SOURCES = __DIR__.'/Sources/';
    const PATH_SOURCES = __DIR__.'/Sources/Board.yml';


    public function save(Board $board): void
    {
        $yaml = Yaml::dump($board->toArray());
        file_put_contents(self::PATH_SOURCES, $yaml);
    }


    public function getBoardData(): Board
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

        return new Board(
            $result['board']['prefixHuman'],
            $result['board']['prefixRobot'],
            $result['board']['gameIsActive'],
            $result['board']['rows'],
            $result['board']['columns'],
            $result['board']['cells']
        );
    }

    public function createFileData(): void
    {
        if (!file_exists(self::PATH_SOURCES)) {
            $board = new Board();
            $yaml = Yaml::dump($board->toArray());
            file_put_contents(self::PATH_SOURCES, $yaml);
        }
    }
}