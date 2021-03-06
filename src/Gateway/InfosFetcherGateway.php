<?php

namespace Drupal\adimeo_drupal_monitoring\Gateway;


use Drupal\adimeo_drupal_monitoring\Gateway\Interfaces\FetcherInterface;
use Drupal\Core\Database\Connection;
use Drupal\system\SystemManager;
use Drupal\update\UpdateManagerInterface;


class InfosFetcherGateway implements FetcherInterface
{

    /**
     * @var UpdateManagerInterface
     */
    private $updateManager;
    /**
     * @var SystemManager
     */
    private $systemManager;
    /**
     * @var Connection
     */
    private $database;

    public function __construct(UpdateManagerInterface $updateManager, SystemManager $systemManager,
                                Connection             $database)
    {

        $this->updateManager = $updateManager;
        $this->systemManager = $systemManager;
        $this->database = $database;
    }


    public function fetchData()
    {
        $siteData = $this->fetchSiteInfos();
        $updates = $this->fetchAvailableUpdates();
        $dbSize = $this->fetchDbSize();
        $errors = $this->fetchDashboardErrors();
        $diskUsage = $this->fetchStorageUsed();
        $drupalVersion = $this->fetchDrupalVersion();
        $listOfModules = $this->fetchListOfModules();
        $databaseVersion = $this->fetchDatabaseVersion();
        $phpVersion = $this->fetchPhpVersion();

        return [
            'infos' => $siteData,
            'updates' => $updates,
            'databaseSize' => $dbSize,
            'dashboardErrors' => $errors,
            'drupalVersion' => $drupalVersion,
            'listOfModules' => $listOfModules,
            'databaseVersion' => $databaseVersion,
            'phpVersion' => $phpVersion,
            'storageUsage' => [
                'diskUsage' => $diskUsage[0],
                'path' => $diskUsage[1],
            ],
        ];

    }

    /**
     * Retrieve basic site infos
     *
     * @return array
     */
    public function fetchSiteInfos()
    {
        $siteData = array();
        $config = \Drupal::config('system.site');
        $siteData = $config->get();

        return $siteData;
    }

    /**
     * Retrieve version of drupal site
     *
     * @return string
     */
    public function fetchDrupalVersion()
    {
        $drupalVersion = \Drupal::VERSION;

        return $drupalVersion;
    }

    /**
     * Retrieve list of modules
     *
     * @return string
     */
    public function fetchListOfModules()
    {
        $listOfModules = \Drupal::service('extension.list.module')->getAllInstalledInfo();

        return $listOfModules;
    }


    /**
     * Retrieve all available updates for Drupal and contributed modules
     *
     * @return array
     */
    public function fetchAvailableUpdates()
    {
        $projects = $this->updateManager->projectStorage('update_project_data');

        $availableUpdates = array();
        foreach ($projects as $project) {
            if ($project['existing_version'] != $project['latest_version']) {
                $availableUpdates[] = $project;
            }
        }

        return $availableUpdates;

    }

    /**
     * Retrieve size of the drupal database in MB
     *
     * @return array
     */
    public function fetchDbSize()
    {
        $dbinfos = $this->database->getConnectionOptions();
        $dbName = $dbinfos['database'];

        $query = $this->database->query('SELECT SUM(data_length + index_length) / 1024 / 1024
        AS "size"
        FROM information_schema.TABLES
        WHERE table_schema = :drupalDbName
        GROUP BY table_schema',
            [':drupalDbName' => $dbName]);

        $result = (array)$query->fetch();

        return $result;


    }

    /**
     * Retrieve errors showed on the Dashboard
     *
     * @return array
     */
    public function fetchDashboardErrors()
    {

        $requirements = $this->systemManager->listRequirements();

        $errors = array();
        // loop through to find errors
        foreach ($requirements as $requirement) {
            if (!empty($requirement['severity']) && $requirement['severity'] === 2) {
                $errors[] = $requirement;
            }
        }

        return $errors;
    }

    /**
     * Retrieve size of dir sites/default/files
     *
     * @return string
     */
    public function fetchStorageUsed()
    {
        /** @var \Drupal\Core\File\FileSystem $service */
        $service = \Drupal::service('file_system');

        $filesize = exec('du -sh ' . $service->realpath('public://'));

        //$filesize = explode('/[\t]/', $filesize);
        $filesize = preg_split('/[\t]/', $filesize);
        return $filesize;

    }


    /**
     * Return version name of database
     *
     * @return string
     */
    private function fetchDatabaseVersion()
    {
        $serviceDb = \Drupal::service('database');

        return $serviceDb->version();
    }

    /**
     * Return version php of site
     *
     * @return string
     */
    private function fetchPhpVersion()
    {
        return phpversion();
    }
}
