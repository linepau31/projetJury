<?php

namespace App\Controller;

use App\Classe\ShoppingList;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShoppingListController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/shopping_list', name: 'shopping_list')]
    public function index(ShoppingList $shopList): Response
    {
        return $this->render('shopping_list/index.html.twig', [
            'shopping_list' => $shopList->getFull()
            ]);
    }

    #[Route('/shopping_list/add/{id}', name: 'add_shopping_list')]
    public function add(ShoppingList $shoppingList, $id): Response
    {
        $shoppingList->add($id);

        return $this->redirectToRoute('shopping_list');
    }

    #[Route('/shopping_list/delete/{id}', name: 'delete_shopping_list')]

    public function delete(ShoppingList $shoppingList, $id): Response
    {
        $shoppingList->delete($id);

        return $this->redirectToRoute('shopping_list');
    }
}
