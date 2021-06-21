<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Model\Board;
use App\Domain\Services\Watcher\WatcherFactory;

final class Intelligence
{
    private array $cellsCheck;
    private int $winIn;

    public function bestOption(Board $board): ?array
    {
        $board->cleanValuesCells();
        $this->winIn = count($board->cells());
        $cellsOptions = $this->currentRatings($board->cells());
        $board->updateRatingsCells($this->cellsCheck);
        $randOption = rand(0, count($cellsOptions) - 1);

        if (!isset($cellsOptions[$randOption])) {
            return null;
        }
        return [
            'row' => $cellsOptions[$randOption]['row'],
            'column' => $cellsOptions[$randOption]['column']
        ];
    }


    private function currentRatings($cells): array
    {
        $loop = 0;
        $highestScore = 0;
        $totalColumns = count($cells) - 1;

        $watcherData = [
            'prefixEnemies' => 'H',
            'prefixAllies' => 'R',
            'totalColumns' => $totalColumns
        ];

        foreach ($cells as $keyRow => $column) {
            foreach ($column as $keyColumn => $value) {
                $currentRating = $cells[$keyRow][$keyColumn]['rating'];


                $watcherDiagonalFirst = WatcherFactory::createrWatcher('WatchDiagonalFirst', $watcherData);
                $watcherDiagonalFirst->data($keyRow, $keyColumn, $cells);

                $watcherDiagonalSecond = WatcherFactory::createrWatcher('WatchDiagonalSecond', $watcherData);
                $watcherDiagonalSecond->data($keyRow, $keyColumn, $cells);

                $watcherRow = WatcherFactory::createrWatcher('WatchRow', $watcherData);
                $watcherRow->data($keyRow, $keyColumn, $cells);

                $watcherColumn = WatcherFactory::createrWatcher('WatchColumn', $watcherData);
                $watcherColumn->data($keyRow, $keyColumn, $cells);


                $currentRating = $currentRating + $watcherDiagonalFirst->watching();
                $currentRating = $currentRating + $watcherDiagonalSecond->watching();
                $currentRating = $currentRating + $watcherRow->watching();
                $currentRating = $currentRating + $watcherColumn->watching();


                $cells[$keyRow][$keyColumn]['rating'] = $this->ratingForOnnlyVOidCells($cells[$keyRow][$keyColumn], $currentRating);

                if ($currentRating > $highestScore
                    && (string)$cells[$keyRow][$keyColumn]['content'] == "0") {
                    $highestScore = $currentRating;
                }
            }

            $loop++;
        }

        return $this->candidates($cells, $highestScore);
    }


    private function ratingForOnnlyVOidCells(array $cell, int $currentRating): int
    {
        return ((int)$cell['content'] == 0) ? $currentRating : 0;
    }

    private function candidates(array $cells, int $highestScore): array
    {
        $candidates = [];

        $this->cellsCheck = $cells;

        foreach ($cells as $row => $column) {
            foreach ($column as $keyColumn => $value) {
                if ($cells[$row][$keyColumn]['rating'] == $highestScore
                    && $cells[$row][$keyColumn]['content'] === 0) {
                    $candidates[] = ['row' => $row, 'column' => $keyColumn];
                }
            }
        }
        dump($candidates);
        return $candidates;
    }
}