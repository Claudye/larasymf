<?php

namespace Simplecode\Protocole\Routing\Views;

class Syntax
{
    /**
     * Layout regex
     *
     * @var string
     */
    protected $layout_rgx = '/<layout file=["\'](.{5,})["\']?>/U';
    /***
     * Inclusion regex
     * @var string
     */
    protected $inc_rgx = '/<inc file=["\'](.{5,})["\']>/U';

    /**
     * Le layout 
     *
     * @var string
     */
    protected $layout = '';
    /**
     * La vue à complier
     *
     * @var string
     */
    protected $view = '';

    /**
     * Compile all the view porperty
     *
     * @return void
     */
    public function compile()
    {
        $matched = [];
        if (preg_match($this->layout_rgx, $this->view, $matched) > 0) {
            array_shift($matched);
            $this->layout = $matched[0];
        }
        $this->incCompiler();
        $this->view = $this->filtrer($this->layout_rgx);
    }

    public function __construct(string $view)
    {
        $this->view = $view;
    }

    /**
     * Get le layout
     *
     * @return  string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    private function filtrer(string $rgx)
    {
        return preg_replace('/\s\s+/', ' ', preg_replace($rgx, '', $this->view));
    }

    /**
     * Get a compiled view
     *
     * @return  string
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Including compiler
     *
     * @return void
     */
    private function incCompiler()
    {
        // catch all match tags from view
        $matches = preg_match_all($this->inc_rgx, $this->view, $matches) > 0 ? $matches : [];
        if ($matches !=[]) {
            //extract only tags
            $tags = array_shift($matches);

            //Tags args (filename);
            $files = array_shift($matches);
            
            foreach ($files as $key => $filename) {
                ob_start();
                require view_path($filename);
                $files[$key] =  ob_get_clean();
            }

            $this->view = str_replace($tags, $files, $this->view);
        }
    }
}
