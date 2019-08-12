<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Unit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    
    /**
     * @Route("/users", name="users")
     */
    public function index()
    {
        $users = ['data' => $this->getDoctrine()
        ->getRepository(User::class)
        ->findAll()];
        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        $jsonContent = $serializer->serialize($users, 'json');
        return new Response($jsonContent,200);
    }

    /**
     * * 
     * @Route("/user/store", name="create_user", methods={"POST"})
     */
    public function createUser(Request $request): Response {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setName($request->request->get('name'));
        $user->setEmail($request->request->get('email'));
        $user->setStreet($request->request->get('street'));
        $user->setCity($request->request->get('city'));
        $user->setState($request->request->get('state'));
        $user->setZip($request->request->get('zip'));
        $user->setPhone($request->request->get('phone'));
        $user->setGender($request->request->get('gender'));
        $dob = new \DateTime($request->request->get('dob'));
        $user->setDob($dob); 
        $user->setStudentId($request->request->get('student_id'));
        $units = $this->getDoctrine()
        ->getRepository(Unit::class)
        ->findAll();
        $availability = false;
        foreach($units as $unit){
            $unit_users = $unit->getUsers();
            if($request->request->get('building_number') == $unit->getBuildingNumber()){
                if($unit_users->count()>0){
                    if(count($unit_users->count()<8)){
                        foreach($unit_users as $roommate){
                            if($roommate->getGender()==$request->request->get('gender')){
                                $user->setUnit($unit);
                                $entityManager->persist($user);

                                $entityManager->flush();
                                $user = $this->getDoctrine()
                                ->getRepository(User::class)
                                ->find($user->getId());
                                $result = ['success' => true, 'user' => $user];
                                $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
                                $jsonContent = $serializer->serialize($result, 'json');
                                return new Response($jsonContent,200);
                                
                            }
                        }
                    } 
                } else {
                    $user->setUnit($unit);
                    $entityManager->persist($user);
                    $entityManager->flush();
                    $user = $this->getDoctrine()
                    ->getRepository(User::class)
                    ->find($user->getId());
                    
                    $result = ['success' => true, 'user' => $user];
                    $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
                    $jsonContent = $serializer->serialize($result, 'json');
                    return new Response($jsonContent,200);
                }
            }
        }

        return $this->json(["success" => false]);
        //$user->setUnit($units[0]);

        //$serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        //$jsonContent = $serializer->serialize($user, 'json');
        //return new Response($jsonContent,200);
        /*
        $errors = $validator->validate($user);
        if(count($errors) > 0){
            return new Response((string) $errors, 400);
        }
        */
        
    }

    /**
     * @Route("/user/{id}", name="user_show")
     */
    public function show(User $user){
       

        if(!$user) {
            throw $this->createNotFoundException("No user found for id " . $id);
        }
        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        $jsonContent = $serializer->serialize($user, 'json');
        return new Response($jsonContent,200);
    }
}
