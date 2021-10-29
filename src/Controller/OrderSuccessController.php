<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderSuccessController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/commande/merci/{stripeSessionId}', name: 'order_success')]
    public function index(Cart $cart, $stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if(!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('home');
        }

        if (!$order->getState () == 0) {    // vider la session "Cart"
            $cart->remove();

            $order->setState(1);
            // statue de la commande
            // 0 non validée
            // 1 payée
            // 2 préparation en cours
            //3 livraison en cours
            $this->entityManager->flush();

            // envoyer un email à notre client pour lui confirmer sa commande
            //   $mail = new Mail();
            // $content = "Bonjour".$order->getUser()->getFirstname()."<br/>Merci pour votre commande<br/><br/>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.";
            //   $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 'Votre commande H2o Fabrik Cocktail est bien validée.', $content);
        }

        // afficher les quelques infos de la commande de l'utilisateur
        return $this->render('order_success/index.html.twig', [
            'order' => $order
        ]);
    }
}

