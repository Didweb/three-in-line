<?php

declare(strict_types=1);

namespace App\Application\Command;


use App\Domain\Model\Player;
use App\Domain\Model\Robot;

final class RobotCommandHandler extends Robot
{
    public function __invoke(): Player
    {
        return new Robot();
    }
}