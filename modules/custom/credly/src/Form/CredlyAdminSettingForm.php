<?php

namespace Drupal\credly\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class CredlyAdminSettingForm.
 */
class CredlyAdminSettingForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'credly_admin_setting_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['credly_admin_username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Credly Admin Username'),
      '#description' => $this->t('Enter username for credly account from which App is created'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
    ];
    $form['credly_admin_password'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Credly Admin Password'),
      '#description' => $this->t('Enter password for credly account from which app is created in credly'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
    ];
    $form['credly_app_api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Credly App API Key'),
      '#description' => $this->t('Open this URl https://developers.credly.com/my-apps copy API key and enter here'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
    ];
    $form['credly_api_secret'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Credly API Secret'),
      '#description' => $this->t('Open the URL https://developers.credly.com/my-app copy the Seceret Key and enter here'),
      '#weight' => '0',
    ];
    $form['configure_admin_account'] = [
      '#type' => 'Submit',
      '#title' => $this->t('Configure Admin Account'),
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
