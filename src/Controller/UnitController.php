<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Unit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UnitController extends AbstractController
{
    /**
     * @Route("/unit", name="unit")
     */
    public function index()
    {   
        /*
        $entityManager = $this->getDoctrine()->getManager();
        for($b=1;$b<=2;$b++){
            for($f=1;$f<=4;$f++){
                for($r=1;$r<=4;$r++){
                    
                    $unit = new Unit();
                    $unit->setBuildingNumber($b);
                    $unit->setFloorNumber($f);
                    $unit->setRoomNumber($f . 0 . $r);
                    $entityManager->persist($unit);
                    $entityManager->flush();
                }
            }
        }
        */
        $units = ['data' => $this->getDoctrine()
        ->getRepository(Unit::class)
        ->findAll()];
        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        $jsonContent = $serializer->serialize($units, 'json');
        return new Response($jsonContent,200);
    }

    /**
     * * 
     * @Route("/unit/store", name="create_unit", methods={"POST"})
     */
    public function createUnit(Request $request): Response {
        $entityManager = $this->getDoctrine()->getManager();
        $unit = new Unit();
        $unit->setBuildingNumber($request->request->get('building_number'));
        $unit->setFloorNumber($request->request->get('floor_number'));
        $unit->setRoomNumber($request->request->get('room_number'));
        $entityManager->persist($unit);
        $entityManager->flush();
    }
}
