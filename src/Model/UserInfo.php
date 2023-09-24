<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Model;

use Brick\PhoneNumber\PhoneNumber;
use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\SerializedPath;

final class UserInfo
{
    /**
     * @var numeric-string
     */
    private string $uid;

    private string $firstName;

    private string $middleName;

    private string $lastName;

    private DateTimeImmutable $birthDate;

    private Gender $gender;

    private bool $trusted;

    private bool $verifying;

    private string $email;

    private PhoneNumber $mobile;

    /**
     * @SerializedPath("[rIdDoc]")
     */
    private int $primaryDocumentId;

    private CountryIso $citizenship;

    private AccountStatus $status;

    private SnilsNumber $snils;

    private InnNumber $inn;

    private AddressList $addresses;

    private DocumentList $documents;

    /**
     * @param string $uid
     * @param string $firstName
     * @param string $middleName
     * @param string $lastName
     * @param DateTimeImmutable $birthDate
     * @param Gender $gender
     * @param bool $trusted
     * @param bool $verifying
     * @param string $email
     * @param PhoneNumber $mobile
     * @param int $primaryDocumentId
     * @param CountryIso $citizenship
     * @param AccountStatus $status
     * @param SnilsNumber $snils
     * @param InnNumber $inn
     * @param AddressList $addresses
     * @param DocumentList $documents
     */
    public function __construct(string $uid, string $firstName, string $middleName, string $lastName, DateTimeImmutable $birthDate, Gender $gender, bool $trusted, bool $verifying, string $email, PhoneNumber $mobile, int $primaryDocumentId, CountryIso $citizenship, AccountStatus $status, SnilsNumber $snils, InnNumber $inn, AddressList $addresses, DocumentList $documents)
    {
        $this->uid         = $uid;
        $this->firstName   = $firstName;
        $this->middleName  = $middleName;
        $this->lastName    = $lastName;
        $this->birthDate   = $birthDate;
        $this->gender      = $gender;
        $this->trusted     = $trusted;
        $this->verifying   = $verifying;
        $this->email       = $email;
        $this->mobile      = $mobile;
        $this->primaryDocumentId = $primaryDocumentId;
        $this->citizenship = $citizenship;
        $this->status      = $status;
        $this->snils       = $snils;
        $this->inn         = $inn;
        $this->addresses   = $addresses;
        $this->documents   = $documents;
    }

    public function getUid(): string
    {
        return $this->uid;
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

    public function isVerifying(): bool
    {
        return $this->verifying;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCitizenship(): CountryIso
    {
        return $this->citizenship;
    }

    public function getMobile(): PhoneNumber
    {
        return $this->mobile;
    }

    public function getPrimaryDocumentId(): int
    {
        return $this->primaryDocumentId;
    }

    public function getStatus(): AccountStatus
    {
        return $this->status;
    }

    public function getSnils(): SnilsNumber
    {
        return $this->snils;
    }

    public function getInn(): InnNumber
    {
        return $this->inn;
    }

    public function getAddresses(): AddressList
    {
        return $this->addresses;
    }

    public function getDocuments(): DocumentList
    {
        return $this->documents;
    }
}
