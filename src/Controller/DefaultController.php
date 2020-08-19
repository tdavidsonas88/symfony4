<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\ServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends AbstractController
{

    public function __construct(LoggerInterface $logger)
    {
    }

    /**
     * @Route("/page", name="default")
     */
    public function index(Request $request, ServiceInterface $service)
    {

        $cache = new TagAwareAdapter(
            new FilesystemAdapter()
        );

        $acer = $cache->getItem('acer');
        $dell = $cache->getItem('dell');
        $ibm = $cache->getItem('ibm');
        $apple = $cache->getItem('apple');


        if (!$acer->isHit()) {
            $acer_from_db = 'acer laptop';
            $acer->set($acer_from_db);
            $acer->tag(['computers', 'laptops', 'acer']);
            $cache->save($acer);
            dump('acer laptop from database ... ');
        }
        if (!$dell->isHit()) {
            $dell_from_db = 'dell laptop';
            $dell->set($dell_from_db);
            $dell->tag(['computers', 'laptops', 'dell']);
            $cache->save($dell);
            dump('dell laptop from database ... ');
        }
        if (!$ibm->isHit()) {
            $ibm_from_db = 'ibm desktop';
            $ibm->set($ibm_from_db);
            $ibm->tag(['computers', 'desktops', 'ibm']);
            $cache->save($ibm);
            dump('ibm desktop from database ... ');
        }
        if (!$apple->isHit()) {
            $apple_from_db = 'apple desktop';
            $apple->set($apple_from_db);
            $apple->tag(['computers', 'desktops', 'apple']);

            $cache->save($apple);
            dump('apple from database ... ');
        }
        $cache->invalidateTags(['computers']);


        dump($acer->get());
        dump($dell->get());
        dump($ibm->get());
        dump($apple->get());


        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);

    }

    /**
     * @Route("/blog/{page?}", name="blog_list", requirements={"page"="\d+"})
     */
    public function index2()
    {
        return new Response('Optional parameters in url and requirements for parameters');
    }

    /**
     * @Route(
     *     "/articles/{_locale}/{year}/{slug}/{category}",
     *     defaults={"category": "computers"},
     *     requirements={
     *          "_locale": "en|fr",
     *          "category": "computers|rtv",
     *          "year": "\d+"
     *     }
     * )
     * @return Response
     */
    public function index3()
    {
        return new Response('An advanced route example');
    }

    /**
     * @Route({
     *     "nl": "/over-ons",
     *     "en": "/about-us"
     *     }, name="about_us"
     * )
     * @return Response
     */
    public function index4()
    {
        return new Response('Translated routes');
    }

    /**
     * @Route("/generate-url/{param?}", name="generate_url")
     */
    public function generate_url ()
    {
        exit($this->generateUrl(
            'generate_url',
            array('param' => 10 ),
            UrlGeneratorInterface::ABSOLUTE_URL
        ));
    }

    /**
     * @Route("/download")
     */
    public function download()
    {
        $path = $this->getParameter('download_directory');
        return $this->file($path . 'coupons (1)_paspirtukai_trakuose.pdf');
    }

    /**
     * @Route("/redirect-test")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectTest()
    {
        return $this->redirectToRoute('route_to_redirect', array('param' => 10));
    }

    /**
     * @Route("/url-to-redirect/{param?}", name="route_to_redirect")
     */
    public function methodToRedirect()
    {
        exit('Test redirection');
    }

    /**
     * @Route("/forwarding-to-controller")
     */
    public function forwardingToController()
    {
        $response = $this->forward(
            'App\Controller\DefaultController::methodToForwardTo',
            array('param' => '1')
        );
        return $response;
    }

    /**
     * @Route("/url-to-forward-to/{param?}", name="route_to_forward_to")
     * @param $param
     */
    public function methodToForwardTo($param)
    {
        exit('Test controller forwarding - '.$param);
    }

    public function mostPopularPosts($number = 3)
    {
        // database call;
        $posts = ['post1 ', 'post 2', 'post 3', 'posts 4'];
        return $this->render('default/most_popular_posts.html.twig', [
            'posts' => $posts,
        ]);

    }
}
