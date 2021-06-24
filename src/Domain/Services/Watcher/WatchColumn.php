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
        $this->countEnemiesAlliesColumn();

        $this->fullOfEnemies();

        $this->isThereAnyAlliedNoEnemies();

        $this->isThereAnyEnemy();

        $this->lockedAreAlliesAndEnemies();

        $this->ICanWin();

        $this->resetEnemiesAndAllies();

        return $this->rating;
    }
}