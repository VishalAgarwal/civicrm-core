<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.6                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2015                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
 */

/**
 *
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2015
 * $Id$
 *
 */

/**
 * BAO object for civicrm_webtracking table
 */
class CRM_Core_BAO_WebTracking extends CRM_Core_DAO_WebTracking {

  /**
   * Takes an associative array and creates a webtracking object.
   *
   * @param array $params
   *   (reference) an assoc array of name/value pairs.
   *
   * @return object
   *   $webtracking CRM_Core_BAO_WebTracking object
   */
  public static function &add(&$params) {
    $webtracking = new CRM_Core_DAO_WebTracking();
    $webtracking->copyValues($params);
    $webtracking->save();
    return $webtracking;
  }


 /**
   * Fetch object based on array of properties.
   *
   * @param array $params
   *   (reference ) an assoc array of name/value pairs.
   * @param array $defaults
   *   (reference ) an assoc array to hold the flattened values.
   *
   * @return CRM_Core_BAO_WebTracking
   */
  public static function retrieve(&$params, &$defaults) {   
    $webtracking = new CRM_Core_BAO_WebTracking();
    $webtracking->copyValues($params);
    if ($webtracking->find(TRUE)) {
      CRM_Core_DAO::storeValues($webtracking, $defaults);
      return $webtracking;
    }
    return NULL;
  }


  /**
   * Given the list of params in the params array, fetch the object
   * and store the values in the values array
   *
   * @param array $params
   *   Input parameters to find object.
   * @param array $values
   *   Output values of the object.
   * @param int $numNotes
   *   The maximum number of notes to return (0 if all).
   *
   * @return object
   *   $notes  Object of CRM_Core_BAO_Note
   */
  public static function &getValues(&$params, &$values, $numNotes = self::MAX_NOTES) {
    if (empty($params)) {
      return NULL;
    }
    $note = new CRM_Core_BAO_Note();
    $note->entity_id = $params['contact_id'];
    $note->entity_table = 'civicrm_contact';

    // get the total count of notes
    $values['noteTotalCount'] = $note->count();

    // get only 3 recent notes
    $note->orderBy('modified_date desc');
    $note->limit($numNotes);
    $note->find();

    $notes = array();
    $count = 0;
    while ($note->fetch()) {
      $values['note'][$note->id] = array();
      CRM_Core_DAO::storeValues($note, $values['note'][$note->id]);
      $notes[] = $note;

      $count++;
      // if we have collected the number of notes, exit loop
      if ($numNotes > 0 && $count >= $numNotes) {
        break;
      }
    }

    return $notes;
  }

  /**
   * Delete the notes.
   *
   * @param int $id
   *   Note id.
   * @param bool $showStatus
   *   Do we need to set status or not.
   *
   * @return int|NULL
   *   no of deleted notes on success, null otherwise
   */
  public static function del($id, $showStatus = TRUE) {
    $return = NULL;
    $recent = array($id);
    $note = new CRM_Core_DAO_Note();
    $note->id = $id;
    $note->find();
    $note->fetch();
    if ($note->entity_table == 'civicrm_note') {
      $status = ts('Selected Comment has been deleted successfully.');
    }
    else {
      $status = ts('Selected Note has been deleted successfully.');
    }

    // Delete all descendents of this Note
    foreach (self::getDescendentIds($id) as $childId) {
      $childNote = new CRM_Core_DAO_Note();
      $childNote->id = $childId;
      $childNote->delete();
      $childNote->free();
      $recent[] = $childId;
    }

    $return = $note->delete();
    $note->free();
    if ($showStatus) {
      CRM_Core_Session::setStatus($status, ts('Deleted'), 'success');
    }

    // delete the recently created Note
    foreach ($recent as $recentId) {
      $noteRecent = array(
        'id' => $recentId,
        'type' => 'Note',
      );
      CRM_Utils_Recent::del($noteRecent);
    }
    return $return;
  }

}
