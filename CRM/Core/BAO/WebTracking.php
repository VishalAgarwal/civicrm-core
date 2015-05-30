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
   * Delete the webtracking entry.
   *
   * @param int $page_id
   *   Note id.
   * @param string $page_category
   *
   * @return void
   * 
   */
  public static function del($page_id, $page_category) {

    $webtracking = new CRM_Core_DAO_WebTracking();
    $webtracking->page_id = $page_id;
    $webtracking->page_category = $page_category;
    $webtracking->find();
    $webtracking->delete();
    $webtracking->free();
  } 
}
