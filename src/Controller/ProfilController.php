<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    
    /**
     * @Route("/", name="profil")
     */
    public function index(): Response
    {
        $response = $this->client->request(
            'GET',
            'https://randomuser.me/api/'
        );

        $statusCode = $response->getStatusCode();
        $contentType = $response->getHeaders()['content-type'][0];

        $content = $response->getContent();
        $content = $response->toArray();

        $profile = $content['results'][0];

        $job = ['Développeur Web Full-Stack', 'Développeur Back End', 'Développeur Front End', 'Intégrateur Web', 'Rédacteur Web'];

        if ($profile['gender'] === 'female'){
            $job = ['Développeuse Web Full-Stack', 'Développeuse Back End', 'Développeuse Front End', 'Intégratrice Web', 'Rédactrice Web'];
        }

        return $this->render('profil/index.html.twig', [
            'profile' => $profile,
            'job' => $job
        ]);
    }
}
