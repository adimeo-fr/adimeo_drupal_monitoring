<?php


namespace Drupal\adimeo_drupal_monitoring\Manager;


use Drupal\adimeo_drupal_monitoring\Manager\Interfaces\FetchUpdatesInterface;
use Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoringBase;

abstract class FetchUpdatesManager extends DrupalMonitoringBase implements FetchUpdatesInterface {

  /**
   * @param array $project
   *
   * @return string
   */
  public function getUpdate(array $project): string
  {
    return $project['title'] . ' (<a href="'. $project['link'] .'">' . $project['name'] . '</a>) : ' . $project['info']['version'] . ' => ' . $project['recommended'];
  }

}
