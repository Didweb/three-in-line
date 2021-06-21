<?php

declare(strict_types=1);

namespace App\Domain\Services\Watcher;


final class WatchColumn extends Watcher
{
    public function __construct(string $prefixEnemies, string $prefixAllies, int $totalColumns)
    {
        parent::__construct($prefixEnemies, $prefixAllies, $totalColumns);
        $this->rating = 0;
    }

    public function watching(): int
    {
        for ($nPositionColumn = 0; $nPositionColumn <= $this->totalColumns; $nPositionColumn++) {
            $this->isEnemies($nPositionColumn, $this->keyColumnLoop);

            $this->isAllies($nPositionColumn, $this->keyColumnLoop);
        }

        $this->fullOfEnemies();

        $this->isThereAnyAlliedNoEnemies();

        $this->isThereAnyEnemy();

        $this->lockedAreAlliesAndEnemies();

        $this->resetEnemiesAndAllies();


        return $this->rating;
    }
}