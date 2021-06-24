<?php

declare(strict_types=1);

namespace App\Domain\Services\Watcher;


use App\Domain\Model\Board;

final class WatchColumn extends Watcher
{
    public function __construct(Board $board)
    {
        parent::__construct($board);
        $this->rating = 0;
    }

    public function watching(): int
    {
        $this->countHumansRobotsColumn();

        $this->fullOfHumans();

        $this->isThereAnyRobotNoHuman();

        $this->isThereAnyHuman();

        $this->lockedAreRobotsAndHumans();

        $this->RobotCanWin();

        $this->resetHumansAndRobots();

        return $this->rating;
    }
}