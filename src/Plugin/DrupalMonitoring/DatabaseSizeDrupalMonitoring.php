<?php

namespace Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoring;

use Drupal\adimeo_drupal_monitoring\Annotation\DrupalMonitoring;
use Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoringBase;
use Drupal\adimeo_drupal_monitoring\Plugin\DrupalMonitoringInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *  Database size infos
 *
 * @DrupalMonitoring(
 *  id = "site_database_size",
 *  label = "Site database size"
 * )
 */
class DatabaseSizeDrupalMonitoring extends DrupalMonitoringBase implements DrupalMonitoringInterface, ContainerFactoryPluginInterface
{

  /**
   * @var Connection
   */
  private $database;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, Connection $connection)
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->database = $connection;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('database')
    );
  }

    /**
     * @inheritDoc
     */
    public function fetch()
    {
      $dbinfos = $this->database->getConnectionOptions();
      $dbName = $dbinfos['database'];

      $query = $this->database->query('SELECT SUM(data_length + index_length) / 1024 / 1024
        AS "size"
        FROM information_schema.TABLES
        WHERE table_schema = :drupalDbName
        GROUP BY table_schema',
        [':drupalDbName' => $dbName]);

      $result = $query->fetch(\PDO::FETCH_ASSOC);

      return $result;
    }


}
