<?php

namespace Drupal\credly\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class CredlyUserCredentials.
 */
class CredlyUserCredentials extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'credly_user_credentials';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['CredlyUsername'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Credly Username'),
      '#description' => $this->t('Please enter your credly authenticated username/email here'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
    ];
    $form['CredlyPassword'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Credly Password'),
      '#description' => $this->t('Please enter your credly authenticated password here'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    foreach ($form_state->getValues() as $key => $value) {
      drupal_set_message($key . ': ' . $value);
    }

  }

}
