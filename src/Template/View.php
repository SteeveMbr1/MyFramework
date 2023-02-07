<?php

namespace MyFramework\Template;

class View
{
    private ?string $capturing = null;
    private array $captures = [];

    public function __construct(
        protected string  $name,
        protected ?array  $datas = null,
        protected ?array  $blocks = null,
        protected ?string $extend = null,
        protected string  $folder = 'views'
    ) {
    }

    public function render(): string
    {
        $this->datas && extract($this->datas);
        ob_start();
        require_once($this->pathResolver($this->name));
        $view = ob_get_clean();
        if ($this->extend) {
            return new View($this->extend, $this->captures);
        }
        return $view;
    }

    private function pathResolver(string $name): string
    {
        $path = str_replace('.', DIRECTORY_SEPARATOR, $name);
        $path = $this->folder . DIRECTORY_SEPARATOR . $path . '.html.php';

        // var_dump(__DIR__);
        // var_dump($path);
        // var_dump(realpath($path));
        // var_dump(file_exists($path));
        // die;
        if (!file_exists($path))
            throw new \Exception("The view $name was not found in $path\n", 1);
        return $path;
    }

    private function block(string $name): void
    {
        if (!isset($this->blocks[$name])) {
            $this->blocks[$name] = '';
            $this->capturing = $name;
            ob_start();
        }
        echo $this->blocks[$name];
    }

    private function endblock(): void
    {
        if ($this->capturing) {
            $captured = ob_get_clean();
            $this->blocks[$this->capturing] = trim($captured);
            $this->capturing = null;
        }
    }

    private function extends(string $name)
    {
        $this->extend = $name;
    }

    public function __set(string $name, mixed $value): void
    {
        $this->datas[$name] = $value;
    }

    public function __get(string $name): mixed
    {
        if (isset($this->datas[$name]))
            return $this->datas[$name];
        return null;
    }

    private function include(string $view): static
    {
        return new static($view);
    }

    public function __toString()
    {
        return $this->render();
    }
}

function View(string $name, array $datas = []): View
{
    return new View($name, $datas);
}
