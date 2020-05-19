<?php

namespace Drupal\ex81\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class HelloForm extends FormBase {

  
  public function getFormId() {
    return 'ex81_hello_form';
  }

  
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['description'] = [
      '#type' => 'item',
      '#markup' => $this->t('Please enter the title and accept the terms of use of the site.'),
    ];

    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#description' => $this->t('Enter the title of the book. Note that the title must be at least 10 characters in length.'),
      '#required' => TRUE,
    ];

    $form['accept'] = [
      '#type' => 'checkbox',
      '#title' => $this
        ->t('I accept the terms of use of the site'),
      '#description' => $this->t('Please read and accept the terms of use'),
    ];

   
    $form['actions'] = [
      '#type' => 'actions',
    ];

    
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;

  }

 
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);

    $title = $form_state->getValue('title');
    $accept = $form_state->getValue('accept');

    if (strlen($title) < 10) {
      
      $form_state->setErrorByName('title', $this->t('The title must be at least 10 characters long.'));
    }

    if (empty($accept)) {
      
      $form_state->setErrorByName('accept', $this->t('You must accept the terms of use to continue'));
    }

  }

 
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $messenger = \Drupal::messenger();
    $messenger->addMessage('Title: ' . $form_state->getValue('title'));
    $messenger->addMessage('Accept: ' . $form_state->getValue('accept'));
	$form_state->setRedirect('<front>');
  }

}
