<?php

namespace App\Controller;

use App\Validator\DateValidator;
use App\Weather\LoaderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\SimpleCache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class WeatherController extends AbstractController
{
    /**
     * @param               $day
     * @param LoaderService $weatherLoader
	 * @param DateValidator $dateValidator
     * @return Response
     * @throws InvalidArgumentException
     */
    public function index($day, LoaderService $weatherLoader, DateValidator $dateValidator): Response
    {
		$error = $day ? $dateValidator->getError($day) : null;
		$weatherData = null;
		if (!$error) {
			$weather = $weatherLoader->loadWeatherByDay(new \DateTime($day));
			$weatherData = [
				'date'      => $weather->getDate()->format('Y-m-d'),
				'dayTemp'   => $weather->getDayTemp(),
				'nightTemp' => $weather->getNightTemp(),
				'sky'       => $weather->getSky(),
				'provider'  => $weather->getProvider()
			];
		}

        return $this->render('weather/index.html.twig', [
            'weatherData' => $weatherData,
			'error' => $error
        ]);
    }
}
