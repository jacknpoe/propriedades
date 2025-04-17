<?php
// classe de conexão com o banco de dados e definição e recuperação de propriedades
// Versão 0.1: 17/04/2025: versão simplificada para a página Jacknpoe Explica Programação

class propriedades {
	public $conexao;

    // conecta e define certos charsets
    private function conecta() {
        // conecta e checa se a conexão teve sucesso
        $this->conexao = new \mysqli( hostname: "localhost", username: "root", password: "", database: "jacknpoe");
        if($this->conexao->connect_errno) {
            die("Falha ao conectar: (" . $this->conexao->connect_errno . ") " . $this->conexao->connect_error);
        }

        // coloca os resultados para serem UTF-8 e checa se teve sucesso
        $consulta = $this->conexao->query("SET character_set_results = utf8");
        if($this->conexao->errno) {
            $this->conexao->close();
            die("Falha ao setar: (" . $this->conexao->connect_errno . ") " . $this->conexao->connect_error);
        }

        // coloca os clientes para serem UTF-8 e checa se teve sucesso
        $consulta = $this->conexao->query("SET character_set_client = utf8");
        if($this->conexao->errno) {
            $this->conexao->close();
            die("Falha ao setar: (" . $this->conexao->connect_errno . ") " . $this->conexao->connect_error);
        }

        // coloca a conexão para ser UTF-8 e checa se teve sucesso
        $consulta = $this->conexao->query("SET character_set_connection = utf8");
        if($this->conexao->errno) {
            $this->conexao->close();
            die("Falha ao setar: (" . $this->conexao->connect_errno . ") " . $this->conexao->connect_error);
        }
    }

    // como "'" é o caracter usado para strings nas queries, ele é trocado pelo escape "\'"
    // aproveitando, troca-se também a barra "\" por "\\"
    public function escape($valor) {
        return str_replace(search: "'", replace: "\'",
                           subject: str_replace(search: '\\', replace: '\\\\', subject: $valor));
    }

    // consulta uma chave String
    public function getPropriedadeString($chave = "", $default = "") {
        if(strlen(string: $chave) == 0) {
            die("Chave não informada.");
        }

        $chave = $this->escape(valor: $chave);	// impede injeção

        $this->conecta();
        $resultado = $this->conexao->query(query:
            "SELECT NM_VALOR FROM propriedade WHERE UPPER(NM_CHAVE) = UPPER('{$chave}')");

        // Checa se a query teve sucesso
        if( $this->conexao->errno) {
            $this->conexao->close();
            die("Falha ao consultar: (" . $this->conexao->errno . ") " . $this->conexao->error);
        }

        $this->conexao->close();
        $linha = $resultado->fetch_assoc();

        // se encontrou um registro, retorna a coluna NM_VALOR, senão retorna o valor default
        if($linha) {
            return $linha["NM_VALOR"];
        } else {
            return $default;
        }
    }

    // consulta uma chave Float
    public function getPropriedadeFloat($chave = "", $default = 0.0) {
        return floatval(value: $this->getPropriedadeString(chave: $chave, default: strval(value: $default)));
    }

    // consulta uma chave Bool
    public function getPropriedadeBool($chave = "", $default = false) {
        return $this->getPropriedadeString(chave: $chave, default: $default ? "T" : "F") == "T" ? true : false;
    }   

    // define uma chave String
    public function setPropriedadeString($chave = "", $valor = "") {
        if(strlen(string: $chave) == 0) {
            die("Chave não informada.");
        }

        $chave = $this->escape(valor: $chave);	// impede injeção
        $valor = $this->escape(valor: $valor);	// impede injeção

        $this->conecta();
        $resultado = $this->conexao->query(query: "CALL SetPropriedade('{$chave}', '{$valor}')");

        // Checa se a query teve sucesso
        if( $this->conexao->errno) {
            $this->conexao->close();
            die( "Falha ao definir: (" . $this->conexao->errno . ") " . $this->conexao->error);
        }

        $this->conexao->close();
    }

    // define uma chave Float
    public function setPropriedadeFloat($chave = "", $valor = 0.0) {
        $this->setPropriedadeString(chave: $chave, valor: strval( value: $valor));
    }

    // define uma chave Bool
    public function setPropriedadeBool($chave = "", $valor = false) {
        $this->setPropriedadeString(chave: $chave, valor: $valor ? "T" : "F");
    }   
}
