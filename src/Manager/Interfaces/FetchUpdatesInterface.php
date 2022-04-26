<?php


namespace Drupal\adimeo_drupal_monitoring\Manager\Interfaces;


interface FetchUpdatesInterface
{
  /**
   * Return updates data
   * @return array
   */
  public function fetch();

}
