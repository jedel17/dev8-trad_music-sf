<?php



namespace App\Controller;

use App\Entity\Musician;
use App\Entity\Pub;
use App\Form\MusicianType;
use App\Form\PubType;
use App\Repository\MusicianRepository;
use App\Repository\PubRepository;
use ContainerU2mHfJm\getMusicianControllerService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MusicianController extends AbstractController
{
    #[Route('/musician', name: 'musician_list')]
    public function list(MusicianRepository $musicianRepository): Response
    {
        return $this->render('musician/index.html.twig', [
            'musicians' => $musicianRepository->findAll(),
        ]);
    }

    #[Route('/musician/{id}', name: 'musician_detail', requirements: ['id' => '\d+'])]
    public function detail(int $id, MusicianRepository $musicianRepository): Response
    {

        $musician = $musicianRepository->find($id);

        //si le musicien n'existe pas en BDD on retourne une erreur 404
        if ($musician === null) {
            throw $this->createNotFoundException();
        }
        return $this->render('musician/detail.html.twig', ['musician' => $musician]);
    }
    # route qui me dirige vers la page qui me permet de modifier un
    #[Route('/profil', name: 'app_musician-edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_MUSICIAN')]
    public function edit(Request $request,  MusicianRepository $musicianRepository): Response
    {
        $musician=$this->getUser(); // permet de recuperer l'utilisateur connecte
        $form = $this->createForm(MusicianType::class, $musician);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $musicianRepository->save($musician, true);

            return $this->redirectToRoute('homepage', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('musician/edit.html.twig', [
            'musician' => $musician,
            'form' => $form,
        ]);
    }
}
