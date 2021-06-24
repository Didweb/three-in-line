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
    protected array $cells;
    protected string $winner = "0";



    public function __construct(string $prefixEnemies, string $prefixAllies, int $totalColumns)
    {
        $this->prefixEnemies = $prefixEnemies;
        $this->prefixAllies = $prefixAllies;
        $this->totalColumns = $totalColumns;
        $this->enemies = 0;
        $this->allies = 0;
    }

    abstract protected function watching(): int;

    public function winner(): string
    {
        return $this->winner;
    }


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
        }

    }

    public function isAllies(int $nPositionRow, int $nPositionColumn): void
    {
        if ((string)$this->cells[$nPositionRow][$nPositionColumn]['content'] == $this->prefixAllies) {
            $this->allies = $this->allies + 1;
        }
    }

    public function fullOfEnemies($pos = '?'): void
    {
        if ($this->enemies >= $this->totalColumns) {
            $this->rating = $this->rating + 100;
        }
    }

    public function isThereAnyAlliedNoEnemies(): void
    {
        if (($this->allies > 0) && ($this->enemies <= 0)) {
            $this->rating = $this->rating + 5;
        }
    }

    public function isThereAnyEnemy(): void
    {
        if (($this->allies <= 0) && ($this->enemies > 0)) {
            $this->rating = $this->rating + 5;
        }
    }

    public function lockedAreAlliesAndEnemies(): void
    {
        if (($this->allies > 0) && ($this->enemies > 0)) {
            $this->rating = 0;
        }
    }

    public function ICanWin(): void
    {
        if ($this->allies >= $this->totalColumns
            && $this->enemies == 0 ) {
            $this->rating = $this->rating + 1000;
            $this->theWinnerIs($this->prefixAllies);
        }
    }

    public function HumanCanWin(): void
    {

        if ($this->allies >= $this->totalColumns
            && $this->enemies == 0 ) {
            $this->theWinnerIs($this->prefixAllies);
        }
    }

    public function theWinnerIs(string $winner): void
    {
        $this->winner = $winner;
    }

    public function resetEnemiesAndAllies(): void
    {
        $this->enemies = 0;
        $this->allies = 0;
    }

    public function countEnemiesAlliesDiagonalFirst(): void
    {
        for ($nPosition = 0; $nPosition < $this->totalColumns + 1; $nPosition++) {

            $this->isEnemies($nPosition, $nPosition);

            $this->isAllies($nPosition, $nPosition);
        }
    }

    public function countEnemiesAlliesDiagonalSecond(): void
    {
        $loop = 0;

        for ($nPosition = $this->totalColumns; $nPosition >= 0; $nPosition--) {
            if (($this->keyColumnLoop == $nPosition) == ($this->keyRowLoop == $loop)) {
                $this->isEnemies($nPosition, $loop);

                $this->isAllies($nPosition, $loop);
            }
            $loop++;
        }
    }

    public function countEnemiesAlliesRow(): void
    {
        for ($nPositionColumn = 0; $nPositionColumn <= $this->totalColumns; $nPositionColumn++) {
            $this->isEnemies($this->keyRowLoop, $nPositionColumn);

            $this->isAllies($this->keyRowLoop, $nPositionColumn);
        }
    }

    public function countEnemiesAlliesColumn(): void
    {
        for ($nPositionColumn = 0; $nPositionColumn <= $this->totalColumns; $nPositionColumn++) {
            $this->isEnemies($nPositionColumn, $this->keyColumnLoop);

            $this->isAllies($nPositionColumn, $this->keyColumnLoop);
        }
    }
}