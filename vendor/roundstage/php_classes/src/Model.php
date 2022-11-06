<?php 
    namespace Roundstage;
    #Feita pra facilitar os getters e Setters.

    class Model {

        private $values = [];

        #Método mágico pra receber os getters ou setters
        public function __call(string $name, array $args)
        {
            $method = substr($name, 0, 3);
            $fieldName = substr($name, 3, strlen($name));

            switch($method)
            {
                case "get":
                    return $this->values[$fieldName];
                    break;
                case "set":
                    $this->values[$fieldName] = $args[0];
                    break;
            }
        }

        public function setData(array $data = [])
        #Settar os valores automaticamente.
        {
            foreach ($data as $key => $value) {
                $this->{'set'.$key}($value);
            }
        }
        
        public function getValues()
        #Obter os valores.
        {
            return $this->values;
        }
    }
