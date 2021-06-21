<?php

declare(strict_types=1);

namespace App\Domain\Services\Watcher;


final class WatchDiagonalSecond extends Watcher
{

    public function __construct(string $prefixEnemies, string $prefixAllies, int $totalColumns)
    {
        parent::__construct($prefixEnemies, $prefixAllies, $totalColumns);
        $this->rating = 0;
    }

    public function watching(): int
    {
        $loop = 0;

        for ($nPosition = $this->totalColumns; $nPosition >= 0; $nPosition--) {
            if (($this->keyColumnLoop == $nPosition) == ($this->keyRowLoop == $loop)) {
                $this->isEnemies($nPosition, $loop);

                $this->isAllies($nPosition, $loop);



                $this->fullOfEnemies();

                $this->isThereAnyAlliedNoEnemies();

                $this->isThereAnyEnemy();

                $this->lockedAreAlliesAndEnemies();

                $loop++;
            }
        }
        return $this->rating;
    }
}