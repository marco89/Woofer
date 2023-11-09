<?php
// THIS IS THE CONTROLLER
namespace App\Controller;

use DateTime;
use App\Entity\MicroPost;
use App\Repository\MicroPostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MicroPostController extends AbstractController
{
    /**
 * Display all MicroPosts.
 *
 * This method renders a list of MicroPosts using the specified template and retrieves the list
 * of MicroPosts from the provided MicroPostRepository.
 *
 * @param MicroPostRepository $posts The MicroPostRepository to retrieve MicroPosts from.
 *
 * @return Response A Response object representing the rendered MicroPost list view.
 */
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
    // app_micro_post_show_one is the name of the route, this is what it's labelled as when viewing it while
    // using `symfony console debug:router` 
    /* When this function is called it fetches an entity of the MicroPost
    type and passes the methods parameter into it to choose which post to display.
    THe "{post}" at the end of the route is the variable that has the value of $post 
    assigned to it i.e. if $post = 1 then url is www.website.com/micro-post/1   */

    /**
     * Display a single MicroPost.
     *
     * This method renders a single MicroPost using the specified template and passes the MicroPost
     * object to the template for rendering.
     *
     * @param MicroPost $post The MicroPost to display.
     *
     * @return Response A Response object representing the rendered MicroPost view.
     */
    #[Route('/micro-post/{post}', name: 'app_micro_post_show_one')]
    public function showOne(MicroPost $post): Response{
        return $this->render('micro_post/show.html.twig', [
            'post' => $post,
        ]);
    }

    /*When routes are defined using PHP attributes or annotations, the priority parameter can be used to define the 
    route priority. The priority parameter is an integer value which can be a positive or negative. The higher value 
    means that route has more priority.  */

    
    /**
     * Display a form to add a new MicroPost.
     *
     * This method displays a form for adding a new MicroPost. It creates a new MicroPost object, 
     * generates a form for it, and then renders the form view for user input.
     * 
     * @return Response A Response object representing the form view for adding a new MicroPost.
     */
    #[Route('/micro-post/add', name: 'app_micro_post_add', priority : 2 )]
    // adding "$posts" as a 2nd param injects it to give access to the MicroPostRepository repository
    public function add(Request $request, MicroPostRepository $posts): Response {

        // create a new object of the MicroPost class
        $microPost = new MicroPost();
        // create a new form using the createFormBuilder function, with the microPost object passed as the parameter
        $form = $this->createFormBuilder($microPost)
        // adds input fields with the string param being the default label *if none is specified in the twig file*
        ->add('title')
        ->add('text')
        // 1st param makes form element a submit i.e. a button
        // 2nd param labels the element with the string "Save post"
        // this is now handled in add.html.twig but leaving here for educational purposes
        // ->add('submit', SubmitType::class, ['label' => 'Save post'])
        // gets the form
        ->getForm();

        // calls the link submit() method if form was successfully submitted 
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $post->setCreated(new Datetime());
            /* this calls the add() method from src\Repository\MicroPostRepository.php
            and that repository is available because it is injected as the 2nd param of
            when calling this method.
            This repository contains the add() and remove() methods which do the actual
            updating of the database. They call those methods, pass "entities" as the
            params. NOTE: an entity is a class that represents a table in a db.*/
            $posts->add($post, true);
            /* flashes only last for one request, the text to be display is the 2nd param
            and this is shown in base.html.twig as `message` */
            $this->addFlash('success', 'Your micro post has been saved.');
            /* redirects to micro-post index page by using the route that's called "app_micro_post"
               routes are like the motorways of the codebase so app_micro_post is the M1 */
            return $this->redirectToRoute('app_micro_post');
            // Redirect to another page
        }

        // returns by using render() function, first param is what View (V of MVC) to show (aka what twig template)
        return $this->renderForm(
            'micro_post/add.html.twig', 
            [
                'form' => $form
            ]
        );

    }
}
