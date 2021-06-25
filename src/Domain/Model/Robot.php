<?php

declare(strict_types=1);

namespace App\Domain\Model;

use \App\Domain\Model\Player;
use App\Domain\Services\Intelligence;

class Robot implements Player
{
    const  PREFIX_PLAYER = 'R';
    const  NAME_PLAYER = 'Robot';
    private array $check;

    public  function move(Board $board, int $row =  null, int $column = null): Board
    {

        $intelligence = new Intelligence($board);

        $bestOption = $intelligence->bestOption();
        if($bestOption !== null) {
            $board->markCell(self::PREFIX_PLAYER, self::NAME_PLAYER, $bestOption['row'], $bestOption['column']);
        }

        return $board;

    }

    public function check(): array
    {
        return $this->check;
    }

}