<?php

namespace Drupal\credly\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\custom_guzzle_request\Http\CustomGuzzleHttp;
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

    $SavedAdminUsername = \Drupal::config('system.site')->get('siteadmincredlyusername');
    $SavedAdminPassword = \Drupal::config('system.site')->get('siteadmincredlypassword');
    $SavedAppApiKey = \Drupal::config('system.site')->get('siteadmincredlyapikey');
    $SavedAppApiSecret = \Drupal::config('system.site')->get('siteadmincredlysecret');

    $form['credly_admin_username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Credly Admin Username'),
      '#description' => $this->t('Enter username for credly account from which App is created'),
      '#default_value' => $SavedAdminUsername,
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
    ];
    $form['credly_admin_password'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Credly Admin Password'),
      '#description' => $this->t('Enter password for credly account from which app is created in credly'),
      '#default_value' => $SavedAdminPassword,
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
    ];
    $form['credly_app_api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Credly App API Key'),
      '#description' => $this->t('Open this URl https://developers.credly.com/my-apps copy API key and enter here'),
      '#default_value' => $SavedAppApiKey,
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
    ];
    $form['credly_api_secret'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Credly API Secret'),
      '#description' => $this->t('Open the URL https://developers.credly.com/my-app copy the Seceret Key and enter here'),
      '#default_value' => $SavedAppApiSecret,
      '#weight' => '0',
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Configure Admin Account'),
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
    $AdminUsername = $form_state->getValue('credly_admin_username');
    $AdminPassword = $form_state->getValue('credly_admin_password');
    $AppApiKey = $form_state->getValue('credly_app_api_key');
    $AppApiSecret = $form_state->getValue('credly_api_secret');
    $inject_config = \Drupal::service('config.factory')->getEditable('system.site');
    // Setting and saving site api key value if its something different from default value.
    $inject_config->set('siteadmincredlyusername', $AdminUsername)->save();
    $inject_config->set('siteadmincredlypassword', $AdminPassword)->save();
    $inject_config->set('siteadmincredlyapikey', $AppApiKey)->save();
    $inject_config->set('siteadmincredlysecret', $AppApiSecret)->save();

    $check = new CustomGuzzleHttp();
    $params = array();
    $params['email'] = $AdminUsername; //"vishal.sirsodiya@webdunia.net"; //
    $params['password'] = $AdminPassword;
    $api_url = "https://api.credly.com/v1.1/authenticate"; 
    //$api_url = adrenna_credly_endpoint()."me/password";   
    //$api_result =  adrenna_credly_rest('POST', $api_url, $params, $apiKey, $apiSecret);
    $response = $check->performRequest('Post', $api_url, $AppApiKey, $AppApiSecret, $params);
    print_r($response);
    die(ewewf);

  }

}
