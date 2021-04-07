<?php

namespace App\Controller;

use App\Form\CartConfirmationType;
use App\Service\CartService;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class CartController extends AbstractController
{
    /**
     * @Route("/cart/add/{id}", name="cart_add", requirements={"id":"\d+"})
     */
    public function CartAdd($id, ProductRepository $productRepository, CartService $cartService, FlashBagInterface $flashBag, Request $request)
    {

        $product =  $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('produit introuvable');
        }
        $cartService->add($id);

        $this->addFlash('success', 'test');
        $flashBag->add('success', 'le produit a été ajouté au panier');
        $flashBag->add('info', 'une petite information');

        if ($request->query->get('returnToCart')) {
            return $this->redirectToRoute('cart_show');
        }



        return $this->redirectToRoute('product_show', ['category_slug' => $product->getCategory()->getSlug(), 'slug' => $product->getSlug()]);
    }
    /**
     * @Route("/cart/delete/{id}", name="cart_remove", requirements={"id":"\d+"})
     */
    public function carteDelete($id, ProductRepository $productRepository, CartService $cartService, FlashBagInterface $flashBag)
    {

        $product =  $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('produit introuvable');
        }
        $cartService->delete($id);

        $this->addFlash('success', 'test');
        $flashBag->add('success', 'le produit a été supprimé au panier');
        $flashBag->add('info', 'une petite information');





        return $this->redirectToRoute('cart_show');
    }

    public function CartDel($id)
    {
        dd($id);
    }
    /**
     * @Route("/panier.html", name="cart_show")
     */
    public function show(CartService $cartService)
    {
        $form = $this->createForm(CartConfirmationType::class);

        $detailedCart = $cartService->getDetailledCartItems();

        $total = $cartService->getTotalCart();


        return $this->render('cart/index.html.twig', ['items' => $detailedCart, 'totalPanier' => $total, 'confirmationForm' => $form->createView()]);
    }

    /**
     * @Route("/cart/decrement/{id}", name="cart_decrement", requirements={"id":"\d+"})
     */
    public function CartDecrement($id, ProductRepository $productRepository, CartService $cartService, FlashBagInterface $flashBag, Request $request)
    {

        $product =  $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('produit introuvable');
        }
        $cartService->decrement($id);

        $this->addFlash('success', 'le produit a été décrémenté au panier');
        $flashBag->add('info', 'une petite information');



        if ($request->query->get('returnToCart')) {
            return $this->redirectToRoute('cart_show');
        }


        return $this->redirectToRoute('product_show', ['category_slug' => $product->getCategory()->getSlug(), 'slug' => $product->getSlug()]);
    }
}
