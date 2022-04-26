<?php

namespace Drupal\adimeo_drupal_monitoring\Controller;

use Drupal\adimeo_drupal_monitoring\Form\ConfigForm;
use Drupal\adimeo_drupal_monitoring\Manager\MonitoringManager;
use Drupal\adimeo_drupal_monitoring\Exception\NoApiKeyHeaderException;
use Drupal\adimeo_drupal_monitoring\Exception\WrongApiKeyHeaderException;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class StatusReportController extends ControllerBase {

  const API_KEY_HEADER = 'adimeo-drupal-monitoring-api-key';

  protected MonitoringManager $monitoringManager;

  protected string $allowedApiKey;

  public function __construct(MonitoringManager $monitoringManager, ConfigFactoryInterface $configFactory) {
    $this->monitoringManager = $monitoringManager;
    $this->allowedApiKey = $configFactory->get(ConfigForm::CONFIG_KEY)->get(ConfigForm::API_KEY_PARAM);
  }

  public static function create(ContainerInterface $container) {
    /** @var MonitoringManager $monitoringManager */
    $monitoringManager = $container->get('adimeo_drupal_monitoring.processing.manager');
    $configFactory = $container->get('config.factory');
    return new static($monitoringManager, $configFactory);
  }

  public function getStatusReport(Request $request) {
    $httpHeaders = $request->headers;

    if (!$httpHeaders->has(self::API_KEY_HEADER)) {
      throw new NoApiKeyHeaderException();
    }

    $requestApiKey = (string) $httpHeaders->get(self::API_KEY_HEADER);
    if ($requestApiKey !== $this->allowedApiKey) {
      throw new WrongApiKeyHeaderException();
    }
    
    $data = $this->monitoringManager->fetchData();
    return new JsonResponse((array) $data);
  }
}