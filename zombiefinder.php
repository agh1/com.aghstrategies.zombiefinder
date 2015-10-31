<?php

require_once 'zombiefinder.civix.php';

/**
 * Implementation of hook_civicrm_check().
 *
 * Add a check to the status page/System.check results if $snafu is TRUE.
 */
function zombiefinder_civicrm_check(&$messages) {
  // The API should be able to provide this (as below), but there are problems
  // in both 4.6 and 4.7 with finding privacy preferences (Do not mail, etc.)
  // that are null using the API.
  //
  // try {
  //   $result = civicrm_api3('Contact', 'getcount', array(
  //     'is_deceased' => array('IS NULL' => 1),
  //   ));
  // }
  // catch (CiviCRM_API3_Exception $e) {
  //   CRM_Core_Error::debug_log_message($e->getMessage());
  // }

  // Check for zombies.
  $fieldsToCheck = CRM_Core_SelectValues::privacy();
  $fieldsToCheck['is_deceased'] = ts('Is Deceased');
  $fieldsToCheck['is_deleted'] = ts('Deleted');
  $found = array();
  foreach ($fieldsToCheck as $fieldName => $displayName) {
    $sql = "SELECT COUNT(id) FROM civicrm_contact WHERE {$fieldName} IS NULL";
    if (CRM_Core_DAO::singleValueQuery($sql)) {
      $found[] = $displayName;
    }
  }

  if (count($found)) {
    $tsParams = array(
      1 => implode(', ', $found),
      2 => 'http://civicrm.stackexchange.com/a/7396/44',
      'domain' => 'com.aghstrategies.zombiefinder',
    );
    $details = ts('Zombies found.  You have contacts who are undead or have null privacy options.  One or more contacts have null values in the following fields: %1.  <a href="%2">Read more about how to solve this.</a>', $tsParams);

    $messages[] = new CRM_Utils_Check_Message(
      'zombiefinder_found',
      $details,
      ts('Gaaargh! Braaaains!', array('domain' => 'com.aghstrategies.zombiefinder')),
      \Psr\Log\LogLevel::WARNING,
      'fa-user-times'
    );

  }
}

/**
 * Implementation of hook_civicrm_config
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function zombiefinder_civicrm_config(&$config) {
  _zombiefinder_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function zombiefinder_civicrm_xmlMenu(&$files) {
  _zombiefinder_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function zombiefinder_civicrm_install() {
  _zombiefinder_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function zombiefinder_civicrm_uninstall() {
  _zombiefinder_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function zombiefinder_civicrm_enable() {
  _zombiefinder_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function zombiefinder_civicrm_disable() {
  _zombiefinder_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function zombiefinder_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _zombiefinder_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function zombiefinder_civicrm_managed(&$entities) {
  _zombiefinder_civix_civicrm_managed($entities);
}

/**
 * Implementation of hook_civicrm_caseTypes
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function zombiefinder_civicrm_caseTypes(&$caseTypes) {
  _zombiefinder_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implementation of hook_civicrm_alterSettingsFolders
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function zombiefinder_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _zombiefinder_civix_civicrm_alterSettingsFolders($metaDataFolders);
}
