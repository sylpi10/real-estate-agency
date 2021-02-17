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
    /**
     * @Route("/property", name="property")
     * @param PropertyRepository $repo
     * @return Response
     */
    public function index(PropertyRepository $repo): Response
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

        $properties = $repo->findAllAvailable();
        return $this->render('property/index.html.twig', [
            'controller_name' => 'PropertyController',
            'current_menu' => 'properties',
            'properties' => $properties
        ]);
    }
}
