<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Client;

enum ScopePermission: string
{
    case OPEN_ID = 'openid';
    case FULL_NAME = 'fullname';
    case BIRTHDATE = 'birthdate';
    case GENDER = 'gender';
    case EMAIL = 'email';
    case MOBILE = 'mobile';
    case ID_DOC = 'id_doc';
    case FOREIGN_PASSPORT_DOC = 'foreign_passport_doc';
    case PASSPORT_HISTORY_DOC = 'history_passport_doc';
    case NDFL_PERSON = 'ndfl_person';
    case DRIVERS_LICENSE_DOC = 'drivers_licence_doc';
    // TODO: This permission is accepted, but not listed in most recent guide (v3.36)
    case DEATH_CERTIFICATE_DOC = 'death_cert_doc';
    case SNILS = 'snils';
    case INN = 'inn';
    // TODO: Errors with "invalid scope", but this field is present in the response anyway
    //case CITIZENSHIP = 'citizenship';
    case ADDRESSES = 'addresses';
    case VEHICLES = 'vehicles';
}
