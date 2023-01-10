<?php

namespace MyFramework\Template;

class View
{
    private ?string $capturing = null;
    private array $captures;

    public function __construct(
        protected string $name,
        protected ?array $datas = null,
        protected ?string $extend = null,
        protected string $folder = 'view'
    ) {
    }

    public function render(): string
    {
        $this->datas && extract($this->datas);
        ob_start();
        require_once($this->resolve($this->name));
        $view = ob_get_clean();
        if ($this->extend) {
            return new View($this->extend, $this->captures);
        }
        return $view;
    }

    private function resolve(string $name): string
    {
        $path = str_replace('.', DIRECTORY_SEPARATOR, $name);
        $path = $this->folder . DIRECTORY_SEPARATOR . $path . '.html.php';
        if (!file_exists($path))
            throw new \Exception("The view $name was not found in $path\n", 1);
        return $path;
    }

    public function start(string $name): void
    {
        $this->capturing = $name;
        ob_start();
    }

    public function end(): void
    {
        if ($this->capturing)
            $this->captures[$this->capturing] = ob_get_clean();
        $this->capturing = null;
    }

    public function extend(string $name)
    {
        $this->extend = $name;
    }

    public function show(string $name): void
    {
        if (isset($this->datas[$name]))
            echo $this->datas[$name];
    }

    public function yield(string $name): void
    {
        include $this->resolve($name);
    }

    public function __toString()
    {
        return $this->render();
    }
}
