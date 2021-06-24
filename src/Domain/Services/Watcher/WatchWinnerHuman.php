<?php

declare(strict_types=1);

namespace App\Domain\Services\Watcher;

use App\Domain\Model\Board;

final class WatchWinnerHuman extends Watcher
{

    public function __construct(Board $board)
    {
        parent::__construct($board);
        $this->rating = 0;

    }

    public function watching(): int
    {
        $this->countHumansRobotsDiagonalFirst();
        $this->HumanCanWin();

        $this->countHumansRobotsDiagonalSecond();
        $this->HumanCanWin();

        $this->countHumansRobotsRow();
        $this->HumanCanWin();

        $this->countHumansRobotsColumn();
        $this->HumanCanWin();

        return 0;
    }
}