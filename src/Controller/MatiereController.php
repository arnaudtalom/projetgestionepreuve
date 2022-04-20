<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Matiere;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;



class  MatiereController extends DefaultController
{

    /**
     * @Route("/indexmatieres", name="indexmatieres")
     */
    public function index(): Response
    {
        // if(empty($this->getUser())){
        //     return $this->redirectToRoute('app_login'); 
        // } 
        $matieres=$this->em->getRepository(Matiere::class)->findAll();
        return $this->render('matieres/index.html.twig', ["matieres"=>$matieres]);
    }


    /**
     * @Route("/getpageaddmatiere", name="getpageaddmatiere")
     */
    public function getpageaddmatiere(): Response
    {
        // if(empty($this->getUser())){
        //     return $this->redirectToRoute('app_login'); 
        // } 
        return $this->render('matieres/add.html.twig', []);
    }
    
    

     /**
     * @Route("/save/matiere", name="savematiere", methods={"POST"})
     */
    public function savematiere(Request $request)
    {
        try {
            // if(empty($this->getUser())){
            //     return $this->redirectToRoute('app_login'); 
            // } 
            $nom =  $request->get('nom');
            $description =  $request->get('description');
            //dd($nom);
            $matiere= new Matiere();
            $matiere->setNom($nom);
            $matiere->setDescription($description);
            $this->em->persist($matiere);
            $this->em->flush();
            $responsse = array("type"=>"success", "msg"=>"Groupe ajouter");
            $this->addFlash("message",$responsse);
            return $this->redirect('/indexmatieres');
        } catch (\Exception $ex) {
            $responsse = array("type"=>"danger", "msg"=>$ex->getMessage());
            $this->addFlash("message",$responsse);
            return $this->redirect('/indexmatieres');
        }
    }





}
