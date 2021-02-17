<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repo;

    /**
     * @var EntityManagerInterface
     */
    private $manager;
    public function __construct(PropertyRepository $repo, EntityManagerInterface $manager)
    {
        $this->repo = $repo;
        $this->manager = $manager;
    }

    /**
     * @Route("/admin", name="admin.property.index")
     *
     * @return Response
     */
    public function index(): Response
    {
        $properties = $this->repo->findAll();
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }

    /**
     * @Route("/admin/create", name="admin.property.create")
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($property);
            $this->manager->flush();
            $this->addFlash("success", "Property created");
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render("admin/property/create.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/{id}", name="admin.property.edit", methods="GET|POST")
     *
     * @return Response
     */
    public function edit(Property $property, Request $request)
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash("success", "Property edited");
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render("admin/property/edit.html.twig", [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/{id}", name="admin.property.delete", methods="DELETE")
     *
     */

    public function delete(Property $property, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))) {
            $this->manager->remove($property);
            $this->manager->flush();
            $this->addFlash("success", "Property deleted");
        }
        return $this->redirectToRoute('admin.property.index');
    }
}
