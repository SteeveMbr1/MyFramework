<?php

namespace MyFramework\Renderer;

class ViewParser
{

    protected string $content;

    public function __construct(protected string $views_directory = 'views')
    {
    }

    /**
     * Load a view and parse its content for a valid php file
     * @param string $view the name of the view file to load
     * @return string 
     */
    public function load(string $view): string
    {
        $path = $this->views_directory . DIRECTORY_SEPARATOR . $view . '.html.php';
        $this->content = file_get_contents($path);
        $this->parseEchoVar();
        $this->parseDirectives();
        return '?>' . $this->content;
    }

    /**
     * Looking for a pattern like `{% block someblock %}`
     * and replace it by `<?php $this->block('someblok') ?>`
     * @return void 
     */
    private function parseDirectives(): void
    {
        $pattern = "{%\s*(?'directive'\w+)(?:[\s\']|(?'arg'[\w.]+))*%}";
        preg_match_all("#$pattern#", $this->content, $matches, PREG_SET_ORDER | PREG_UNMATCHED_AS_NULL);
        foreach ($matches as [$search, &$directive, &$arg]) {
            $this->content = str_replace($search, "<?php \$this->$directive('$arg') ?>", $this->content);
        }
    }

    /**
     * Looking for a pattern like `{{ variable }}`
     * and replace it by `<?= $varible ?>`
     * @return void 
     */
    private function parseEchoVar(): void
    {
        $pattern = "{{\s*([\w]+)\.?([\w]+)?\s*}}";
        preg_match_all("#$pattern#", $this->content, $matches, PREG_SET_ORDER | PREG_UNMATCHED_AS_NULL);
        foreach ($matches as [$search, &$var, &$attr]) {
            $var = '$' . $var . ($attr ? "->$attr" : '');
            $replace = "<?= $var ?>";
            $this->content = str_replace($search, $replace, $this->content);
        }
    }
}
