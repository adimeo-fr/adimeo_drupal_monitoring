<?php

namespace Drupal\adimeo_drupal_monitoring\Plugin\ApmTracking;

use Drupal\adimeo_drupal_monitoring\Annotation\ApmTracking;
use Drupal\adimeo_drupal_monitoring\Plugin\ApmTrackingBase;
use Drupal\adimeo_drupal_monitoring\Plugin\ApmTrackingInterface;

/**
 *  Site infos
 *
 * @ApmTracking(
 *  id = "site_infos",
 *  label = "Site general informations"
 * )
 */
class SiteInfosApmTracking extends ApmTrackingBase implements ApmTrackingInterface
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
