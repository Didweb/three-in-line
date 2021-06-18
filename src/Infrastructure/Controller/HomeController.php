<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Domain\Model\Board;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


final class HomeController extends AbstractController
{
    private Board $board;
    public function __construct(Board $board)
    {
        $this->board = $board;
    }


    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {

        return $this->render('home/index.html.twig',
        ['board' => $this->board->boardDataJson()]
        );
    }

}