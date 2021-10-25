<?php
namespace App\Classe;


use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
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
        $cart = $this->session->get('cart', []);

        if (!empty($cart[$id])) {
            $cart[$id]++;  /* ajoute 1 produit */
        }
        else{
            $cart[$id] = 1;  /* enlève */
        }
        $this->session->set('cart', $cart);
    }

    public function get()
    {
        return $this->session->get('cart');
    }

    public function remove()
    {
        return $this->session->remove('cart');
    }

    public function delete($id)
    {
        $cart = $this->session->get('cart', []);

        unset($cart[$id]);

        return $this->session->set('cart', $cart);
    }

    public function decrease($id)   /* vérifie la quantité du produit = 1*/
    {
        $cart = $this->session->get('cart', []);

        if ($cart[$id] > 1) {    /* retirer (-1) */
            $cart[$id]--;
        }
        else {  /* supprimer le produit */
            unset($cart[$id]);
        }
        return $this->session->set('cart', $cart);
    }

    public function getFull(): array
    {

        $cartComplete = [];

        if ($this->get()) {
            foreach ($this->get() as $id => $quantity){
                $product_object = $this->entityManager->getRepository(Product::class)->findOneById($id);

                if(!$product_object){
                    $this->delete($id);
                    continue;
                }

                $cartComplete[] = [
                    'product' => $product_object,
                    'quantity' => $quantity
                ];
            }
        }
        return $cartComplete;
    }

}