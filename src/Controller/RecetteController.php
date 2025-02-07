<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteType;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Recipient\Recipient;
use Symfony\Component\Routing\Attribute\Route;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

final class RecetteController extends AbstractController
{
   
   
   
   
    #[Route('/', name: 'app_recette_all')]
    public function index(RecetteRepository $recetteRepository): Response
    {
        // TranslatorInterface $translator
        // dd($translator->trans('Welcome')); 
        $recette = $recetteRepository->findAll();

        return $this->render('recette/index.html.twig', [
            'recettes' => $recette,
        ]);
    }


   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
    #[Route('/recette/create', name: 'app_recette_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {

        $recette = new Recette();

        $recetteForm = $this->createForm(RecetteType::class, $recette);
        $recetteForm->handleRequest($request);

        if ($recetteForm->isSubmitted() && $recetteForm->isValid()) {
            $recette->setAuteur(($this->getUser()));
            // dd($recipe);
            $entityManager->persist($recette);
            $entityManager->flush();


            return $this->redirectToRoute('app_recette_all');
        }

        return $this->render('recette/create.html.twig', [
            'recetteForm' => $recetteForm,
        ]);
    }




    #[Route('/recette/update/{id}', name: 'app_recette_update')]
    public function update(int $id, Request $request, EntityManagerInterface $entityManager, RecetteRepository $recetteRepository, UploaderHelper $helper): Response
    {


        $recette = $recetteRepository->find($id);

        $recetteForm = $this->createForm(RecetteType::class, $recette);
        $recetteForm->handleRequest($request);

        if ($recetteForm->isSubmitted() && $recetteForm->isValid()) {


            // Cette logique est par la suite gérée par le bundle VichUploaderBundle. Pour plus d'informations, consultez la documentation officielle du bundle.
            // /**@var UploadedFile $file */
            // $file = $recetteForm->get('thumbnailFile')->getData();
            // $filename = $recette->getId() . '.' . $file->getClientOriginalExtension();
            // $file->move($this->getParameter('kernel.project_dir') . '/public/recettes/images', $filename);
            // $recette->setThumbnail($filename);

            // dd($recette);


            $this->addFlash(('success'), 'Recette modifiée avec succès');


            $entityManager->persist($recette);
            $entityManager->flush();


            return $this->redirectToRoute('app_recette_all');
        }

        return $this->render('recette/update.html.twig', [
            'recetteForm' => $recetteForm,
            'recette' => $recette,
        ]);
    }








    #[Route('/recette/{id}', name: 'app_recette')]
    public function show(int $id, RecetteRepository $recetteRepository): Response
    {

        $recette = $recetteRepository->find($id);
        // dd($recipe);


        return $this->render('recette/show.html.twig', [
            'recette' => $recette,
        ]);
    }



    #[Route('/recette/{slug}', name: 'app_recette_name')]
    public function showByName(string $slug, RecetteRepository $recetteRepository): Response
    {

        $recette = $recetteRepository->findOneBy(['slug' => $slug]);

        // dd($recipe);


        return $this->render('recette/show.html.twig', [
            'recette' => $recette,
        ]);
    }




    #[Route('/recette/{id}/delete', name: 'app_recette_delete')]
    public function delete(int $id, RecetteRepository $recetteRepository, EntityManagerInterface $entityManager): Response
    {

        $recette = $recetteRepository->find($id);
        $entityManager->remove($recette);
        $entityManager->flush();

        return $this->redirectToRoute('app_recette_all');
    }
}
