<?php

namespace Drupal\sitedetails\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class AdminConfigurationForm extends ConfigFormBase {

  /**
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'adminconfig.settings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'admin_configuration_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);

    $form['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#default_value' => $config->get('country'),
    ];

    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#default_value' => $config->get('city'),
    ];

    // The values for the dropdown box.
    $form['timezoneoptions'] = [
      '#type' => 'value',
      '#value' => [
        'America/Chicago' => $this->t('America/Chicago'),
        'America/New_York' => $this->t('America/New_York'),
        'Asia/Tokyo' => $this->t('Asia/Tokyo'),
        'Asia/Dubai' => $this->t('Asia/Dubai'),
        'Asia/Kolkata' => $this->t('Asia/Kolkata'),
        'Europe/Amsterdam' => $this->t('Europe/Amsterdam'),
        'Europe/Oslo' => $this->t('Europe/Oslo'),
      ],
    ];
    $form['timezone'] = [
      '#title' => $this->t('Time Zone List'),
      '#type' => 'select',
      '#options' => $form['timezoneoptions']['#value'],
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration.
    $this->configFactory->getEditable(static::SETTINGS)
            // Set the submitted configuration setting.
      ->set('country', $form_state->getValue('country'))
      ->set('city', $form_state->getValue('city'))
      ->set('timezone', $form_state->getValue('timezone'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
