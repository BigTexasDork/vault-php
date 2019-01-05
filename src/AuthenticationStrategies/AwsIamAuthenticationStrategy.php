<?php

namespace Vault\AuthenticationStrategies;

use Vault\ResponseModels\Auth;

/**
 * Class AwsIamAuthenticationStrategy
 *
 * @package Vault\AuthenticationStrategy
 */
class AwsIamAuthenticationStrategy extends AbstractAuthenticationStrategy
{
    /**
     * @var string
     */
    protected $vaultrole;

    /**
     * @var string
     */
    protected $region;

    /**
     * AwsIamAuthenticationStrategy constructor.
     *
     * @param string $vaultrole

     */
    public function __construct($region, $vaultrole)
    {
        $this->region = $region;
        $this->vaultrole = $vaultrole;

    }

    /**
     * Returns auth for further interactions with Vault.
     *
     * @return Auth
     * @throws \Vault\Exceptions\TransportException
     *
     * @throws \Vault\Exceptions\ServerException
     * @throws \Vault\Exceptions\ClientException
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function authenticate()
    {
        $response = $this->client->write(
            sprintf('/auth/userpass/login/%s', $this->username),
            ['password' => $this->password]
        );

        return $response->getAuth();
    }
}