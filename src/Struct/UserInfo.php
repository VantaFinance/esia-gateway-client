<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Brick\PhoneNumber\PhoneNumber;
use DateTimeImmutable;

final class UserInfo
{
    /**
     * @var numeric-string
     */
    private string $uid;

    /**
     * @var numeric-string
     */
    private string $oid;

    private string $firstName;

    private string $middleName;

    private string $lastName;

    private DateTimeImmutable $birthDate;

    private Gender $gender;

    private bool $trusted;

    private string $email;

    private PhoneNumber $mobilePhone;

    private CountryIso $citizenship;

    private SnilsNumber $snils;

    private InnNumber $inn;

    private Address $registrationAddress;

    private Address $homeAddress;

    /**
     * @param string $uid
     * @param string $firstName
     * @param string $middleName
     * @param string $lastName
     * @param DateTimeImmutable $birthDate
     * @param Gender $gender
     * @param bool $trusted
     * @param string $email
     * @param PhoneNumber $mobilePhone
     * @param CountryIso $citizenship
     * @param SnilsNumber $snils
     * @param InnNumber $inn
     * @param Address $registrationAddress
     * @param Address $homeAddress
     */
    public function __construct(string $uid, string $firstName, string $middleName, string $lastName, DateTimeImmutable $birthDate, Gender $gender, bool $trusted, string $email, PhoneNumber $mobilePhone, CountryIso $citizenship, SnilsNumber $snils, InnNumber $inn, Address $registrationAddress, Address $homeAddress)
    {
        $this->uid         = $uid;
        $this->firstName   = $firstName;
        $this->middleName  = $middleName;
        $this->lastName    = $lastName;
        $this->birthDate   = $birthDate;
        $this->gender      = $gender;
        $this->trusted     = $trusted;
        $this->email       = $email;
        $this->mobilePhone = $mobilePhone;
        $this->citizenship = $citizenship;
        $this->snils       = $snils;
        $this->inn         = $inn;
        $this->registrationAddress = $registrationAddress;
        $this->homeAddress = $homeAddress;
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getOid(): string
    {
        return $this->oid;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getBirthDate(): DateTimeImmutable
    {
        return $this->birthDate;
    }

    public function getGender(): Gender
    {
        return $this->gender;
    }

    public function isTrusted(): bool
    {
        return $this->trusted;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCitizenship(): CountryIso
    {
        return $this->citizenship;
    }

    public function getMobilePhone(): PhoneNumber
    {
        return $this->mobilePhone;
    }

    public function getSnils(): SnilsNumber
    {
        return $this->snils;
    }

    public function getInn(): InnNumber
    {
        return $this->inn;
    }

    public function getRegistrationAddress(): Address
    {
        return $this->registrationAddress;
    }

    public function getHomeAddress(): Address
    {
        return $this->homeAddress;
    }
}
