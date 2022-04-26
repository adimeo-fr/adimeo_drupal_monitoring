<?php

namespace Drupal\adimeo_drupal_monitoring\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Apm monitoring item annotation object.
 *
 * @see \Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoringManager
 * @see plugin_api
 *
 * @Annotation
 */
class DrupalMonitoring extends Plugin
{

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The label of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $label;

}
