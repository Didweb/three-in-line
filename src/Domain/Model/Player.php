<?php

declare(strict_types=1);

namespace App\Domain\Model;

interface Player
{
    public static function move(Board $board, ?int $row, ?int $column): void;
}