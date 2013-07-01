<?php

require_once 'eventcalender.civix.php';

/**
 * Implementation of hook_civicrm_config
 */
function eventcalender_civicrm_config(&$config) {
  _eventcalender_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 */
function eventcalender_civicrm_xmlMenu(&$files) {
  _eventcalender_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 */
function eventcalender_civicrm_install() {
  $cividiscountRoot = dirname(__FILE__) . DIRECTORY_SEPARATOR;
  $cividiscountSQL = $cividiscountRoot . DIRECTORY_SEPARATOR . 'install.sql';

  CRM_Utils_File::sourceSQLFile(CIVICRM_DSN, $cividiscountSQL);

  // rebuild the menu so our path is picked up
  CRM_Core_Invoke::rebuildMenuAndCaches();
 // return _eventcalender_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 */
function eventcalender_civicrm_uninstall() {
  $cividiscountRoot = dirname(__FILE__) . DIRECTORY_SEPARATOR;
  $cividiscountSQL = $cividiscountRoot . DIRECTORY_SEPARATOR . 'uninstall.sql';

  CRM_Utils_File::sourceSQLFile(CIVICRM_DSN, $cividiscountSQL);

  // rebuild the menu so our path is picked up
  CRM_Core_Invoke::rebuildMenuAndCaches();
  //return _eventcalender_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 */
function eventcalender_civicrm_enable() {
  return _eventcalender_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 */
function eventcalender_civicrm_disable() {
  return _eventcalender_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 */
function eventcalender_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _eventcalender_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 */
function eventcalender_civicrm_managed(&$entities) {
  return _eventcalender_civix_civicrm_managed($entities);
}
