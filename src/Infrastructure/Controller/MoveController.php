<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;


use App\Domain\Model\Human;
use App\Domain\Model\Robot;
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

        Human::move($board, $rowSelect, $columnSelect);
        Robot::move($board);
        $this->repository->save($board);

        return $this->render('home/index.html.twig',
                             ['board' => $board]
        );
    }

}