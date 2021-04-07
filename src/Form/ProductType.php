<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\DataTransformer\CentimesTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom du produit', 'attr' => ['placeholder' => 'Tapez le nom du produit']])
            ->add('shortDescription', TextareaType::class, ['label' => 'description courte', 'attr' => ['placeholder' => 'tapez une desc courte mais parlante pour le client']])
            ->add('price', MoneyType::class, [
                'label' => 'Prix du produit', 'attr' => [],
            ])
            ->add('picture', UrlType::class, ['label' => 'imgae du produit', 'attr' => ['placeholder' => 'URL d\'image']])
            ->add('category', EntityType::class, ['label' => 'Catégorie', 'attr' => [], 'placeholder' => '-- Choix de la catégorie --', 'class' => Category::class, 'choice_label' => 'name']);


        // $builder->get('price')->addModelTransformer(new CentimesTransformer);

        // $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
        //     $product = $event->getData();

        //     if ($product->getPrice() !== null) {
        //         $product->setPrice($product->getPrice * 100);
        //     }
        // });


        // $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
        //     $form = $event->getForm();
        //     /** @var Product */
        //     $product = $event->getData();

        //     if ($product->getPrice() !== null) {
        //         $product->setPrice($product->getPrice() / 100);
        //     }
        //          if ($product->getId() === null) {
        //              $form->add('category', EntityType::class, ['label' => 'Catégorie', 'attr' => [], 'placeholder' => '-- Choix de la catégorie --', 'class' => Category::class, 'choice_label' => 'name']);
        //          }
        // });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
