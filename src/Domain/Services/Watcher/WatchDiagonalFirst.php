<?php

declare(strict_types=1);

namespace App\Domain\Services\Watcher;


final class WatchDiagonalFirst extends Watcher
{


    public function __construct(string $prefixEnemies, string $prefixAllies, int $totalColumns)
    {
        parent::__construct($prefixEnemies,  $prefixAllies, $totalColumns);
        $this->rating = 0;
    }

    public function watching(): int
    {

        for ($nPosition = 0; $nPosition < $this->totalColumns + 1; $nPosition++) {

            if (($this->keyRowLoop != $nPosition) != ($this->keyColumnLoop != $nPosition)) {
                $this->resetEnemiesAndAllies();
                return 0;
            }

            $this->isEnemies($nPosition, $nPosition);

            $this->isAllies($nPosition, $nPosition);
        }

        $this->fullOfEnemies();

        $this->isThereAnyAlliedNoEnemies();

        $this->isThereAnyEnemy();

        $this->lockedAreAlliesAndEnemies();

        $this->ICanWin();

        return $this->rating;
    }
}