<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PropertyController extends AbstractController
{
    private $repo;
    public function __construct(PropertyRepository $repo)
    {
        $this->repo = $repo;
    }
    /**
     * @Route("/property", name="property")
     * @param PropertyRepository $repo
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {

        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);

        $properties = $paginator->paginate(
            $this->repo->findProperties($search),
            $request->query->getInt('page', 1),
            12
        );
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $properties,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/property/{slug}-{id}", name="details", requirements={"slug": "[a-z0-9\-]*"})
     * @param PropertyRepository $repo
     * @return Response
     */
    public function detail(Property $property, string $slug): Response
    {
        // $property = $this->repo->find($id);
        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('details', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
        return $this->render('property/details.html.twig', [
            'current_menu' => 'properties',
            'property' => $property
        ]);
    }
}
