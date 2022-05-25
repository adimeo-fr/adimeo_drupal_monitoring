<?php

namespace Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoring;

use Drupal\adimeo_drupal_monitoring\Annotation\DrupalMonitoring;
use Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoringBase;
use Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoringInterface;

/**
 *  Drupal Version
 *
 * @DrupalMonitoring(
 *  id = "database_version",
 *  label = "Version de la base de donnée du site"
 * )
 */
class DatabaseVersionDrupalMonitoring extends DrupalMonitoringBase implements DrupalMonitoringInterface
{

    /**
     * Retrieve version of database of site
     *
     * @return string
     */
    public function fetch()
    {
        $serviceDb = \Drupal::service('database');

        return $serviceDb->version();
    }
}
