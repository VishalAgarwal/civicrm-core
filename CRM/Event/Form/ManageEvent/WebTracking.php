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
 *
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2015
 * $Id$
 *
 */

/**
 * This class generates form components for processing Event Web Tracking
 *
 */
class CRM_Event_Form_ManageEvent_WebTracking extends CRM_Event_Form_ManageEvent {

  /**
   * Set variables up before form is built.
   *
   * @return void
   */
  public function preProcess() {
    parent::preProcess();   // ##why is this function called or rather what does this do?
  }

  /**
   * Set default values for the form. For edit/view mode
   * the default values are retrieved from the database
   *
   *
   * @return void
   */
  public function setDefaultValues() {
   
    //## Will have to set the even_id in params 
    $params['page_id']=$this->_id;
    $params['page_category']="civicrm_event";
    $defaults = array();
    CRM_Core_BAO_WebTracking::retrieve($params,$defaults);
    return $defaults;
  }

  /**
   * Build the form object.
   *
   * @return void
   */
  public function buildQuickForm() {

    $this->applyFilter('__ALL__', 'trim'); // ## what does this function do?

    //## Create a checkbox to ask whether or not to enable web tracking
    $this->addElement('checkbox', 'enable_tracking', ts('Enable WebTracking?'));

    //## UAID
     $this->add('text', 'tracking_id', ts('Tracking ID'));

    //## Custom Event Tracking 
    //$this->addElement('checkbox', 'custom_event_tracking', ts('Enable CustomEventTracking?'));

    //## E-Commerce Tracking 
    //$this->addElement('checkbox', 'ecommerce_tracking', ts('Enable E-Commerce Tracking?'));

    //## Is this the primary page of the experiment 
    //$this->addElement('checkbox', 'primary_page_experiment', ts('Is it the primary page of the experiment?'));

    //## Experiment ID
    //$this->add('text', 'experiment_id', ts('Experiment ID'));
      
    //$form->registerRule('checktracking', 'callback', 'checkTracking');
    //$form->addRule('tracking_id', 'Tracking ID is invalid', 'checktracking');

    $this->addFormRule(array('CRM_Event_Form_ManageEvent_WebTracking', 'formRule'));

    parent::buildQuickForm();
  }

  /**
   * Global validation rules for the form.
   *
   * @param array $values
   *
   * @return array
   *   list of errors to be posted back to the form
   */

  //## can i add the checks that I need to perform here?
  public static function formRule($values) {
    $errors = array();

    if(isset($values['enable_tracking']) && $values['enable_tracking'] == 1)
    {
      $pos = strpos($values['tracking_id'],'UA-'); 
      if($pos===false || $pos!==0) $errors['tracking_id'] = ts('You have selected to enable tracking, please provide a valid tracking id');
    }
    
    return $errors;
  }

  /**
   * Process the form submission.
   *
   *
   * @return void
   */
  public function postProcess() {

    //## similar call is also made in Location.tpl What does this call do exactly?
    $params = $this->controller->exportValues($this->_name);

    $existParams['page_id'] = $this->_id;
    $existParams['page_category'] = "civicrm_event";
    $existingEnrty = array();
    CRM_Core_BAO_WebTracking::retrieve($existParams,$existingEnrty);
    if(!empty($existingEnrty))
    {
       $params['id'] = $existingEnrty['id']; 
    }

    $params['enable_tracking'] = CRM_Utils_Array::value('enable_tracking', $params, FALSE);
    $params['tracking_id'] = CRM_Utils_Array::value('tracking_id', $params, FALSE);
    $params['page_id'] = $this->_id;
    $params['page_category']="civicrm_event";

    //## this call creates the event and adds the input from the form into the DB. even called in Location
    $event = CRM_Core_BAO_WebTracking::add($params);

    if ($this->_action & CRM_Core_Action::ADD) {
      $url = 'civicrm/event/manage/location';
      $urlParams = "action=update&reset=1&id={$event->id}";
      // special case for 'Save and Done' consistency.
      if ($this->controller->getButtonName('submit') == '_qf_EventInfo_upload_done') {
        $url = 'civicrm/event/manage';
        $urlParams = 'reset=1';
        CRM_Core_Session::setStatus(ts("'%1' information has been saved.",
          array(1 => $this->getTitle())
        ), ts('Saved'), 'success');
      }

      CRM_Utils_System::redirect(CRM_Utils_System::url($url, $urlParams));
    }

    parent::endPostProcess();
  }

  /**
   * Return a descriptive name for the page, used in wizard header
   *
   * @return string
   */
  public function getTitle() {
    return ts('Event Web Tracking Settings');
  }

}
