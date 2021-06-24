<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Model\Board;
use App\Domain\Services\Watcher\WatcherFactory;

final class Intelligence
{
    private array $cellsCheck;
    private Board $board;

    public function __construct(Board $board)
    {
        $this->board = $board;
    }


    public function verificationWinnerHuman(): Board
    {
        $cells = $this->board->cells();

        foreach ($cells as $keyRow => $column) {
            foreach ($column as $keyColumn => $value) {

                $watcherWinnerHuman = WatcherFactory::createrWatcher('WatchWinnerHuman', $this->board);
                $watcherWinnerHuman->data($keyRow, $keyColumn, $cells);
                $watcherWinnerHuman->watching();

            }
        }

        return $this->board;

    }


    public function bestOption(): ?array
    {
        $this->board->cleanValuesCells();
        $cellsOptions = $this->currentRatings();
        $this->board->updateRatingsCells($this->cellsCheck);
        $randOption = rand(0, count($cellsOptions) - 1);

        if (!isset($cellsOptions[$randOption])) {
            return null;
        }
        return [
            'row' => $cellsOptions[$randOption]['row'],
            'column' => $cellsOptions[$randOption]['column']
        ];
    }


    private function currentRatings(): array
    {
        $highestScore = 0;
        $cells = $this->board->cells();

        foreach ($cells as $keyRow => $column) {
            foreach ($column as $keyColumn => $value) {
                $currentRating = $cells[$keyRow][$keyColumn]['rating'];

                $watcherDiagonalFirst = WatcherFactory::createrWatcher('WatchDiagonalFirst', $this->board);
                $watcherDiagonalSecond = WatcherFactory::createrWatcher('WatchDiagonalSecond', $this->board);
                $watcherRow = WatcherFactory::createrWatcher('WatchRow', $this->board);
                $watcherColumn = WatcherFactory::createrWatcher('WatchColumn', $this->board);

                $watcherDiagonalFirst->data($keyRow, $keyColumn, $cells);
                $watcherDiagonalSecond->data($keyRow, $keyColumn, $cells);
                $watcherRow->data($keyRow, $keyColumn, $cells);
                $watcherColumn->data($keyRow, $keyColumn, $cells);


                $currentRating = $currentRating + $watcherDiagonalFirst->watching();
                $this->checkWinner($watcherDiagonalFirst->winner());

                $currentRating = $currentRating + $watcherDiagonalSecond->watching();
                $this->checkWinner($watcherDiagonalSecond->winner());

                $currentRating = $currentRating + $watcherRow->watching();
                $this->checkWinner($watcherRow->winner());

                $currentRating = $currentRating + $watcherColumn->watching();
                $this->checkWinner($watcherColumn->winner());


                $cells[$keyRow][$keyColumn]['rating'] = $this->ratingForOnlyVoidCells($cells[$keyRow][$keyColumn], $currentRating);

                if ($currentRating > $highestScore
                    && (string)$cells[$keyRow][$keyColumn]['content'] == "0") {
                    $highestScore = $currentRating;
                }
            }

        }

        return $this->candidates($cells, $highestScore);
    }


    private function checkWinner($winner): void
    {
        if($winner != "0") {
            $this->board->theWinnerIs($winner);
        }
    }

    private function ratingForOnlyVoidCells(array $cell, int $currentRating): int
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

        return $candidates;
    }
}