<?php

namespace Drupal\adimeo_drupal_monitoring\Manager;

use Drupal\adimeo_drupal_monitoring\Manager\Interfaces\MonitoringProcessingInterface;
use Drupal\Core\Mail\MailManagerInterface;
use Drupal\Core\Render\Renderer;

class MailManager implements MonitoringProcessingInterface
{
  /**
   * @var MailManagerInterface
   */
  private $mailManager;
  /**
   * @var Renderer
   */
  private $renderer;


  private static function SITE_NAME()
  {
    return \Drupal::config('system.site')->get('name');
  }

  private static function LANGCODE()
  {
    return \Drupal::config('system.site')->get('langcode');
  }

  const MODULE = 'adimeo_drupal_monitoring';
  const KEY = 'adimeo_drupal_monitoring_mail';
  const TO = 'nicofabing@gmail.com';
  const REPLY = null;
  const SEND = TRUE;

  public function __construct(MailManagerInterface $mailManager, Renderer $renderer)
  {

    $this->mailManager = $mailManager;
    $this->renderer = $renderer;
  }

  private function prepareMail($message)
  {
    // defining email parameters
    $render = [
      '#theme' => 'drupal_monitoring_mail',
      '#message' => $message,
    ];

    $params['message'] = $this->renderer->renderRoot($render);
    $params['subject'] = t('Daily monitoring for : @sitename', array('@sitename' => self::SITE_NAME()));
    $params['options']['username'] = 'Admin';

    return $params;
  }

  private function sendMail(array $params)
  {
    $result = $this->mailManager->mail(self::MODULE, self::KEY, self::TO,
      self::LANGCODE(), $params, self::REPLY, self::SEND);

    // check if email was send and log the result
    if ($result['result'] == true) {
      \Drupal::logger('monitoring_cron')->info('Daily monitoring email was sent successfully');
    } else {
      \Drupal::logger('monitoring_cron')->info('Daily monitoring email could not be send');
    }


  }


  public function send(array $data)
  {

    $mailParams = $this->prepareMail($data);
    $this->sendMail($mailParams);


  }


}
