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
        }

    }
}