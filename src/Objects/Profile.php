<?php

namespace BrendanMacKenzie\AuthServerClient\Objects;

use stdClass;

/**
 * Class Profile.
 */
class Profile extends Base
{
    public $email;
    public $externalId;
    public $externalTid;
    public $initialUser;
    public $activatedAt;

    public $user;

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
        if ($object->user) {
            $user = new User();
            $object->user = $user->loadFromStdclass($object->user);
        }

        return parent::loadFromStdclass($object);
    }

    public function toArray() : array
    {
        return [
            'email' => (string)$this->email,
            'external_id' => (string)$this->externalId,
            'external_tid' => (string)$this->externalTid,
            'initial_user' => (bool)$this->initialUser,
            'activated_at' => $this->activatedAt,
            'user' => $this->user,
        ];
    }
}
