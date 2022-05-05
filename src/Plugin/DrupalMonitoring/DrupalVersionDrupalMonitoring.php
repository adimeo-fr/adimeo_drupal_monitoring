<?php

namespace Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoring;

use Drupal\adimeo_drupal_monitoring\Annotation\DrupalMonitoring;
use Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoringBase;
use Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoringInterface;

/**
 *  Drupal Version
 *
 * @DrupalMonitoring(
 *  id = "site_drupal_version",
 *  label = "Version drupal du site"
 * )
 */
class DrupalVersionDrupalMonitoring extends DrupalMonitoringBase implements DrupalMonitoringInterface
{

    /**
     * Retrieve version of drupal site
     *
     * @return string
     */
    public function fetch()
    {
        $drupalVersion = \Drupal::VERSION;

        return $drupalVersion;
    }
}
