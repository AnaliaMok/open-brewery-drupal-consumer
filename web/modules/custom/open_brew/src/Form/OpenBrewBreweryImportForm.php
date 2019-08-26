<?php

namespace Drupal\open_brew\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\open_brew\OpenBrewConnection;

/**
 * Class OpenBrewBreweryImportForm.
 */
class OpenBrewBreweryImportForm extends FormBase {

  /**
   * Drupal\open_brew\OpenBrewConnection definition.
   *
   * @var \Drupal\open_brew\OpenBrewConnection
   */
  protected $openBrewConnection;

  /**
   * Constructs a new OpenBrewBreweryImportForm object.
   */
  public function __construct(
    OpenBrewConnection $open_brew_connection
  ) {
    $this->openBrewConnection = $open_brew_connection;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('open_brew.connection')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'open_brew_brewery_import_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
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
    foreach ($form_state->getValues() as $key => $value) {
      // @TODO: Validate fields.
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    foreach ($form_state->getValues() as $key => $value) {
      \Drupal::messenger()->addMessage($key . ': ' . ($key === 'text_format'?$value['value']:$value));
    }
  }

}
