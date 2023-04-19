<?php

namespace BrendanMacKenzie\AuthServerClient\Resources;

use BrendanMacKenzie\AuthServerClient\Objects\Profile;
use BrendanMacKenzie\AuthServerClient\Common\HttpClient;

/**
 * Class Auth.
 */
class Profiles extends Base
{
    public function __construct(HttpClient $httpClient)
    {
        parent::__construct($httpClient);

        $this->object = new Profile();
    }

    public function register($user, bool $initialUser = true, string $externalTid = null) : Profile
    {
        $this->setResourceEndpoint('profile/register');

        $this->object->email = $user->email;
        $this->object->externalId = $user->id;
        $this->object->externalTid = $externalTid;
        $this->object->initialUser = $initialUser;

        return $this->create($this->object);
    }
}
