<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HelloController extends AbstractController
{
    private array $messages = [
        ['message' => 'Hello', 'test', '2023/09/12'],
        ['message' => 'Hi', 'created', '2023/08/04'],
        ['message' => 'Bye', 'created', '2022/05/12'] 
    ];

    /* Route naming explanation: 
    {limit<\d+>?3} is a route parameter with a regular expression constraint and a default value. 

    {limit}: This part defines a route parameter named limit. In Symfony, you can capture values from the URL and use them in your controller actions. 
    In this case, it's capturing a value for limit.
    
    <\d+>: This is a regular expression constraint. It specifies that the limit parameter must be a digit (\d) and that there should be one or more digits (+). 
    In other words, it enforces that the limit parameter should be a positive integer.
    
    ?3: This is the default value for the limit parameter. If the limit parameter is not present in the URL, it will default to 3. 
    So, if someone visits a URL like /, the limit parameter will be assumed as 3.
    
    example:
    user visits www.example.com/5, the limit parameter will be 5.
    user visits www.example.com/123, the limit parameter will be 123.
    user visits www.example.com/, the limit parameter will be 3 (the default value) */
    #[Route('/{limit<\d+>?3}', name: 'app_index')]
    // Response afterwards is typehinting that this method gives a response
    public function index(int $limit): Response 
    {
        return $this->render(
            // this just tells symfony: render the index template and give it the value of messages and limit
            'hello/index.html.twig',
            ['messages' => $this->messages,
            'limit' => $limit
            ]
        );
    } 

    /* the way routing works is that this method is responsible for handling requests to all urls like www.example.com/messages/420
    or www.example.com/messages/69. So it takes an id from the url (this is what's passed in as the param) and returns it as a response.*/
    #[Route('/messages/{id<\d+>}', name: 'app_show_one')]
    public function showOne(int $id): Response
    {
        // $this-> refers to the current instance of the class where it's used i.e. the current instance of the HelloController class
        return $this->render(
            // when referencing a template, the file path should always lead FROM the temples folder
            'hello/show_one.html.twig',
            [
                // this message var is then used in the html.twig template file and is referenced with {{message}}
                'message' => $this->messages[$id]
            ] 
            );
    }
}