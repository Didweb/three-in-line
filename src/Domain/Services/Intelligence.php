<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Model\Board;

final class Intelligence
{
    public static function bestOption(Board $board): array
    {
        $options = ['row'=>0,'column'=>0];

        return $options;
    }



}