<?php

declare(strict_types=1);

namespace App\Domain\Services\Watcher;


abstract class Watcher
{
    protected int $enemies;
    protected int $allies;
    protected string $prefixEnemies;
    protected string $prefixAllies;
    protected int $totalColumns;
    protected int $rating;
    protected int $keyRowLoop;
    protected int $keyColumnLoop;
    private array $cells;

    public function __construct(string $prefixEnemies, string $prefixAllies, int $totalColumns)
    {
        $this->prefixEnemies = $prefixEnemies;
        $this->prefixAllies = $prefixAllies;
        $this->totalColumns = $totalColumns;
        $this->enemies = 0;
        $this->allies = 0;
    }

    abstract protected function watching(): int;


    public function data(int $keyRowLoop, int $keyColumnLoop, array $cells): void
    {
        $this->keyRowLoop = $keyRowLoop;
        $this->keyColumnLoop = $keyColumnLoop;
        $this->cells = $cells;
    }


    public function isEnemies(int $nPositionRow, int $nPositionColumn):void
    {
        if ((string)$this->cells[$nPositionRow][$nPositionColumn]['content'] == $this->prefixEnemies) {
            $this->enemies = $this->enemies + 1;
            dump('SUMO!!!! '.$nPositionRow.'/'.$nPositionRow);
            dump($this->cells[$nPositionRow][$nPositionColumn]['content']);
            dump('prefixenemis: '.$this->prefixEnemies);
        }

    }

    public function isAllies(int $nPositionRow, int $nPositionColumn): void
    {
        if ((string)$this->cells[$nPositionRow][$nPositionColumn]['content'] == $this->prefixAllies) {
            $this->allies = $this->allies + 1;
        }
    }


    public function responseData(): array
    {
        return [
            'enemies' => $this->enemies,
            'allies' => $this->allies,
            'rating' => $this->rating,
        ];
    }

    public function resetEnemiesAndAllies(): void
    {
        $this->enemies = 0;
        $this->allies = 0;
    }

}