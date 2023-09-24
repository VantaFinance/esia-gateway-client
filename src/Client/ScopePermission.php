<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Client;

use MyCLabs\Enum\Enum;

final class ScopePermission extends Enum
{
    private const OPEN_ID = 'openid';
    private const FULL_NAME = 'fullname';
    private const BIRTHDATE = 'birthdate';
    private const GENDER = 'gender';
    private const EMAIL = 'email';
    private const MOBILE = 'mobile';
    private const ID_DOC = 'id_doc';
    private const FOREIGN_PASSPORT_DOC = 'foreign_passport_doc';
    private const DRIVERS_LICENSE_DOC = 'drivers_licence_doc';
    private const SNILS = 'snils';
    private const INN = 'inn';
    // TODO: Does not work for some reason, errors with "invalid scope", this field is available anyway
//    private const CITIZENSHIP = 'citizenship';
    private const ADDRESSES = 'addresses';
}
