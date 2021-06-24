<?php

declare(strict_types=1);

namespace App\Domain\Services\Watcher;


use App\Domain\Model\Board;

final class WatchRow extends Watcher
{
    public function __construct(Board $board)
    {
        parent::__construct($board);
        $this->rating = 0;
    }

    public function watching(): int
    {
        $this->countHumansRobotsRow();

        $this->fullOfHumans();

        $this->isThereAnyRobotNoHuman();

        $this->isThereAnyHuman();

        $this->lockedAreRobotsAndHumans();

        $this->RobotCanWin();

        return $this->rating;
    }
}