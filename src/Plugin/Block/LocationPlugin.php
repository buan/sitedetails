<?php

namespace Drupal\sitedetails\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\sitedetails\TimeService;
use Drupal\Core\Cache\Cache;

/**
 * Provides a 'Location Details' block.
 *
 * @Block(
 *  id = "locationplugin",
 *  admin_label = @Translation("Location Details"),
 * )
 */
class LocationPlugin extends BlockBase implements ContainerFactoryPluginInterface {
  /**
   * Declare TimeService as variable.
   *
   * @var \Drupal\sitedetails\TimeService
   */
  protected $timeService;

  /**
   * Declaring the parameters.
   *
   * @param array $configuration
   *   Configuration.
   * @param string $plugin_id
   *   Plugin Id.
   * @param mixed $plugin_definition
   *   Plugin Definition.
   * @param \Drupal\sitedetails\TimeService $timeService
   *   Timeservice.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, TimeService $timeService) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->timeService = $timeService;
  }

  /**
   * Declaring the parameters.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   Container.
   * @param array $configuration
   *   Configuration.
   * @param string $plugin_id
   *   Plugin Id.
   * @param mixed $plugin_definition
   *   Plugin Definition.
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('sitedetails.findtime')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#theme' => 'locationtemplate',
      '#items' => $this->timeService->getLocationDetails(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    return Cache::mergeTags(parent::getCacheTags(), ['block:' . strtotime('now')]);
  }

}
