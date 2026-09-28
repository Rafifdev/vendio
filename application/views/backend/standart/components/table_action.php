<?php
/**
 * Vendio Standard Reusable Table Action Component
 *
 * Usage via Partial View:
 *   $this->load->view('backend/standart/components/table_action', [
 *       'actions' => [
 *           'view' => ['url' => site_url('...'), 'permission' => '...'],
 *           'edit' => ['url' => site_url('...'), 'permission' => '...'],
 *           'delete' => ['data_href' => site_url('...'), 'permission' => '...']
 *       ],
 *       'options' => ['force_dropdown' => false]
 *   ]);
 *
 * Or directly via Helper:
 *   <?= render_table_action($actions, $options); ?>
 */
$actions_data = isset($actions) && is_array($actions) ? $actions : [];
$options_data = isset($options) && is_array($options) ? $options : [];

echo render_table_action($actions_data, $options_data);
