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



class DefaultController extends AbstractController
{

    public $em;



    public function __construct(EntityManagerInterface $em)
    {
        
        $this->em = $em;
        
        
    }
    public function checksecurity(){
        if(empty($this->getUser())){
            return $this->redirectToRoute('app_login'); 
        }
    }


}
