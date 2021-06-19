<?php

declare(strict_types=1);

namespace App\Domain\Repository;


use App\Domain\Model\Board;

interface BoardRepository
{
    public function getBoardData(): Board;

    public function save(Board $board): void;
}