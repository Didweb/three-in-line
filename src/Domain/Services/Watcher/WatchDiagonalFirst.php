<?php

declare(strict_types=1);

namespace App\Domain\Services\Watcher;


final class WatchDiagonalFirst extends Watcher
{


    public function __construct(string $prefixEnemies, string $prefixAllies, int $totalColumns)
    {
        parent::__construct($prefixEnemies,  $prefixAllies, $totalColumns);
    }

    public function watchDiagonalFirst(): int
    {
        $this->rating = 0;
        for ($nPosition = 0; $nPosition < $this->totalColumns + 1; $nPosition++) {

            if (($this->keyRowLoop != $nPosition) != ($this->keyColumnLoop != $nPosition)) {
                $this->resetEnemiesAndAllies();
                return 0;
            }

            $this->isEnemies($nPosition, $nPosition);

            $this->isAllies($nPosition, $nPosition);
        }

        if ($this->enemies == $this->totalColumns) {
            $this->rating = $this->rating + 100;
        }


        if (($this->allies > 0) && ($this->enemies <= 0)) {
            $this->rating = $this->rating + 5;
        }

        if (($this->allies > 0) && ($this->enemies > 0)) {
            $this->rating = 0;
        }

        $this->resetEnemiesAndAllies();
        return $this->rating;
    }
}