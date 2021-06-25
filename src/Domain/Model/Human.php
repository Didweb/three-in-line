<?php

declare(strict_types=1);

namespace App\Domain\Model;


use App\Domain\Services\Intelligence;

class Human implements Player
{
    const  PREFIX_PLAYER = 'H';
    const  NAME_PLAYER = 'Human';

    public  function move(Board $board, int $row = null, int $column = null): Board
    {
        $intelligent = new Intelligence($board);

        $board->markCell(self::PREFIX_PLAYER, self::NAME_PLAYER, $row, $column);

        $board = $intelligent->verificationWinnerHuman();

        return  $board;

    }

}