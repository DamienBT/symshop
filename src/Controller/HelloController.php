<?php

namespace App\Controller;

use App\Taxes\Detector;
use App\Taxes\Calculator;
use Cocur\Slugify\Slugify;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HelloController
{
    protected $calculator;
    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
    }

    /**
     * @Route("/hello/{name?World}", name="hello")
     */
    public function helloworld(Request $request, $name, LoggerInterface $loggerInterface, Slugify $slugify, Detector $detector, Environment $twig)
    {
        // dump($detector->detect(100));
        // dump($detector->detect(10));
        // $loggerInterface->info("Mon message de log");
        // dump($slugify->slugify("Hello World !"));
        // $tva = $this->calculator->calcul(100);
        // dump($tva);
        $html = $twig->render('hello.html.twig', ['prenom' => $name, 'age' => 33, 'prenoms' => ["test1", "test2", "test3"]]);
        return new Response($html);
    }
}
