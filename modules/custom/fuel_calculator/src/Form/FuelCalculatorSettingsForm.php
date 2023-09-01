<?php

namespace Drupal\fuel_calculator\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements the module configuration form.
 */
class FuelCalculatorSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'fuel_calculator_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['fuel_calculator.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('fuel_calculator.settings');

    $form['default_distance'] = [
      '#type' => 'number',
      '#title' => $this->t('Default Distance Traveled'),
      '#default_value' => $config->get('default_distance'),
    ];

    $form['default_fuel'] = [
      '#type' => 'number',
      '#title' => $this->t('Default Fuel Consumption'),
      '#default_value' => $config->get('default_fuel'),
    ];

    $form['default_price_per_liter'] = [
      '#type' => 'number',
      '#title' => $this->t('Default Price Per Liter'),
      '#default_value' => $config->get('default_price_per_liter'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('fuel_calculator.settings');
    $config->set('default_distance', $form_state->getValue('default_distance'))
      ->set('default_fuel', $form_state->getValue('default_fuel'))
      ->set('default_price_per_liter', $form_state->getValue('default_price_per_liter'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}
