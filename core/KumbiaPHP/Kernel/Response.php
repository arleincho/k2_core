<?php

namespace KumbiaPHP\Kernel;

use KumbiaPHP\Kernel\Parameters;

/**
 * Description of Response
 *
 * @author manuel
 */
class Response
{

    /**
     *
     * @var Parameters 
     */
    public $headers;

    /**
     *
     * @var type 
     */
    protected $content;

    /**
     *
     * @var type 
     */
    protected $statusCode;

    /**
     *
     * @var type 
     */
    protected $statusText;

    /**
     *
     * @var type 
     */
    protected $charset;

    public function __construct($content = NULL, $statusCode = 200, array $headers = array())
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->statusText = "Ok";
        $this->headers = new Parameters($headers);
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function getStatusText()
    {
        return $this->statusText;
    }

    public function setStatusText($statusText)
    {
        $this->statusText = $statusText;
    }

    public function getCharset()
    {
        return $this->charset;
    }

    public function setCharset($charset)
    {
        $this->charset = $charset;
    }

    public function send()
    {
        $this->sendHeaders();
        $this->sendContent();
    }

    protected function sendHeaders()
    {
        if (headers_sent()) {
            return;
        }

        if (!$this->headers->has('Content-Type')) {
            $charset = $this->getCharset() ? : 'UTF-8';
            $this->headers->set('Content-Type', "text/html; charset=$charset");
        }
        
        //mandamos el status
        header(sprintf('HTTP/1.0 %s %s', $this->statusCode, $this->statusText));

        foreach ($this->headers->all() as $index => $value) {
            header("{$index}: {$value}", false);
        }
    }

    protected function sendContent()
    {
        echo $this->content;
    }

}