<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Domain\Repository\BoardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


final class HomeController extends AbstractController
{
    private BoardRepository $repository;

    public function __construct(BoardRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @Route("/", name="home_page")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {

        $board = $this->repository->getBoardData();
        $nLine = ($request->get('nLine'))?(int)$request->get('nLine'):2;
        $board->buildBoard($nLine);
        $this->repository->save($board);

        return $this->render('home/index.html.twig',
        ['board' => $board, 'nLine' => $nLine +1 ]
        );
    }

}