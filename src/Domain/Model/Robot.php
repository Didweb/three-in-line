<?php

declare(strict_types=1);

namespace App\Domain\Model;

use \App\Domain\Model\Player;
use App\Domain\Services\Intelligence;

final class Robot implements Player
{
    const  PREFIX_PLAYER = 'R';
    const  NAME_PLAYER = 'Robot';

    public static function move(Board $board, int $row =  null, int $column = null): void
    {
        $bestOption = Intelligence::bestOption($board);
        $board->markCell(self::PREFIX_PLAYER, self::NAME_PLAYER, $bestOption['row'], $bestOption['column']);
    }
}