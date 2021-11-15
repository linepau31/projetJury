<?php

namespace App\Classe;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class MyBar
{
    private $session;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
    }

    public function add($id)
    {
        $myBar = $this->session->get('my_bar', []);

        if (!empty($myBar[$id])) {
            $myBar[$id]++;
        }
        else{
            $myBar[$id] = 1;
        }

        $this->session->set('my_bar', $myBar);
    }

    public function get()
    {
        return $this->session->get('my_bar');
    }

    public function delete($id)
    {
        $myBar = $this->session->get('my_bar', []);

        unset($myBar[$id]);

        return $this->session->set('my_bar', $myBar);
    }

    public function getFull(): array
    {

        $myBarComplete = [];

        if ($this->get()) {
            foreach ($this->get() as $id => $quantity){
                $product_object = $this->entityManager->getRepository(Product::class)->findOneById($id);

                if(!$product_object){
                    $this->delete($id);
                    continue;
                }

                $myBarComplete[] = [
                    'product' => $product_object,
                    'quantity' => $quantity
                ];
            }
        }
        return $myBarComplete;
    }

}