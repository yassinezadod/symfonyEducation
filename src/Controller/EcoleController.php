<?php

namespace App\Controller;

use App\Entity\Ecole;
use App\Form\EcoleType;
use App\Repository\EcoleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ecole")
 */
class EcoleController extends AbstractController
{
    /**
     * @Route("/", name="app_ecole_index", methods={"GET"})
     */
    public function index(EcoleRepository $ecoleRepository): Response
    {

        $ecoles = $ecoleRepository->findAll();

    $formationsCount = [];
    foreach ($ecoles as $ecole) {
        $formationsCount[$ecole->getId()] = $ecoleRepository->countFormationsByEcole($ecole);
    }
        return $this->render('ecole/index.html.twig', [
            'ecoles' => $ecoleRepository->findAll(),
            'formationsCount' => $formationsCount,
        ]);
    }

    /**
     * @Route("/new", name="app_ecole_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EcoleRepository $ecoleRepository): Response
    {
        $ecole = new Ecole();
        $form = $this->createForm(EcoleType::class, $ecole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ecoleRepository->add($ecole, true);

            return $this->redirectToRoute('app_ecole_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ecole/new.html.twig', [
            'ecole' => $ecole,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ecole_show", methods={"GET"})
     */
    public function show(Ecole $ecole): Response
    {
        return $this->render('ecole/show.html.twig', [
            'ecole' => $ecole,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_ecole_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Ecole $ecole, EcoleRepository $ecoleRepository): Response
    {
        $form = $this->createForm(EcoleType::class, $ecole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ecoleRepository->add($ecole, true);

            return $this->redirectToRoute('app_ecole_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ecole/edit.html.twig', [
            'ecole' => $ecole,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ecole_delete", methods={"POST"})
     */
    public function delete(Request $request, Ecole $ecole, EcoleRepository $ecoleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ecole->getId(), $request->request->get('_token'))) {
            $ecoleRepository->remove($ecole, true);
        }

        return $this->redirectToRoute('app_ecole_index', [], Response::HTTP_SEE_OTHER);
    }
}
