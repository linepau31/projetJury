<?php

namespace App\Controller;

use App\Entity\Blogpost;
use App\Entity\Commentary;
use App\Form\CommentaryType;
use App\Repository\BlogpostRepository;
use App\Repository\CommentaryRepository;
use App\Service\CommentaryService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogpostController extends AbstractController
{

    #[Route('/blog', name: 'blogposts')]
    public function index(
        BlogpostRepository $blogpostRepository,
        PaginatorInterface $paginator,
        Request $request): Response
    {
        $data = $blogpostRepository->findBy([], ['id' => 'DESC']);

        $blogposts = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('blogpost/index.html.twig', [
            'blogposts' => $blogposts,
        ]);

    }
    #[Route('/blog/{slug}', name: 'index_single')]

    public function single(
        Blogpost          $blogpost,
        Request           $request,
        CommentaryService $commentaryService,
        CommentaryRepository $commentaryRepository): Response
    {

        $commentaires = $commentaryRepository->findCommentaires($blogpost);
        $commentary = new Commentary();
        $form = $this->createForm(CommentaryType::class, $commentary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentary = $form->getData();
            $commentaryService->persistCommentary($commentary, $blogpost);

            return $this->redirectToRoute('index_single', ['slug' => $blogpost->getSlug()]);
        }

        return $this->render('blogpost/single.html.twig', [
            'blogpost' => $blogpost,
            'form' => $form->createView(),
            'commentaires' => $commentaires
        ]);
    }
}
