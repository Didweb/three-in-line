<?php

declare(strict_types=1);

namespace App\Application\Command;


use App\Domain\Model\Human;
use App\Domain\Model\Player;

final class HumanCommandHandler extends Human
{

    public function __invoke(): Player
    {
        return new Human();
    }
}