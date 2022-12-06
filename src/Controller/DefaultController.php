<?php

namespace App\Controller;

use App\Repository\GigRepository;
use App\Repository\InstrumentRepository;
use App\Repository\MusicianRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'homepage')]//definir la route
    public function index(MusicianRepository $musicianRepository,GigRepository $gigRepository): Response
    {

        //recuperer la liste des musiciens//
        $musicians = $musicianRepository->findAll();//recuperer les données equivalent SELECT * FROM
        $gigs=$gigRepository->findFuture();
        dump($musicians);
        dump($gigs);// afficher des données version console

        //appel le fichier de template Twig avec la methode render qui me retourne une page
        //on definit un tableau associatif avec la variable instruments
        //permet d'envoyer des données du controller vers la vue (fichier twig)
        //retourner ce qu'il y a dans la page home
        return $this->render('default/homepage.html.twig', [
            'musicians' => $musicians, 'gigs'=>$gigs

            ]);





    }
}


