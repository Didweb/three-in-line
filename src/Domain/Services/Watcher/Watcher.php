<?php

declare(strict_types=1);

namespace App\Domain\Services\Watcher;


use App\Domain\Model\Board;

abstract class Watcher
{
    protected int $humans;
    protected int $robots;
    protected string $prefixHuman;
    protected string $prefixRobot;
    protected int $totalColumns;
    protected int $rating;
    protected int $keyRowLoop;
    protected int $keyColumnLoop;
    protected array $cells;
    protected string $winner = "0";



    public function __construct(Board $board)
    {
        $this->prefixHuman = $board->prefixHuman();
        $this->prefixRobot  = $board->prefixRobot();
        $this->totalColumns  = $board->totalColumns();
        $this->humans = 0;
        $this->robots  = 0;
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


    public function isHuman(int $nPositionRow, int $nPositionColumn):void
    {
        if ((string)$this->cells[$nPositionRow][$nPositionColumn]['content'] == $this->prefixHuman) {
            $this->humans = $this->humans + 1;
        }

    }

    public function isRobot(int $nPositionRow, int $nPositionColumn): void
    {
        if ((string)$this->cells[$nPositionRow][$nPositionColumn]['content'] == $this->prefixRobot) {
            $this->robots = $this->robots + 1;
        }
    }

    public function fullOfHumans(): void
    {
        if ($this->humans >= $this->totalColumns) {
            $this->rating = $this->rating + 100;
        }
    }

    public function isThereAnyRobotNoHuman(): void
    {
        if (($this->robots > 0) && ($this->humans <= 0)) {
            $this->rating = $this->rating + 5;
        }
    }

    public function isThereAnyHuman(): void
    {
        if (($this->robots <= 0) && ($this->humans > 0)) {
            $this->rating = $this->rating + 5;
        }
    }

    public function lockedAreRobotsAndHumans(): void
    {
        if (($this->robots > 0) && ($this->humans > 0)) {
            $this->rating = 0;
        }
    }

    public function RobotCanWin(): void
    {
        if ($this->robots >= $this->totalColumns
            && $this->humans == 0 ) {
            $this->rating = $this->rating + 1000;
            $this->theWinnerIs($this->prefixRobot);
        }
    }

    public function HumanCanWin(): void
    {

        if ($this->humans >= $this->totalColumns
            && $this->robots == 0 ) {
            $this->theWinnerIs($this->prefixHuman);
        }
    }

    public function theWinnerIs(string $winner): void
    {
        $this->winner = $winner;
    }

    public function resetHumansAndRobots(): void
    {
        $this->humans = 0;
        $this->robots = 0;
    }

    public function countHumansRobotsDiagonalFirst(): void
    {
        for ($nPosition = 0; $nPosition < $this->totalColumns + 1; $nPosition++) {

            $this->isHuman($nPosition, $nPosition);

            $this->isRobot($nPosition, $nPosition);
        }
    }

    public function countHumansRobotsDiagonalSecond(): void
    {
        $loop = 0;

        for ($nPosition = $this->totalColumns; $nPosition >= 0; $nPosition--) {
            if (($this->keyColumnLoop == $nPosition) == ($this->keyRowLoop == $loop)) {
                $this->isHuman($nPosition, $loop);

                $this->isRobot($nPosition, $loop);
            }
            $loop++;
        }
    }

    public function countHumansRobotsRow(): void
    {
        for ($nPositionColumn = 0; $nPositionColumn <= $this->totalColumns; $nPositionColumn++) {
            $this->isHuman($this->keyRowLoop, $nPositionColumn);

            $this->isRobot($this->keyRowLoop, $nPositionColumn);
        }
    }

    public function countHumansRobotsColumn(): void
    {
        for ($nPositionColumn = 0; $nPositionColumn <= $this->totalColumns; $nPositionColumn++) {
            $this->isHuman($nPositionColumn, $this->keyColumnLoop);

            $this->isRobot($nPositionColumn, $this->keyColumnLoop);
        }
    }
}