<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Application\Command\BoardCommand;

interface BoardRepository
{
    public function getBoardData(BoardCommand $boardCommand): BoardCommand;
}