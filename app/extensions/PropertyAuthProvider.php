<?php
use Illuminate\Auth\GenericUser;
use Illuminate\Auth\UserProviderInterface;

/**

 */

class PropertyAuthProvider implements UserProviderInterface {

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed $identifier
     * @return \Illuminate\Auth\UserInterface|null
     */
    public function retrieveById($identifier)
    {
        $adminSetting = \Config::get('auth.admin');
        if (array_key_exists($identifier, $adminSetting)) {
            return new GenericUser(
                [ 'id' => $identifier, 'password' => $adminSetting[$identifier]]);
        }
    }

    /**
     * Retrieve a user by by their unique identifier and "remember me" token.
     *
     * @param  mixed $identifier
     * @param  string $token
     * @return \Illuminate\Auth\UserInterface|null
     */
    public function retrieveByToken($identifier, $token)
    {
        return new \Exception('not implemented');
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Auth\UserInterface $user
     * @param  string $token
     * @return void
     */
    public function updateRememberToken(\Illuminate\Auth\UserInterface $user, $token)
    {
        return new \Exception('not implemented');
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials
     * @return \Illuminate\Auth\UserInterface|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        return $this->retrieveById($credentials['email']);
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Auth\UserInterface $user
     * @param  array $credentials
     * @return bool
     */
    public function validateCredentials(\Illuminate\Auth\UserInterface $user, array $credentials)
    {
        return Hash::check($credentials['password'], $user->getAuthPassword());
    }
}