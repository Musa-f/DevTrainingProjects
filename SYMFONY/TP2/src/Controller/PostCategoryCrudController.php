<?php

namespace App\Controller;

use App\Entity\PostCategory;
use App\Form\PostCategoryType;
use App\Repository\PostCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/post/category/crud')]
class PostCategoryCrudController extends AbstractController
{
    #[Route('/', name: 'app_post_category_crud_index', methods: ['GET'])]
    public function index(PostCategoryRepository $postCategoryRepository): Response
    {
        return $this->render('post_category_crud/index.html.twig', [
            'post_categories' => $postCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_post_category_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PostCategoryRepository $postCategoryRepository): Response
    {
        $postCategory = new PostCategory();
        $form = $this->createForm(PostCategoryType::class, $postCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postCategoryRepository->save($postCategory, true);

            return $this->redirectToRoute('app_post_category_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post_category_crud/new.html.twig', [
            'post_category' => $postCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_post_category_crud_show', methods: ['GET'])]
    public function show(PostCategory $postCategory): Response
    {
        return $this->render('post_category_crud/show.html.twig', [
            'post_category' => $postCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_post_category_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PostCategory $postCategory, PostCategoryRepository $postCategoryRepository): Response
    {
        $form = $this->createForm(PostCategoryType::class, $postCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postCategoryRepository->save($postCategory, true);

            return $this->redirectToRoute('app_post_category_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post_category_crud/edit.html.twig', [
            'post_category' => $postCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_post_category_crud_delete', methods: ['POST'])]
    public function delete(Request $request, PostCategory $postCategory, PostCategoryRepository $postCategoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$postCategory->getId(), $request->request->get('_token'))) {
            $postCategoryRepository->remove($postCategory, true);
        }

        return $this->redirectToRoute('app_post_category_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
