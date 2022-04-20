<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Matiere;
use App\Entity\User;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class  EnseignantController extends DefaultController
{

    /**
     * @Route("/indexenseignants", name="indexenseignants")
     */
    public function index(): Response
    {
        // if(empty($this->getUser())){
        //     return $this->redirectToRoute('app_login'); 
        // } 
        $enseignants=$this->em->getRepository(User::class)->findBy(
            ['type' => "Enseignant"]);
        return $this->render('prof/index.html.twig', ["enseignants"=>$enseignants]);
    }


    /**
     * @Route("/getpageaddprof", name="getpageaddprof", methods={"GET"})
     */
    public function getpageaddprof(): Response
    {
        // if(empty($this->getUser())){
        //     return $this->redirectToRoute('app_login'); 
        // } 
        $matieres=$this->em->getRepository(Matiere::class)->findAll();
        return $this->render('prof/add.html.twig', ["matieres"=>$matieres]);
    }
    
    

     /**
     * @Route("/save/prof", name="saveprof", methods={"POST"})
     */
    public function saveprof(Request $request,UserPasswordHasherInterface $userPasswordHasher)
    {
        try {
            // if(empty($this->getUser())){
            //     return $this->redirectToRoute('app_login'); 
            // } 
            $nom =  $request->get('nom');
            $prenom =  $request->get('prenom');
            $sexe =  $request->get('sexe');
            $matricule =  $request->get('matricule');
            $naisance =  $request->get('naisance');
            $matiere =  $request->get('matiere');
            $username =  $request->get('username');
            $password =  $request->get('password');
            $photo =$request->files->get("photo");
            $description =  $request->get('description');
            //dd($nom);
            $user= new User();
            $user->setNom($nom);
            $user->setPrenom($prenom);
            $user->setSexe($sexe);
            $user->setMatricule($matricule);
            $user->setUsername($username);
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                        $user,
                        $password
                    )
                );
            $user->setDatenaissance(new \DateTime($naisance));
            $user->setDescription($description);
            $user->setMatiere($this->em->getRepository(Matiere::class)->find($matiere));
            $user->setType("Enseignant");
            if(!empty($photo)){
                $exptension=$photo->guessExtension();
                $photopath = md5(uniqid().'.'.$photo->guessExtension());  
                $photo->move("profilpicture", $photopath.".".$exptension);
                $user->setPhoto($photopath.".".$exptension);
            }
            $this->em->persist($user);
            $this->em->flush();
            $responsse = array("type"=>"success", "msg"=>"Groupe ajouter");
            $this->addFlash("message",$responsse);
            return $this->redirect('/indexenseignants');
        } catch (\Exception $ex) {
           
            $responsse = array("type"=>"danger", "msg"=>$ex->getMessage());
            $this->addFlash("message",$responsse);
            return $this->redirect('/indexenseignants');
        }
    }





}
