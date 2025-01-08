<?php

namespace App\Controller;

use App\Repository\CongeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    public function __construct(private readonly CongeRepository $congeRepository) {}
    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
        $result = $this->congeRepository
            ->createQueryBuilder("c")
            ->select("c.type", "u.nom", "u.prenom")
            ->join("c.user", "u")
            ->getQuery()
            ->getResult();

        dump(
            $this->congeRepository
                ->createQueryBuilder('c')
                ->select("c")
                ->groupBy("c.type")
                ->having("SUM(c.id) >= 3")
                ->getQuery()
                ->getResult()
        );

        dump(
            $this->congeRepository
                ->createQueryBuilder('c')
                ->select("c")
                ->groupBy("c.type")
                ->having("SUM(c.id) >= 3")
                ->getQuery()
                ->getResult()
        );

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            'result' => $result
        ]);
    }
}
