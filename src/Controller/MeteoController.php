<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MeteoController extends AbstractController
{
   
    #[Route('/meteo', name: 'meteo')]
    public function index(): Response
    {
        // Récupérer les données météorologiques de Tunis à partir de l'API OpenWeatherMap
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://api.openweathermap.org/data/2.5/weather', [
            'query' => [
                'q' => 'Tunis',
                'appid' => '2e8972c6de6d4cbe5ae9ea9d4d92f145',
                'units' => 'metric'
            ]
        ]);

        // Vérifier que la réponse est valide
        if ($response->getStatusCode() === 200) {
            // Récupérer les données JSON
            $data = json_decode($response->getContent(), true);

            // Récupérer les informations nécessaires
            $temperature = $data['main']['temp'];
            $description = $data['weather'][0]['description'];
            $icon = $data['weather'][0]['icon'];

            // Afficher les données dans la page HTML.twig
            return $this->render('meteo/index.html.twig', [
                'temperature' => $temperature,
                'description' => $description,
                'icon' => $icon
            ]);
        } else {
            // Si la réponse n'est pas valide, afficher une erreur
            return $this->render('error.html.twig', [
                'message' => 'Erreur lors de la récupération des données météorologiques'
            ]);
        }
    }
}


