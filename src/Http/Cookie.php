<?php

namespace MyFramework\Http;


class Cookie
{
    public function __construct(
        protected string $name,
        protected string $value,
        protected int $expires_or_options = 0,
        protected string $path = "",
        protected string $domain = "",
        protected bool $secure = false,
        protected bool $httponly = false
    ) {
    }

    public function set(): bool
    {
        return setcookie(
            $this->name,
            $this->value,
            $this->expires_or_options,
            $this->path,
            $this->domain,
            $this->secure,
            $this->httponly
        );
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     */
    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of expires_or_options
     *
     * @return int
     */
    public function getExpiresOrOptions(): int
    {
        return $this->expires_or_options;
    }

    /**
     * Set the value of expires_or_options
     *
     * @param int $expires_or_options
     *
     * @return self
     */
    public function setExpiresOrOptions(int $expires_or_options): self
    {
        $this->expires_or_options = $expires_or_options;

        return $this;
    }

    /**
     * Get the value of path
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Set the value of path
     *
     * @param string $path
     *
     * @return self
     */
    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get the value of domain
     *
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * Set the value of domain
     *
     * @param string $domain
     *
     * @return self
     */
    public function setDomain(string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get the value of secure
     *
     * @return bool
     */
    public function getSecure(): bool
    {
        return $this->secure;
    }

    /**
     * Set the value of secure
     *
     * @param bool $secure
     *
     * @return self
     */
    public function setSecure(bool $secure): self
    {
        $this->secure = $secure;

        return $this;
    }

    /**
     * Get the value of httponly
     *
     * @return bool
     */
    public function getHttponly(): bool
    {
        return $this->httponly;
    }

    /**
     * Set the value of httponly
     *
     * @param bool $httponly
     *
     * @return self
     */
    public function setHttponly(bool $httponly): self
    {
        $this->httponly = $httponly;

        return $this;
    }
}
