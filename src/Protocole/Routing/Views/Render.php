<?php
namespace Simplecode\Protocole\Routing\Views;


/**
 * Class représentant les vues
 * @author Claude Fassinou <dev.claudy@gmail.com>
 */
class Render{
    /**
     * Les données à passer à la vue
     *
     * @var array
     */
    protected $data = [];

    /**
     * Le dossier des vues
     *
     * @var string
     */
    protected $dir = VIEWS_DIR;

    /**
     * Rendre la vue
     *
     * @param string $views
     * @param array $data
     * @return string
     */
    public function render(string $views, array $data){
        //Assignation des paramètres
        $this->data = array_merge($data,$this->data);
        $this->setWithData();
        //Récupération de la vue
        $file = view_path($views);
        //Enregistrement de conntenu dans le tempon
        ob_start();
        extract($this->data, EXTR_SKIP);
        require $file;
        $body= ob_get_clean();
        //Fin du tempo

        //Compilation de la vue
        $syn = new Syntax($body);
        $syn->compile($body);

        
        if (is_file($file=VIEWS_DIR.'/'. trim($syn->getLayout(),'/'))) {
            ob_start();
            $main = $syn->getView() ;
            require $file;
            return ob_get_clean();
        }
        
        return $syn->getView();
       
    }

    /**
     * Set with data from session
     *
     * @return void
     */
    private function setWithData(){
        if ($with=_SESSION('_with')) {
           $this->addData($with);
           _SESSION()->remove('_with');
        }

        $this->clearSession();
    }

    private function clearSession(){
        _SESSION()->remove('_form');
        _SESSION()->remove('_form_errors');
    }


    public function addData(array $data){
        $this->data = array_merge($this->data, $data);
    }
}