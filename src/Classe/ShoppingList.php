<?php

namespace App\Classe;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ShoppingList
{

    private SessionInterface $session;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
    }

    public function add($id)
    {
        $shoppingList = $this->session->get('shopping_list', []);

        if (!empty($shoppingList[$id])) {
            $shoppingList[$id]++;
        }
        else{
            $shoppingList[$id] = 1;
        }
        $this->session->set('shopping_list', $shoppingList);
    }

    public function get()
    {
        return $this->session->get('shopping_list');
    }


    public function delete($id)
    {
        $shoppingList = $this->session->get('shopping_list', []);

        unset($shoppingList[$id]);

        return $this->session->set('shopping_list', $shoppingList);
    }

    public function decrease($id)   /* vérifie la quantité du produit = 1*/
    {
        $shoppingList = $this->session->get('shopping_list', []);

        if ($shoppingList[$id] > 1) {    /* retirer (-1) */
            $shoppingList[$id]--;
        } else {  /* supprimer le produit */
            unset($shoppingList[$id]);
        }
        return $this->session->set('shopping_list', $shoppingList);
    }

    public function getFull(): array
    {

        $shoppingListComplete = [];

        if ($this->get()) {
            foreach ($this->get() as $id => $quantity){
                $product_object = $this->entityManager->getRepository(Product::class)->findOneById($id);

                if(!$product_object){
                    $this->delete($id);
                    continue;
                }

                $shoppingListComplete[] = [
                    'product' => $product_object,
                    'quantity' => $quantity
                ];
            }
        }
        return $shoppingListComplete;
    }
}