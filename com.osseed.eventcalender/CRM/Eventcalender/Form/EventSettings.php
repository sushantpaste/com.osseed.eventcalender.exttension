<?php

/*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.1                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2011                                |
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
 * @copyright CiviCRM LLC (c) 2004-2011
 * $Id$
 *
 */

require_once 'CRM/Admin/Form.php';

/**
 * This class generates form components for Location Type
 * 
 */
class CRM_Eventcalender_Form_EventSettings extends CRM_Admin_Form
{
   protected $_roles = array(); 
   protected $_types = array(); 
   function preProcess( ) {
       
    parent::preProcess( );
    $session = CRM_Core_Session::singleton();
    $url = CRM_Utils_System::url('civicrm/eventcalendersettings');
    $session->pushUserContext( $url );
  }

function setDefaultValues() {
 $defaults = parent::setDefaultValues();
 
 $config = CRM_Core_Config::singleton();
 require_once 'CRM/Event/PseudoConstant.php';
 $event_type = CRM_Event_PseudoConstant::eventType();
 if(isset($config->civicrm_events_event_types)) {
   foreach($config->civicrm_events_event_types as $key => $val) {
    $defaults[$key] = $key; 
   }
 } else {
    $config->civicrm_events_event_types = $event_type;
    foreach($event_type as $key => $val) {
      $defaults[$key] = $key; 
    }
  }
 if(isset($config->civicrm_events_event_past)) { 
  $defaults['show_past_event'] = $config->civicrm_events_event_past;
 } else {
    $config->civicrm_events_event_past = 1;
    $defaults['show_past_event'] = 1;
   } 
 if(isset($config->civicrm_events_event_is_public)) { 
  $defaults['event_is_public'] = $config->civicrm_events_event_is_public;
 } else {
    $config->civicrm_events_event_is_public = 1;
    $defaults['event_is_public'] = 1;
   } 
  if(isset($config->civicrm_events_event_end_date)) { 
  $defaults['show_end_date'] = $config->civicrm_events_event_end_date;
 } else {
    $config->civicrm_events_event_end_date = 1; 
    $defaults['show_end_date'] = 1;
   } 
 if(isset($config->civicrm_events_event_months)) { 
  $defaults['events_event_month'] = $config->civicrm_events_event_months;
 } else {
    $config->civicrm_events_event_months = 0;
    $defaults['events_event_month'] = 0;
   } 
 
 return $defaults; 
}

    /**
     * Function to build the form
     *
     * @return None
     * @access public
     */
    public function buildQuickForm( ) 
    {
        parent::buildQuickForm( );
        if ($this->_action & CRM_Core_Action::DELETE ) { 
            return;
        }
        $this->add('text', 'show_event_from_month', ts('Show Events from how many months from current month '), array('size' => 50));
        $this->addElement('checkbox', 'show_end_date', ts('Show End Date'));
        $this->addElement('checkbox', 'event_is_public', ts('Is Public'));
        $this->addElement('checkbox', 'events_event_month', ts('Events By Month'));
        $this->addElement('checkbox', 'show_past_event', ts('Show Past Events'));
        require_once 'CRM/Event/PseudoConstant.php';
        $event_type = CRM_Event_PseudoConstant::eventType();
        
        foreach($event_type as $key => $val) {
        $this->addElement('checkbox', $key, ts($val));
        }
        $this->assign('event_type', $event_type);
        
    }

    /**
     * Function to process the form
     *
     * @access public
     * @return None
     */
    public function postProcess() {
     
        if ( $this->_action & CRM_Core_Action::DELETE ) {
            CDM_BAO_Item::del( $this->_id );
            CRM_Core_Session::setStatus( ts('Selected Discount has been deleted.') );
            return;
        }
      $params = $this->controller->exportValues($this->_name);
      $config = CRM_Core_Config::singleton(); 
      $configParams = array();
      require_once 'CRM/Event/PseudoConstant.php';
      $event_type = CRM_Event_PseudoConstant::eventType();
      foreach($event_type as $k => $v) {
        if(!array_key_exists($k,$params) ) {
          unset($event_type[$k]);
        } 
      }
     $configParams['civicrm_events_event_types'] = $event_type;
     if( isset($params['show_past_event']) && $params['show_past_event'] == 1 ) {
       $configParams['civicrm_events_event_past'] = $params['show_past_event'];
     } else {
         $configParams['civicrm_events_event_past'] = 0;
       }
     if( isset($params['show_end_date']) && $params['show_end_date'] == 1) {
       $configParams['civicrm_events_event_end_date'] = $params['show_end_date'];
     } else {
         $configParams['civicrm_events_event_end_date'] = 0;
       }
     if( isset($params['event_is_public']) && $params['event_is_public'] == 1) {
       $configParams['civicrm_events_event_is_public'] = $params['event_is_public'];
     } else {
         $configParams['civicrm_events_event_is_public'] = 0;
       }
     if( isset($params['events_event_month']) && $params['events_event_month'] == 1) { 
       $configParams['civicrm_events_event_months'] = $params['events_event_month']; 
     } else {
         $configParams['civicrm_events_event_months'] = 0; 
       }
     CRM_Core_BAO_ConfigSetting::create($configParams);
      CRM_Core_Session::setStatus(" ", ts('The value has been saved.'), "success" );
   }

}
