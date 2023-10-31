<?php
// THIS IS THE CONTROLLER
namespace App\Controller;

use App\Entity\MicroPost;
use App\Repository\MicroPostRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MicroPostController extends AbstractController
{
    #[Route('/micro-post', name: 'app_micro_post')]
    public function index(MicroPostRepository $posts): Response
    {
        return $this->render('micro_post/index.html.twig', [
            'posts' => $posts->findAll(),
        ]);
    }

    // attribute annotation
    // micro-post/{id} is the end of the url with {id} being variable i.e. www.website.com/micro-post/1 
    // {id} is passed to the controller as the parameter 
    // app_micro_post_show is the name of the route, this is what it's labelled as when viewing it while
    // using `symfony console debug:router` 
    /* When this function is called it fetches an entity of the MicroPost
    type and passes the methods parameter into it to choose which to display  */

    // the error can be fixed by running "composer require sensio/framework-extra-bundle
    #[Route('/micro-post/{post}', name: 'app_micro_post_show')]
    public function showOne(MicroPost $post): Response{
        // dd($post);
        return $this->render('micro_post/show.html.twig', [
            'post' => $post,
        ]);
    }
}
