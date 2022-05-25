<?php

namespace Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoring;

use Drupal\adimeo_drupal_monitoring\Annotation\DrupalMonitoring;
use Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoringBase;
use Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoringInterface;

/**
 *  Drupal Version
 *
 * @DrupalMonitoring(
 *  id = "site_php_version",
 *  label = "Version php du site"
 * )
 */
class PhpVersionDrupalMonitoring extends DrupalMonitoringBase implements DrupalMonitoringInterface
{

    /**
     * Retrieve version of php site
     *
     * @return string
     */
    public function fetch()
    {
        return phpversion();
    }
}
