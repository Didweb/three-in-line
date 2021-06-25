<?php

declare(strict_types=1);

namespace App\Domain\Services\Watcher;


use App\Domain\Model\Board;

final class WatcherFactory
{
    public static function createrWatcher(string $nameWatcher, Board $board) {

        switch($nameWatcher){
            case 'WatchDiagonalFirst':
                return new WatchDiagonalFirst($board);
                break;
            case 'WatchDiagonalSecond':
                return new WatchDiagonalSecond($board);
                break;

            case 'WatchRow':
                return new WatchRow($board);
                break;

            case 'WatchColumn':
                return new WatchColumn($board);
                break;

            case 'WatchWinnerHuman':
                return new WatchWinnerHuman($board);
                break;
        }

    }
}