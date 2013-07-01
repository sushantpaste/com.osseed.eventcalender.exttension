
<h3>Event Calender</h3>
<div id="calendar"></div>

{crmScript ext=com.osseed.eventcalender file=fullcalendar.js}
{crmStyle ext=com.osseed.eventcalender file=fullcalendar.css}
{crmStyle ext=com.osseed.eventcalender file=civicrm_events.css}

{literal}
<script type="text/javascript">
cj( function( ) {
      buildCalender( );
  });
function buildCalender( ) {
   var events_data = {/literal}{$civicrm_events}{literal};
    var jsonStr = JSON.stringify(events_data);
    jQuery("#calendar").fullCalendar(events_data);		
}
</script>
{/literal}
