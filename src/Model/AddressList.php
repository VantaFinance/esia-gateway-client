<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Model;

use Symfony\Component\Serializer\Annotation\SerializedPath;

final class AddressList
{
    /**
     * @SerializedPath("[prg]")
     */
    private ?Address $persistentRegistrationAddress;

    /**
     * @SerializedPath("[pta]")
     */
    private ?Address $temporaryRegistrationAddress;

    /**
     * @SerializedPath("[plv]")
     */
    private ?Address $persistentLivingAddress;

    /**
     * @param Address|null $persistentRegistrationAddress
     * @param Address|null $temporaryRegistrationAddress
     * @param Address|null $persistentLivingAddress
     */
    public function __construct(?Address $persistentRegistrationAddress, ?Address $temporaryRegistrationAddress, ?Address $persistentLivingAddress)
    {
        $this->persistentRegistrationAddress = $persistentRegistrationAddress;
        $this->temporaryRegistrationAddress  = $temporaryRegistrationAddress;
        $this->persistentLivingAddress       = $persistentLivingAddress;
    }

    public function getPersistentRegistrationAddress(): ?Address
    {
        return $this->persistentRegistrationAddress;
    }

    public function getTemporaryRegistrationAddress(): ?Address
    {
        return $this->temporaryRegistrationAddress;
    }

    public function getPersistentLivingAddress(): ?Address
    {
        return $this->persistentLivingAddress;
    }
}
