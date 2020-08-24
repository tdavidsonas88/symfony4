<?php

namespace App\Controller;

use App\Entity\Video;
use App\Events\VideoCreatedEvent;
use App\Form\VideoFormType;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends AbstractController
{

    private $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @Route("/home", name="home")
     */
    public function index(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $videos = $em->getRepository(Video::class)->findAll();
        dump($videos);
        $video = new Video();
        $video->setTitle('Write a blog post');
//        $video->setCreatedAt(new \DateTime('tomorrow'));
//        $video = $em->getRepository(Video::class)->find(1);

        $form = $this->createForm(VideoFormType::class, $video);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($video);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'form' => $form->createView(),
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
