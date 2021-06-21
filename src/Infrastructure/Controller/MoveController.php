<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;


use App\Application\Command\HumanCommandHandler;
use App\Application\Command\RobotCommandHandler;
use App\Domain\Repository\BoardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class MoveController extends AbstractController
{
    private BoardRepository $repository;

    public function __construct(BoardRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @Route("/move/{rowSelect}/{columnSelect}", name="move_human")
     * @param Request $request
     * @param int $rowSelect
     * @param int $columnSelect
     * @return Response
     */
    public function index(Request $request, int $rowSelect, int $columnSelect): Response
    {
        $board = $this->repository->getBoardData();

        $humanPlayer =  new HumanCommandHandler();
        $humanPlayer->move($board, $rowSelect, $columnSelect);

        $robotPlayer =  new RobotCommandHandler();
        $robotPlayer->move($board);


        $this->repository->save($board);

        return $this->render('home/index.html.twig',
                             ['board' => $board]
        );
    }

}