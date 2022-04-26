<?php

namespace Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoring;

use Drupal\adimeo_drupal_monitoring\Annotation\DrupalMonitoring;
use Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoringBase;
use Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoringInterface;
use Drupal\Core\File\FileSystem;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *  Storage usage infos
 *
 * @DrupalMonitoring(
 *  id = "site_storage_usage",
 *  label = "Site storage usage"
 * )
 */
class StorageUsageDrupalMonitoring extends DrupalMonitoringBase implements DrupalMonitoringInterface, ContainerFactoryPluginInterface
{


  /**
   * @var FileSystem
   */
  private $fileSystem;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, FileSystem $fileSystem)
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->fileSystem = $fileSystem;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('file_system')
    );
  }

  /**
   * @inheritDoc
   */
  public function fetch()
  {

    $shellData = exec('du -sk ' . $this->fileSystem->realpath('://'));
    $filesize = preg_split('/[\t]/', $shellData);

    // convert bytes to megabytes
    $readableFileSize = floor($filesize[0] / 1024);


    return $readableFileSize;
  }


}
