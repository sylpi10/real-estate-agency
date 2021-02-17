<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function index(): Response
    {
        $property = new Property();
        $property->setTitle("third home")
            ->setPrice(162000)
            ->setRooms(6)
            ->setSurface(124)
            ->setBedrooms(4)
            ->setCity("Chicago")
            ->setPostalCode(44447)
            ->setDescription("amazing house in Chicago")
            ->setHeat(2)
            ->setAddress("chicagu bulls avenue");
        $manager = $this->getDoctrine()->getManager();
        // $manager->persist($property);
        // $manager->flush();

        $properties = $this->repo->findAllAvailable();
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $properties
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
