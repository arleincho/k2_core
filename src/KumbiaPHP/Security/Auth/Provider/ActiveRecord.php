<?php

namespace KumbiaPHP\Security\Auth\Provider;

use KumbiaPHP\Security\Config\Reader;
use KumbiaPHP\Security\Auth\User\UserInterface;
use KumbiaPHP\Security\Exception\AuthException;
use KumbiaPHP\Security\Auth\Token\TokenInterface;
use KumbiaPHP\Security\Auth\Provider\AbstractProvider;
use KumbiaPHP\Security\Exception\UserNotFoundException;
use KumbiaPHP\Security\Auth\Token\ActiveRecord as Token;

/**
 * Description of Model
 *
 * @author manuel
 */
class ActiveRecord extends AbstractProvider
{

    protected $config;

    //put your code here
    public function loadUser(TokenInterface $token)
    {
        $user = $token->getUser()->findBy($this->config['username'], $token->getUsername());

        if (!$user instanceof UserInterface) {
            throw new UserNotFoundException("No existe el Usuario {$token->getUsername()} en la Base de Datos");
        }
        return $user;
    }

    public function getToken(array $config = array())
    {
        $this->config = $config;

        $request = $this->container->get('request');

        $form = $request->get('form_login', array(
            $config['username'] => $request->server->get('PHP_AUTH_USER'),
            'password' => $request->server->get('PHP_AUTH_PW'),
                ));

        if (!class_exists($config['class'])) {
            throw new AuthException("No existe la clase {$config['class']}");
        }

        $user = new $config['class']($form);

        if (!($user instanceof \KumbiaPHP\ActiveRecord\ActiveRecord)) {
            throw new AuthException("La clase {$config['class']} debe extender de ActiveRecord");
        }

        if (!($user instanceof UserInterface)) {
            throw new AuthException("La clase {$config['class']} debe implementar la interface de UserInterface");
        }

        return new Token($user);
    }

}