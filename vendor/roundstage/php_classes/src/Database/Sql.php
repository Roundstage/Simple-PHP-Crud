<?php 

namespace Roundstage\Database;

class Sql {
    #Configuração do banco de dados:
    const HOSTNAME = "127.0.0.1";
    const USERNAME = "root";
    const PASSWORD = "root";
    const DBNAME = "db_crud_produtos";

    #Conexão ao banco de dados, privada por questões de segurança.
    private $connection;

    public function __construct()
    #Inicializar a conexão ao bando de dados.
    {
        $this->connection = new \PDO(
            "mysql:dbname=".Sql::DBNAME.";host=".Sql::HOSTNAME,
            Sql::USERNAME,
            Sql::PASSWORD
        );
    }
    private function setParams($statement, $params = array())
    {
        foreach($params as $key => $value){
            $this->bindParam($statement, $key, $value);
        }
    }
    private function bindParam($statement, $key, $value)
    {
        $statement->bindParam($key, $value);
    }
    public function query($rawQuery, $params = array())
    {
        $statement = $this->connection->prepare($rawQuery);
        $this->setParams($statement, $params);
        $statement->execute();
    }
    public function select($rawQuery, $params = array()):array
    {
        $statement = $this->connection->prepare($rawQuery);
        $this->setParams($statement, $params);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);

    }
}
?>