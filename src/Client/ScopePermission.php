<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Client;

/**
 * @see https://digital.gov.ru/uploaded/presentations/finalstsenariiispolzovaniyatspv131.pdf
 */
enum ScopePermission: string
{
    case OPEN_ID = 'openid';
    // фамилия; имя; отчество
    case FULL_NAME = 'fullname';
    // дата рождения, указанная в УЗ
    case BIRTHDATE = 'birthdate';
    // место рождения
    case BIRTHPLACE = 'birthplace';
    // пол, указанный в УЗ
    case GENDER = 'gender';
    // адрес электронной почты, указанный в УЗ
    case EMAIL = 'email';
    // номер мобильного телефона
    case MOBILE = 'mobile';
    // адреса постоянной регистрации, временной регистрации (доступен только с версией API v2) и фактического проживания
    case ADDRESSES = 'addresses';
    // государственный регистрационный знак; серия и номер свидетельства о регистрации
    case VEHICLES = 'vehicles';
    // СНИЛС, указанный в УЗ
    case SNILS = 'snils';
    // ИНН, указанный в УЗ
    case INN = 'inn';
    // серия и номер документа, удостоверяющего личность; дата выдачи; кем выдан; код подразделения; гражданство
    case ID_DOC = 'id_doc';
    // фамилия, имя, отчество буквами латинского алфавита; серия и номер заграничного паспорта; дата выдачи; срок действия; орган, выдавший документ; гражданство
    case FOREIGN_PASSPORT_DOC = 'foreign_passport_doc';
    // история паспортов
    case PASSPORT_HISTORY_DOC = 'history_passport_doc';
    // серия и номер водительского удостоверения; дата выдачи; срок действия
    case DRIVERS_LICENSE_DOC = 'drivers_licence_doc';
    // сведения о свидетельствах о регистрации ТС гражданина
    case VEHICLE_REGISTRATION_CERTIFICATE_DOC = 'vehicle_reg_cert_doc';
    // серия и номер свидетельства; дата выдачи; место государственной регистрации
    case BIRTH_CERTIFICATE_DOC = 'birth_cert_doc';
    // свидетельство о перемене имени
    case CHANGE_FULL_NAME_CERTIFICATE_DOC = 'change_fullname_cert_doc';
    //
    case DEATH_CERTIFICATE_DOC = 'death_cert_doc';
    // свидетельство о браке
    case MARRIAGE_CERTIFICATE_DOC = 'marriage_cert_doc';
    // свидетельство о разводе
    case DIVORCE_CERTIFICATE_DOC = 'divorce_cert_doc';
    // свидетельство об установлении отцовства
    case PATERNITY_CERTIFICATE_DOC = 'paternity_cert_doc';
    // выписка из ИЛС СФР
    case ILS_PFR_DOC = 'ils_doc';
    // справка о доходах и суммах налога ФЛ (форма 2-НДФЛ)
    case NDFL_PERSON = 'ndfl_person';
    // сведения о трудовой деятельности застрахованного лица в системе обязательного пенсионного страхования
    case ELECTRONIC_WORKBOOK = 'electronic_workbook';
    // сведения о статусе самозанятого
    case SELF_EMPLOYED = 'self_employed';
    // сведения об отнесении гражданина к категории граждан предпенсионного возраста
    case PRE_RETIREMENT_AGE = 'pre_retirement_age';
    // сведения о назначенных и реализованных мерах социальной защиты (поддержки)
    case PAYMENTS_EGISSO = 'payments_egisso';
    // сведения о доходах ФЛ и о выплатах страховых взносов, произведенных в пользу ФЛ
    case PAYOUT_INCOME = 'payout_income';
    // справка о назначенных пенсиях и социальных выплатах на дату
    case PENSION_REFERENCE = 'pension_reference';
}
