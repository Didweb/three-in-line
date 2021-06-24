<?php

declare(strict_types=1);

namespace App\Domain\Services\Watcher;


final class WatcherFactory
{
    public static function createrWatcher(string $nameWatcher, array $data) {

        switch($nameWatcher){
            case 'WatchDiagonalFirst':
                return new WatchDiagonalFirst($data['prefixEnemies'], $data['prefixAllies'], $data['totalColumns']);
                break;
            case 'WatchDiagonalSecond':
                return new WatchDiagonalSecond($data['prefixEnemies'], $data['prefixAllies'], $data['totalColumns']);
                break;

            case 'WatchRow':
                return new WatchRow($data['prefixEnemies'], $data['prefixAllies'], $data['totalColumns']);
                break;

            case 'WatchColumn':
                return new WatchColumn($data['prefixEnemies'], $data['prefixAllies'], $data['totalColumns']);
                break;

            case 'WatchWinnerHuman':
                return new WatchWinnerHuman($data['prefixEnemies'], $data['prefixAllies'], $data['totalColumns']);
                break;
        }

    }
}