<?php

namespace Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoring;

use Drupal\adimeo_drupal_monitoring\Annotation\DrupalMonitoring;
use Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoringBase;
use Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoringInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\system\SystemManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *  List of modules on the site
 *
 * @DrupalMonitoring(
 *  id = "module_list",
 *  label = "List of modules"
 * )
 */
class ListOfModulesDrupalMonitoring extends DrupalMonitoringBase implements DrupalMonitoringInterface, ContainerFactoryPluginInterface
{

  /**
   * @var SystemManager
   */
  private $systemManager;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, SystemManager $systemManager)
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);


    $this->systemManager = $systemManager;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('system.manager')
    );
  }


  /**
   * @inheritDoc
   */
  public function fetch()
  {
      // Récupération des modules actifs
      $modules = \Drupal::service('extension.list.module')->getAllInstalledInfo();

      return $modules;
  }


}
