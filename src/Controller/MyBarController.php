<?php

namespace App\Controller;

use App\Classe\MyBar;
use App\Form\MyBarType;
use App\Repository\MyBarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;

class MyBarController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/my_bar', name: 'my_bar')]
    public function index(MyBar $myBar): Response
    {

        return $this->render('my_bar/index.html.twig', [
            'my_bar' => $myBar->getFull()
        ]);
    }

    #[Route('/my_bar/add/{id}', name: 'add_my_bar')]
    public function add(MyBar $myBar, $id): Response
    {
        $myBar->add($id);
        return $this->redirectToRoute('my_bar');
    }

    #[Route('/my_bar/delete/{id}', name: 'delete_my_bar')]

    public function delete(MyBar $myBar, $id): Response
    {
        $myBar->delete($id);

        return $this->redirectToRoute('my_bar');
    }


}
