<?php

namespace Drupal\adimeo_drupal_monitoring\Plugin;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Provides the Drupal Monitoring plugin manager.
 */
class DrupalMonitoringManager extends DefaultPluginManager {


  /**
   * Constructs a new DrupalMonitoringPluginManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/DrupalMonitoring', $namespaces, $module_handler, 'Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoringInterface', 'Drupal\adimeo_drupal_monitoring\Annotation\DrupalMonitoring');

    $this->alterInfo('adimeo_drupal_monitoring_drupal_monitoring_info');
    $this->setCacheBackend($cache_backend, 'adimeo_drupal_monitoring_drupal_monitoring');
  }

}
