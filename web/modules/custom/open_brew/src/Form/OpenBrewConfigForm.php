<?php

namespace Drupal\open_brew\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class OpenBrewConfigForm.
 */
class OpenBrewConfigForm extends ConfigFormBase
{
  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames()
  {
    return [
      'open_brew.openbrewconfig',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'open_brew_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $config = $this->config('open_brew.openbrewconfig');
    $state  = \Drupal::state();

    $form['open_brew'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('OpenBrew Settings'),
    ];

    $form['open_brew']['base_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('OpenBrew API URL'),
      '#default_value' => $config->get('open_brew.base_url'),
    ];

    $nums   = [
      5, 10, 25, 50, 75, 100, 150, 200, 250, 300, 400, 500, 600, 700, 800, 900,
    ];

    $limits = array_combine($nums, $nums);

    $form['open_brew']['cron_download_limit'] = [
      '#type' => 'select',
      '#title' => $this->t('Cron API Download Limit'),
      '#options' => $limits,
      '#default_value' => $state->get('open_brew.cron_download_limit', 100),
    ];

    $form['open_brew']['cron_process_limit'] = [
      '#type' => 'select',
      '#title' => $this->t('Cron QuThrottle'),
      '#options' => $limits,
      '#default_value' => $state->get('open_brew.cron_process_limit', 25),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $values = $form_state->getValues();
    $config = $this->config('open_brew.openbrewconfig');
    $state = \Drupal::state();

    $config->set('open_brew.base_url', $values['base_url']);
    $config->save();

    $state->set('open_brew.cron_download_limit', $values['cron_download_limit']);
    $state->set('open_brew.cron_process_limit', $values['cron_process_limit']);
  }
}
