<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Matiere;
use App\Entity\Classe;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;



class  ClasseController extends DefaultController
{

    /**
     * @Route("/indexclasses", name="indexclasses")
     */
    public function index(): Response
    {
        // if(empty($this->getUser())){
        //     return $this->redirectToRoute('app_login'); 
        // } 
        $classes=$this->em->getRepository(Classe::class)->findAll();
        return $this->render('classes/index.html.twig', ["classes"=>$classes]);
    }


    /**
     * @Route("/getpageaddclasse", name="getpageaddclasse")
     */
    public function getpageaddclasse(): Response
    {
        // if(empty($this->getUser())){
        //     return $this->redirectToRoute('app_login'); 
        // } 
        return $this->render('classes/add.html.twig', []);
    }
    
    

     /**
     * @Route("/save/classe", name="saveclasse", methods={"POST"})
     */
    public function saveclasses(Request $request)
    {
        try {
            // if(empty($this->getUser())){
            //     return $this->redirectToRoute('app_login'); 
            // } 
            $nom =  $request->get('nom');
            $description =  $request->get('description');
            //dd($nom);
            $classe= new Classe();
            $classe->setNom($nom);
            $classe->setDescription($description);
            $this->em->persist($classe);
            $this->em->flush();
            $responsse = array("type"=>"success", "msg"=>"Classe ajouter");
            $this->addFlash("message",$responsse);
            return $this->redirect('/indexclasses');
        } catch (\Exception $ex) {
            $responsse = array("type"=>"danger", "msg"=>$ex->getMessage());
            $this->addFlash("message",$responsse);
            return $this->redirect('/indexclasses');
        }
    }





}
