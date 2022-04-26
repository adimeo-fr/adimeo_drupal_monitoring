<?php


namespace Drupal\adimeo_drupal_monitoring\Manager;

use Drupal\adimeo_drupal_monitoring\Manager\Interfaces\MonitoringProcessingInterface;
use Drupal\Component\Serialization\Json;
use GuzzleHttp\Client;


class ApiManager implements MonitoringProcessingInterface
{

  // TODO : API END POINT
  const API_URL = '';

  /**
   * @var Json
   */
  private $serializer;
  /**
   * @var Client
   */
  private $client;

  public function __construct(Json $serializer, Client $httpClient)
  {
    $this->serializer = $serializer;
    $this->client = $httpClient;
  }


  public function send(array $data)
  {
    $config = \Drupal::config('drupal_monitoring.config');
    $jsonData = $this->serializer->encode($data);
    $request = $this->client->post(self::API_URL, [
      'json' => [
        $jsonData
      ],
      'config' => [
        'site_environnement' => $config->get('drupal_monitoring_environnement'),
        'site_id' => $config->get('drupal_monitoring_id')
      ]
    ]);

    $response = $request->getBody();

  }
}
