<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends AbstractController
{

    /**
     * @Route("/admin/category/create", name="category_create")
     */
    public function create(Request $request, SluggerInterface $slugger, EntityManagerInterface $em): Response
    {
        $category = new Category;
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid) {
            $slug = $slugger->slug(strtolower($category->getName()));
            $category->setSlug($slug);
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('product_category', ['slug' => $category->getSlug()]);
        }

        $formCategoryView = $form->createView();

        return $this->render('category/create.html.twig', [
            'categoryformView' => $formCategoryView,
        ]);
    }

    /**
     * @Route("/admin/category/{id}/edit", name="category_edit")
     * @IsGranted("ROLE_ADMIN", message="vous n'avez pas accès a cette ressource methode: isgranted")
     */
    public function edit($id, CategoryRepository $categoryRepository, Request $request, EntityManagerInterface $em, Security $security): Response
    {

        // $user = $security->getUser();

        // if ($user === null) {

        //     return $this->redirectToRoute('app_login');
        // }

        // if (!in_array("ROLE_ADMIN", $user->getRoles())) {
        //     throw new AccessDeniedHttpException('Vous n\'avez pas les droits');
        // }

        // if ($security->isGranted("ROLE_ADMIN") === false) {
        //     throw new AccessDeniedHttpException('Vous n\'avez pas les droits');
        // }
        // if ($this->isGranted("ROLE_ADMIN") === false) {
        //     throw new AccessDeniedHttpException('Vous n\'avez pas les droits methode this is granted');
        // }

        // $this->denyAccessUnlessGranted("ROLE_ADMIN", null, "vous n'avez pas accès a cette ressource methode this denyaccess");

        $category = $categoryRepository->find($id);

        if (!$category) {
            throw new NotFoundHttpException('categorie introuvable');
        }

        // $user = $this->getUser();

        // if (!$user) {
        //     return $this->redirectToRoute('app_login');
        // }

        // if ($user !== $category->getOwner()) {
        //     throw new AccessDeniedHttpException('vous n\'etes pas le propriétaire de la catégorie');
        // };

        // VOTER
        // $this->denyAccessUnlessGranted('CAN_EDIT', $category, "vous n'etes pas le propriétaire de cette catégorie");

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('homepage');
        }

        $formView = $form->createView();
        return $this->render('category/edit.html.twig', [
            'category' => $category,
            'categoryformView' => $formView,
        ]);
    }

    public function renderMenuList()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render('category/_menu.html.twig', ['categories' => $categories]);
    }
}
