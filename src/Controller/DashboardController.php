<?php

declare(strict_types=1);

namespace App\Controller;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;



class  DashboardController extends DefaultController
{

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(): Response
    {
        // if(empty($this->getUser())){
        //     return $this->redirectToRoute('app_login'); 
        // } 
        return $this->render('dashboard/index.html.twig', []);
    }

    /**
     * @Route("/", name="indexroute")
     */
    public function indexroute()
    {
        if(!empty($this->getUser())){
            return $this->redirectToRoute('dashboard'); 
        }else{
            return $this->redirectToRoute('app_login'); 
        }
        
    }





}
