<?php

namespace Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoring;

use Drupal\adimeo_drupal_monitoring\Annotation\DrupalMonitoring;
use Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoringBase;
use Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoringInterface;

/**
 *  Site infos
 *
 * @DrupalMonitoring(
 *  id = "site_infos",
 *  label = "Site general informations"
 * )
 */
class SiteInfosDrupalMonitoring extends DrupalMonitoringBase implements DrupalMonitoringInterface
{

    /**
     * @inheritDoc
     */
    public function fetch()
    {
      $config = \Drupal::config('system.site');
      $siteData = $config->get();

      return $siteData;
    }
}
