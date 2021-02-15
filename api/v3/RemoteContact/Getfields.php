<?php
/*-------------------------------------------------------+
| SYSTOPIA Remote Tools                                  |
| Copyright (C) 2021 SYSTOPIA                            |
| Author: B. Endres (endres@systopia.de)                 |
+--------------------------------------------------------+
| This program is released as free software under the    |
| Affero GPL license. You can redistribute it and/or     |
| modify it under the terms of this license which you    |
| can read by viewing the included agpl.txt or online    |
| at www.gnu.org/licenses/agpl.html. Removal of this     |
| copyright header is strictly prohibited without        |
| written permission from the original author(s).        |
+--------------------------------------------------------*/

require_once 'remotetools.civix.php';

use CRM_Remotetools_ExtensionUtil as E;
use \Civi\RemoteContact\GetFieldsEvent;

/**
 *
 * RemoteContact.getfields
 */
function civicrm_api3_remote_contact_getfields($params) {
    unset($params['check_permissions']);

    // we only support 'get' actions
    if (!empty($params['action']) && $params['action'] != 'get' && $params['action'] != 'getsingle') {
        return civicrm_api3('Contact', 'getfields', $params);
    }

    // create event to collect more fields
    $fields_collection = new GetFieldsEvent($params);

    // add some selected fields
    $fields_collection->setFieldSpec('contact_type', [
        'name'          => 'contact_type',
        'type'          => CRM_Utils_Type::T_STRING,
        'title'         => E::ts("Contact Type"),
        'localizable'   => 0,
        'is_core_field' => true,
    ]);

    // dispatch to others
    Civi::dispatcher()->dispatch('civi.remotecontact.getfields', $fields_collection);

    // set results and return
    $fields['values'] = $fields_collection->getFieldSpecs();
    return $fields;
}
