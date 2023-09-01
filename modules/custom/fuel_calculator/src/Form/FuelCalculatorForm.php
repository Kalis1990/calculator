<?php

namespace Drupal\fuel_calculator\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements a fuel consumption calculator form.
 */
class FuelCalculatorForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'fuel_calculator_form';
  }

  /**
   * {@inheritdoc}
   */
  
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Form elements
    $form['distance'] = [
      '#type' => 'number',
      '#title' => $this->t('Distance Traveled'),
      '#required' => TRUE,
    ];
    
    $form['fuel'] = [
      '#type' => 'number',
      '#title' => $this->t('Fuel Consumption'),
      '#required' => TRUE,
      '#step' => '0.01',  

    ];

    $form['price_per_liter'] = [
      '#type' => 'number',
      '#title' => $this->t('Price Per Liter'),
      '#required' => TRUE,
      '#step' => '0.01',  
    ];
    
    
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Calculate'),
    ];
    
    // $form['reset'] = [
    //   '#type' => 'submit',
    //   '#value' => $this->t('Reset'),
    //   '#submit' => ['::resetResults', '::resetForm'],
    // ];

    $form['reset'] = [
      '#type' => 'submit',
      '#value' => $this->t('Reset'),
      '#submit' => ['::resetFormValues'],
      '#limit_validation_errors' => [],
    ];
    
    
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  //  
  public function resetFormValues(array &$form, FormStateInterface $form_state) {
    \Drupal::state()->delete('fuel_calculator.fuel_consumption');
    \Drupal::state()->delete('fuel_calculator.fuel_spend');

    // Rebuild the form and results block.
    $form_state->setRebuild(TRUE);
}

  
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $distance = $form_state->getValue('distance');
    $fuel = $form_state->getValue('fuel');
    $price_per_liter = $form_state->getValue('price_per_liter');
    
    $fuel_consumption = ($distance / 100) * $fuel;
    $fuel_spend = $fuel_consumption * $price_per_liter; // Total cost of fuel spent

    // Save calculation details in logs
    \Drupal::logger('fuel_calculator')->notice(
        'Calculation by user @user: Fuel consumption: @consumption L/100km, Total fuel cost: @spend eu',
        [
            '@user' => \Drupal::currentUser()->getDisplayName(),
            '@consumption' => $fuel_consumption,
            '@spend' => $fuel_spend,
        ]
    );

    \Drupal::state()->set('fuel_calculator.fuel_consumption', $fuel_consumption);
    \Drupal::state()->set('fuel_calculator.fuel_spend', $fuel_spend);
      $js_data = [
        'fuel_consumption' => $fuel_consumption,
        'fuel_spend' => $fuel_spend,
      ];
    
      // Attach data to drupalSettings
    //   $form_state->set('fuel_calculator_js_data', $js_data);
    // }
    // function fuel_calculator_preprocess_block(&$variables) {
    //   // Fetch the stored JavaScript data from the form state
    //   $js_data = \Drupal::request()->attributes->get('form')->getState()->get('fuel_calculator_js_data');
      
    //   // Attach data to drupalSettings
    //   $variables['#attached']['drupalSettings']['fuelCalculatorData'] = $js_data;
    


    // // Set rebuild to display the form with results
    $form_state->setRebuild(TRUE);
    }

    public function resetForm(array &$form, FormStateInterface $form_state) {
      $form_state->set('fuel_consumption', NULL);
      $form_state->set('fuel_spend', NULL);
      $form_state->setRebuild();
    
    }
    

  }
