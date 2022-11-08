<?php 
    namespace Roundstage;
    use Rain\TpL;

    class Page {
        private $tpl;
        private $options = [];
        private $defaults = [
            "data"=>[]
        ];

        private function setData(array $data = [])
        #Passa as informações do template para a variavel tpl.
        {
            foreach ($data as $key => $value) {
                $this->tpl->assign($key, $value);
            }
        }

        public function __construct(array $options = [])
        {
            #Selecionar se é as opções defaults de template ou as opções customizadas de template.
            $this->options = array_merge($this->defaults, $options);

            #Array de configuração do RainTpl para as views.
            $config = [
                "base_url" => null,
                "tpl_dir" => $_SERVER['DOCUMENT_ROOT']."/views/",
                "cache_dir" => $_SERVER['DOCUMENT_ROOT']."/views-cache/",
                "debug" => true
            ];

            #Instancia a configuração.
            Tpl::configure($config);
            $this->tpl = new TpL;
            $this->setData($this->options['data']);

            #Desenha o header.
            $this->tpl->draw('header');
        }
        public function setTpl(string $name, array $data = [], bool $returnHTML = false)
        {
            $this->setData($data);
            return $this->tpl->draw($name, $returnHTML);
        }
        public function __destruct()
        {
            $this->tpl->draw("footer");
        }
    }
