<?php


namespace Drupal\adimeo_drupal_monitoring\Manager;

use Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoringManager;
use Drupal\Core\Config\ConfigFactoryInterface;

class MonitoringManager
{

  /**
   * @var DrupalMonitoringManager
   */
  private $drupalMonitoringManager;
  /**
   * @var ConfigFactoryInterface
   */
  private $config;

  public function __construct(DrupalMonitoringManager $manager, ConfigFactoryInterface $config)
  {
    $this->drupalMonitoringManager = $manager;
    $this->config = $config;
  }

  /**
   * Check if cron job has been executed today
   *
   * @return boolean
   */
  public function shouldRunCron()
  {
    $lastTrackingDateCron = \Drupal::state()->get('adimeo_drupal_monitoring_last_cron');

    if (date('d-m-Y') != $lastTrackingDateCron) {
      \Drupal::state()->set('adimeo_drupal_monitoring_last_cron', date('d-m-Y'));
      return true;
    }

    return false;
  }

  /**
   * get data from all plugins type drupalMonitoring with the fetch method
   *
   * @return array
   */
  public function fetchData()
  {

    $instances = $this->createPluginInstances();

    $data = array();
    foreach ($instances as $instance) {
      $data[$instance->id()] = $instance->fetch();
    }

    // todo check if is still useful, given it is a pull method.
//    $data = array_merge($data, $this->fetchConfigData());

    return $data;
  }


  public function fetchConfigData()
  {
    return [
      'site_id' => $this->config->get('drupal_monitoring_id'),
      'site_environnement' => $this->config->get('drupal_monitoring_environnement'),
      'sending_method' => $this->config->get('drupal_monitoring_sending_method'),
    ];
  }

  /**
   *  Create instances for all drupalMonitoring plugins
   *
   * @return array
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  public function createPluginInstances()
  {
    $definitions = $this->drupalMonitoringManager->getDefinitions();

    $instances = array();
    foreach ($definitions as $plugin_id => $plugin_definition) {

      $instances[] = $this->drupalMonitoringManager->createInstance($plugin_id, []);

    }

    return $instances;
  }

}
