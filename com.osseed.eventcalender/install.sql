SELECT @domain_id := min(id) FROM civicrm_domain;
SELECT @administerID    := MAX(id) FROM civicrm_navigation where name = 'Events';
SELECT @adminCampaignWeight := MAX(weight)+1 FROM civicrm_navigation where parent_id = @administerID;

INSERT INTO civicrm_navigation
    ( domain_id, url, label, name, permission, permission_operator, parent_id, is_active, has_separator, weight )
VALUES     
    ( @domain_id,'civicrm/showevents', 'ShowEvents', 'ShowEvents', 'access CiviCRM', 'AND', @administerID, '1', NULL, @adminCampaignWeight );

SELECT @domain_id := min(id) FROM civicrm_domain;
SELECT @administerID    := MAX(id) FROM civicrm_navigation where name = 'CiviEvent';
SELECT @adminCampaignWeight := MAX(weight)+1 FROM civicrm_navigation where parent_id = @administerID;

INSERT INTO civicrm_navigation
    ( domain_id, url, label, name, permission, permission_operator, parent_id, is_active, has_separator, weight )
VALUES     
    ( @domain_id,'civicrm/eventcalendersettings', 'EventCalenderSettings', 'EventCalenderSettings', 'access CiviCRM', 'AND', @administerID, '1', NULL, @adminCampaignWeight );