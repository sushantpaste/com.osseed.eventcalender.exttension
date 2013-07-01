<?php

require_once 'CRM/Core/Page.php';

class CRM_Eventcalender_Page_ShowEvents extends CRM_Core_Page {
  function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(ts('ShowEvents'));
  $config = CRM_Core_Config::singleton();
  $whereCondition = '';
  $eventTypes = array(); 
    if(isset($config->civicrm_events_event_types)) {
      $eventTypes = $config->civicrm_events_event_types;
      $eventTypes = array_flip($eventTypes);
    } else {
       require_once 'CRM/Event/PseudoConstant.php';
       $all_events = CRM_Event_PseudoConstant::eventType();
       $eventTypes = array_flip($all_events); 
      }
    if(!empty($eventTypes)) {
     $whereCondition .= ' AND civicrm_event.event_type_id in (' . implode(",", $eventTypes) . ')';
    }  
    
    $pastEvents = '';  
    $currentDate =  date("Y-m-d h:i:s", time());
    if(isset($config->civicrm_events_event_past)) {
      $pastEvents = $config->civicrm_events_event_past;
    }
    if(empty($pastEvents)) {
      $whereCondition .= " AND civicrm_event.start_date > '" .$currentDate . "'";
    }
    
    $monthEvents = '';
    if(isset($config->civicrm_events_event_months)) {
      $monthEvents = $config->civicrm_events_event_months;
    }
    if(!empty($monthEvents)) {
      $monthEventsDate = date("Y-m-d h:i:s",strtotime(date("Y-m-d h:i:s", strtotime($currentDate)) . "+".$monthEvents." month"));
      $whereCondition .= " AND civicrm_event.start_date < '" .$monthEventsDate . "'";
    }

    $ispublicEvents = '';
    if(isset($config->civicrm_events_event_is_public)) { 
      $ispublicEvents = $config->civicrm_events_event_is_public;
    }
    if(!empty($ispublicEvents)) {
      $whereCondition .= " AND civicrm_event.is_public = " .$ispublicEvents. "";
    }

    $query = "SELECT `id`, `title`, `start_date` as start, `end_date`  as end FROM `civicrm_event` WHERE civicrm_event.is_active = 1 AND civicrm_event.is_template = 0";
  
    $query .= $whereCondition; 
    $events['events'] = array();
   
    $dao = CRM_Core_DAO::executeQuery( $query, CRM_Core_DAO::$_nullArray );
    $eventCalendarParams = array ('title' => 'title', 'start' => 'start', 'url' => 'url');
    if(isset($config->civicrm_events_event_end_date)) {
      $eventCalendarParams['end'] = 'end';
    }
 
    while ( $dao->fetch( ) ) {
      if ( $dao->title ) { 
        if( isset($startDate) ) {
          $startDate = date("Y,n,j", strtotime( $dao->start_date ) );
        }
        if( isset($endDate) ) {
	  $endDate   = date("Y,n,j", strtotime( $dao->end_date ) );
        }
	$dao->url =   CRM_Utils_System::url( 'civicrm/event/info', 'id=' . $dao->id );
      }
      $eventData = array();
      foreach ($eventCalendarParams as  $k) {
	$eventData[$k] = $dao->$k; 
       }	
       $events['events'][] = $eventData;
    }
    $events['header']['left'] = 'prev,next today';
    $events['header']['center'] = 'title';
    $events['header']['right'] = 'month,basicWeek,basicDay';
    $this->assign('civicrm_events', json_encode($events));
    parent::run();
  }
}
