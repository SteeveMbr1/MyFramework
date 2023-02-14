<?php

namespace MyFramework\Http;

class Response
{
    /**
     * 
     * @var MyFramework\Http\Cookie[]
     */
    protected array $cookies = [];

    public function __construct(
        protected string $body = '',
        protected ?array $headers = null,
        protected int $status_code = 200,
    ) {
        $this->headers || $this->headers['content-type'] = 'text/html';
    }

    public function redirect(string $location, int $status_code = 300)
    {
        $this->setStatusCode($status_code);
        $this->setHeader('Location', $location);
    }

    public function send()
    {
        foreach ($this->headers as $key => $value) {
            header("$key:$value");
        }
        foreach ($this->cookies as $cookie) {
            $cookie->set();
        }
        http_response_code($this->status_code);

        echo $this->body;
    }

    /**
     * Get the value of body
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set the value of body
     */
    public function setBody($body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get the value of headers
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Set the value of headers
     */
    public function setHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * Unset the value of $name in the headers
     */
    public function unsetHeader(string $name): self
    {
        unset($this->headers[$name]);

        return $this;
    }

    /**
     * Get the value of status_code
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->status_code;
    }

    /**
     * Set the value of status_code
     *
     * @param int $status_code
     *
     * @return self
     */
    public function setStatusCode(int $status_code): self
    {
        $this->status_code = $status_code;

        return $this;
    }

    /**
     * Get the value of cookies
     *
     * @return array
     */
    public function getCookies(): array
    {
        return $this->cookies;
    }

    /**
     * Set the value of cookies
     *
     * @param array $cookies
     *
     * @return self
     */
    public function setCookie(Cookie $cookie): self
    {
        $this->cookies[$cookie->getName()] = $cookie;

        return $this;
    }
}
