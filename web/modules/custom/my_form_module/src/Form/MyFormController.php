<?php
namespace Drupal\my_form_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class MyFormController extends FormBase{
  
   
    public function getFormId() {
        return 'example_form';
    }

  
    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['name'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Name'),
            '#required' => true,
        ];
        $form['email'] = [
            '#type' => 'email',
            '#title' => $this->t('Email'),
            '#required' => true,
        ];
       
        $form['phone'] = [
            '#type' => 'tel',
            '#title' => $this->t('Phone'),
            '#required' => true,
        ];

         $form['message'] = [
            '#type' => 'textarea',
            '#title' => $this->t('Message'),
            '#required' => true,
            '#maxlength' => 250,
        ];
        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Save'),
            '#button_type' => 'primary',
        ];
        return $form;
    }

  
    public function validateForm(array &$form, FormStateInterface $form_state) {
        $this->validatePhone($form, $form_state);
        $this->validateName($form,$form_state);
    }

  
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $this->messenger()->addStatus($this->t('Your name is @name', ['@name' => $form_state->getValue('name')]));
        $this->messenger()->addStatus($this->t('Your email is @email', ['@email' => $form_state->getValue('email')]));
        $this->messenger()->addStatus($this->t('Your phone is @phone', ['@phone' => $form_state->getValue('phone')]));
        $this->messenger()->addStatus($this->t('Your message is @message', ['@message' => $form_state->getValue('message')]));
    }



    private function validatePhone(array &$form, FormStateInterface $form_state) {

        if ($this->validatePhoneNumberFormat($form_state->getValue('phone')) === false) {
            $form_state->setErrorByName('phone', $this->t('The phone is in the wrong format'));
        }
    }

    private function validateName(array &$form, FormStateInterface $form_state) {

        if (strlen($form_state->getValue('name')) < 3) {
            $form_state->setErrorByName('name', $this->t('The name field must be longer than 3 characters'));
        }
    }

    private function validatePhoneNumberFormat(string $phone) {
        $regexPhone = '/^\d{10,}$/';
        if (preg_match($regexPhone, $phone)) {
            return true;
        }
        else {
            return false;
        }
    }
}