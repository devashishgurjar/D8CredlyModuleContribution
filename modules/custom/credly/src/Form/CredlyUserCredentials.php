<?php

namespace Drupal\credly\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use \GuzzleHttp\Exception\RequestException;

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
    // Save result.
    $UserData = \Drupal::currentUser();
    $UserId = $UserData->id();
    $Username = $form_state->getValue('CredlyUsername');
    $UserPassword = $form_state->getValue('CredlyPassword');
    $DatabaseValues = array(
            'uid' =>  $UserId,
            'CredlyUsername' => $Username,
            'CredlyPassword' =>  $UserPassword,
    );
    $database = \Drupal::database();

    $url = CredlyApiEndpoint()."authenticate";
    $AppApiSecret = \Drupal::config('system.site')->get('siteadmincredlysecret');
    $AppApiKey = \Drupal::config('system.site')->get('siteadmincredlyapikey');
    $StatusCode = credlyApiCall($AppApiSecret, $AppApiKey , $Username, $UserPassword, $url);

    if ($StatusCode == 'TRUE') {
        $HasUserInformation = $database->select('CredlyUserCredentialsInfo', 'n')
        ->fields('n')
        ->condition('uid', $UserId,'=')
        ->execute()
        ->fetchAssoc();
      if(!$HasUserInformation){
          $database->insert('CredlyUserCredentialsInfo')
                ->fields($DatabaseValues)
                ->execute();
          $this->messenger()->addMessage($this->t('Credly Authentication done Successfully, Credly Badge will be displayed on your dashboard'));
        }else{
          $database->update('CredlyUserCredentialsInfo')
                ->fields($DatabaseValues)
                ->condition('uid', $UserId,'=')
                ->execute();
          $this->messenger()->addMessage($this->t('Credly Authentication detials updated Successfully, Credly Badge will be displayed on your dashboard'));
        }      
      }else{
      $this->messenger()->addError($this->t('Credly Authentication failed, returning the following error: %token', ['%token' => $StatusCode]));
    }
  }
}
