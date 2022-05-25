<?php

namespace Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoring;

use Drupal\adimeo_drupal_monitoring\Manager\FetchUpdatesManager;
use Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoringInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\update\UpdateManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *  Updates infos
 *
 * @DrupalMonitoring(
 *  id = "site_security_updates",
 *  label = "Site available security updates"
 * )
 */
class SecurityUpdatesDrupalMonitoring extends FetchUpdatesManager implements DrupalMonitoringInterface, ContainerFactoryPluginInterface
{
  /**
   * @var UpdateManagerInterface
   */
  private $updateManager;


  public function __construct(array $configuration, $plugin_id, $plugin_definition, UpdateManagerInterface $updateManager)
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->updateManager = $updateManager;
  }


  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('update.manager')
    );
  }


  /**
   * @inheritDoc
   */
  public function fetch()
  {
    $projects = $this->updateManager->projectStorage('update_project_data');

    $updates = array();
    foreach ($projects as $project) {
      if ($project['status'] === $this->updateManager::NOT_SECURE
       || $project['status'] === $this->updateManager::REVOKED
       || $project['status'] === $this->updateManager::NOT_SUPPORTED
      ) {
        $updates[] = $this->getUpdate($project);
      }
    }

    return $updates;
  }





}
