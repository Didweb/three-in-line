<?php

declare(strict_types=1);

namespace App\Domain\Services\Watcher;


final class WatchRow extends Watcher
{
    public function __construct(string $prefixEnemies, string $prefixAllies, int $totalColumns)
    {
        parent::__construct($prefixEnemies, $prefixAllies, $totalColumns);
        $this->rating = 0;
    }

    public function watching(): int
    {
        for ($nPositionColumn = 0; $nPositionColumn <= $this->totalColumns; $nPositionColumn++) {
            $this->isEnemies($this->keyRowLoop, $nPositionColumn);

            $this->isAllies($this->keyRowLoop, $nPositionColumn);
        }

        $this->fullOfEnemies();

        $this->isThereAnyAlliedNoEnemies();

        $this->isThereAnyEnemy();

        $this->lockedAreAlliesAndEnemies();

        $this->resetEnemiesAndAllies();


        return $this->rating;
    }
}