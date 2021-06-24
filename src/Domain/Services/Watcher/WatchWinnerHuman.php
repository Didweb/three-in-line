<?php

declare(strict_types=1);

namespace App\Domain\Services\Watcher;


final class WatchWinnerHuman extends Watcher
{



    public function __construct(string $prefixEnemies, string $prefixAllies, int $totalColumns)
    {
        parent::__construct($prefixEnemies,  $prefixAllies, $totalColumns);
        $this->rating = 0;

    }

    public function watching(): int
    {
        $this->countEnemiesAlliesDiagonalFirst();
        $this->HumanCanWin();
        if($this->winner() == $this->prefixAllies) {
            return 1;
        }

        $this->countEnemiesAlliesDiagonalSecond();
        $this->HumanCanWin();
        if($this->winner() == $this->prefixAllies) {
            return 1;
        }

        $this->countEnemiesAlliesRow();
        $this->HumanCanWin();
        if($this->winner() == $this->prefixAllies) {
            return 1;
        }

        $this->countEnemiesAlliesColumn();
        $this->HumanCanWin();
        if($this->winner() == $this->prefixAllies) {
            return 1;
        }
        dump('final=>'.$this->winner());
        dump('final_enemisis=>'.$this->prefixAllies);
        return 0;
    }
}