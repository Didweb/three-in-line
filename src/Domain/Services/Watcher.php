<?php

declare(strict_types=1);

namespace App\Domain\Services;


final class Watcher
{

    private int $enemies;
    private int $allies;
    private string $prefixEnemies;
    private string $prefixAllies;
    private int $totalColumns;
    private int $rating;
    private int $keyRowLoop;
    private int $keyColumnLoop;
    private array $cells;

    public function __construct(string $prefixEnemies, string $prefixAllies, int $totalColumns)
    {
        $this->prefixEnemies = $prefixEnemies;
        $this->prefixAllies = $prefixAllies;
        $this->totalColumns = $totalColumns;
        $this->enemies = 0;
        $this->allies = 0;
    }

    public function data(int $keyRowLoop, int $keyColumnLoop, array $cells): void
    {
        $this->keyRowLoop = $keyRowLoop;
        $this->keyColumnLoop = $keyColumnLoop;
        $this->cells = $cells;
    }

    public function watchDiagonalFirst(): int
    {
        $this->rating = 0;
        for ($nPosition = 0; $nPosition < $this->totalColumns + 1; $nPosition++) {

            if (($this->keyRowLoop != $nPosition) != ($this->keyColumnLoop != $nPosition)) {
                $this->resetEnemiesAndAllies();
                return 0;
            }

            $this->isEnemies($nPosition, $nPosition);

            $this->isAllies($nPosition, $nPosition);
        }

        if ($this->enemies == $this->totalColumns) {
            $this->rating = $this->rating + 100;
        }


        if (($this->allies > 0) && ($this->enemies <= 0)) {
            $this->rating = $this->rating + 5;
        }

        if (($this->allies > 0) && ($this->enemies > 0)) {
            $this->rating = 0;
        }

        $this->resetEnemiesAndAllies();
        return $this->rating;
    }



    public function isEnemies(int $nPositionRow, int $nPositionColumn):void
    {
        if ($this->cells[$nPositionRow][$nPositionColumn]['content'] == $this->prefixEnemies) {
            $this->enemies = $this->enemies + 1;
        }

    }

    public function isAllies(int $nPositionRow, int $nPositionColumn): void
    {
        if ($this->cells[$nPositionRow][$nPositionColumn]['content'] == $this->prefixAllies) {
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