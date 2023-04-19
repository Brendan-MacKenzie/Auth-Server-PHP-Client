<?php

namespace BrendanMacKenzie\AuthServerClient\Objects;

use stdClass;

/**
 * Class Contact.
 */
class Profile extends Base
{
    public $email;
    public $externalId;
    public $externalTid;
    public $initialUser;

    protected $profile_id;
    protected $token;

    public function getProfileId(): string
    {
        return $this->profile_id;
    }

    public function getToken() : string
    {
        return $this->token;
    }

    public function loadFromStdclass(stdClass $object): self
    {
        return parent::loadFromStdclass($object);
    }

    public function toArray() : array
    {
        return [
            'email' => (string)$this->email,
            'external_id' => (string)$this->externalId,
            'external_tid' => (string)$this->externalTid,
            'initial_user' => (bool)$this->initialUser,
        ];
    }
}
