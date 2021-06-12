<?php

namespace Drupal\sitedetails;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Datetime\DateFormatter;

/**
 * Timeservice is a service to fetch time based on timezone.
 */
class TimeService {
  /**
   * Declare timezone as variable.
   *
   * @var Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $config;

  /**
   * Declare country as variable.
   *
   * @var \Drupal\sitedetails\TimeService\country
   */
  protected $country;

  /**
   * Declare city as variable.
   *
   * @var \Drupal\sitedetails\TimeService\city
   */
  protected $city;

  /**
   * Declare timezone as variable.
   *
   * @var \Drupal\sitedetails\TimeService\timezone
   */
  protected $timezone;
  /**
   * Declare timeService as variable.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $timeService;

  /**
   * Declare dateformat as variable.
   *
   * @var \Drupal\Core\Datetime\DateFormatter
   */
  protected $dateformat;

  /**
   * Part of the DependencyInjection magic happening here.
   */
  public function __construct(
    ConfigFactoryInterface $config,
    TimeInterface $time_service,
    DateFormatter $date_formatter
  ) {
    $this->config = $config;
    $this->country = $this->config->getEditable('adminconfig.settings')->get('country');
    $this->city = $this->config->getEditable('adminconfig.settings')->get('city');
    $this->timezone = $this->config->getEditable('adminconfig.settings')->get('timezone');
    $this->timeService = $time_service;
    $this->dateformat = $date_formatter;
  }

  /**
   * Returns locationdetails.
   */
  public function getLocationDetails() {
    $location['country'] = $this->config->getEditable('adminconfig.settings')->get('country');
    $location['city'] = $this->config->getEditable('adminconfig.settings')->get('city');
    $location['current_time'] = $this->dateformat->format($this->timeService->getRequestTime(), 'custom', 'jS M Y - h:i A', $this->timezone);
    return $location;
  }

}
