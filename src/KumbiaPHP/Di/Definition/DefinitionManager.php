<?php

namespace KumbiaPHP\Di\Definition;

use \Serializable;
use KumbiaPHP\Di\Definition\DefinitionInterface;
use KumbiaPHP\Di\Definition\Service;

/**
 * Mantenedor y administrados de las definiciones para el inyector.
 *
 * @author manuel
 */
class DefinitionManager implements Serializable
{

    /**
     * definiciones de servicios
     * @var array 
     */
    protected $services;

    /**
     * Definiciones de parametros
     * @var array 
     */
    protected $parameters;

    /**
     * Constructor de la clase 
     */
    public function __construct(array $services = array(), array $params = array())
    {
        $this->services = $services;
        $this->parameters = $params;
    }

    /**
     * Verifica la existencia de un servicio
     * @param string $id nombre del servicio
     * @return boolean
     */
    public function hasService($id)
    {
        return isset($this->services[$id]);
    }

    /**
     * Devuelve la definicion de un servicio si existe
     * @param string $id nombre del servicio
     * @return Service|NULL
     */
    public function getService($id)
    {
        return $this->hasService($id) ? $this->services[$id] : NULL;
    }

    /**
     * Verifica la existencia de un parametro.
     * @param string $id nombre del parametro
     * @return boolean 
     */
    public function hasParam($id)
    {
        return isset($this->parameters[$id]);
    }

    /**
     * Devuelve la definicion de un parametro si existe
     * @param string $id nombre del parametro.
     * @return Service|NULL 
     */
    public function getParam($id)
    {
        return $this->hasParam($id) ? $this->parameters[$id] : NULL;
    }

    /**
     * Agrega una definicion de servicio si no existe.
     * @param DefinitionInterface $definition
     * @return \KumbiaPHP\Di\Definition\DefinitionManager 
     */
    public function addService(DefinitionInterface $definition)
    {
        if (!$this->hasService($definition->getId())) {
            $this->services[$definition->getId()] = $definition;
        }
        return $this;
    }

    /**
     * Agrega la definicion de un parametro si no existe
     * @param DefinitionInterface $param
     * @return \KumbiaPHP\Di\Definition\DefinitionManager 
     */
    public function addParam(DefinitionInterface $param)
    {
        if (!$this->hasParam($param->getId())) {
            $this->parameters[$param->getId()] = $param;
        }
        return $this;
    }

    /**
     * Devuelve los servicios agregados.
     * @return array 
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * Devuelve los parametros agregados
     * @return type 
     */
    public function getParams()
    {
        return $this->parameters;
    }

    public function serialize()
    {
        return serialize(array(
                    'services' => $this->services,
                    'parameters' => $this->parameters,
                ));
    }

    public function unserialize($config)
    {
        $config = unserialize($config);
        $this->services = $config['services'];
        $this->parameters = $config['parameters'];
    }

    public static function __set_state($config)
    {
        return new static($config['services'], $config['parameters']);
    }

}