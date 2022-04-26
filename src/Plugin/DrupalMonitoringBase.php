<?php

namespace Drupal\adimeo_drupal_monitoring\Plugin;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for Drupal Monitoring plugins.
 */
abstract class DrupalMonitoringBase extends PluginBase implements DrupalMonitoringInterface {

  /**
   * Retrieve the @label property from the annotation and return it.
   *
   * @return mixed
   */
  public function label() {
    return $this->pluginDefinition['label'];
  }

  /**
   * Retrieve the @id property from the annotation and return it.
   *
   * @return mixed
   */
  public function id() {
    return $this->pluginDefinition['id'];
  }


}
