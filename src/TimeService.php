<?php

namespace Drupal\sitedetails;

use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Timeservice is a service to fetch time based on timezone.
 */
class TimeService {
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
   * Part of the DependencyInjection magic happening here.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $config = $config_factory->get('adminconfig.settings');
    $this->timezone = $config->get('timezone');
    $this->country = $config->get('country');
    $this->city = $config->get('city');
  }

  /**
   * Returns locationdetails.
   */
  public function getLocationDetails() {
    $date = new \DateTime("now", new \DateTimeZone($this->timezone));
    $locationdetails = [];
    $locationdetails['country'] = $this->country;
    $locationdetails['city'] = $this->city;
    $locationdetails['current_time'] = $date->format('jS M Y - h:i A');
    return $locationdetails;
  }

}
