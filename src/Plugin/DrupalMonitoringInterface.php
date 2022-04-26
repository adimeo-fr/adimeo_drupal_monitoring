<?php

namespace Drupal\adimeo_drupal_monitoring\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Defines an interface for Drupal Monitoring plugins.
 */
interface DrupalMonitoringInterface extends PluginInspectionInterface {

  public function label();


  /**
   * Return the requested data
   *
   * @return array
   */
 public function fetch();

}
