<?php

declare(strict_types=1);

namespace App\Domain\Model;


final class Human implements Player
{
    const  PREFIX_PLAYER = 'H';
    const  NAME_PLAYER = 'Human';

    public static function move(Board $board, int $row = null, int $column = null): void
    {

        $board->markCell(self::PREFIX_PLAYER, self::NAME_PLAYER, $row, $column);

    }
}