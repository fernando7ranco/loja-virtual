<?php

class ClienteDAO {

    private $banco;

    public function __construct($bd) {
        $this->banco = $bd;
    }

    public function inserirPreCliente($cliente) {
		
        $nome = $cliente->getNome();
        $cpf = $cliente->getCpf();
        $rg = $cliente->getRg();
        $cep = $cliente->getCep();
        $endereco = $cliente->getEndereco();
        $bairro = $cliente->getBairro();
        $estado = $cliente->getEstado();
        $telefone = $cliente->getTelefone();
        $email = $cliente->getEmail();
        $senha = $cliente->getSenha();
		
		$codigo = md5($email . $cpf);
		$datatime = date("Y-m-d H:i:s",strtotime('+2 hour'));
		
		$sql = 'INSERT INTO `pre_clientes`(codigo, nome, cpf, rg, cep, endereco, bairro, estado, telefone, email, senha, tempo) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)';
		$stmt = $this->banco->preparaStatement($sql);
		$stmt->bind_param('ssssssssssss', $codigo, $nome, $cpf, $rg, $cep, $endereco, $bairro, $estado, $telefone, $email, $senha, $datatime);
		$stmt->execute(); 
		
		if($stmt->affected_rows > 0){
			$id =  $stmt->insert_id;
			$this->enviarEmailParaCadastro($id);
			return $id;
		}
		
		return 'inserir';
    } 
	
	public function inserirCliente($cliente) {

        $nome = $cliente->getNome();
        $cpf = $cliente->getCpf();
        $rg = $cliente->getRg();
        $cep = $cliente->getCep();
        $endereco = $cliente->getEndereco();
        $bairro = $cliente->getBairro();
        $estado = $cliente->getEstado();
        $telefone = $cliente->getTelefone();
        $email = $cliente->getEmail();
        $senha = $cliente->getSenha();
		
		
		$sql = 'INSERT INTO `clientes`(nome, cpf, rg, cep, endereco, bairro, estado, telefone, email, senha) VALUES (?,?,?,?,?,?,?,?,?,?)';
		$stmt = $this->banco->preparaStatement($sql);
		$stmt->bind_param('ssssssssss', $nome, $cpf, $rg, $cep, $endereco, $bairro, $estado, $telefone, $email, $senha);
		$stmt->execute(); 
		
		if($stmt->affected_rows > 0){
			$this->banco->executaQuery("DELETE FROM pre_clientes WHERE id={$cliente->getId()}");
			return $stmt->insert_id;
		}
		
		return 'erro';
    }
	
	public function autentificarCliente($cliente){
		
		$email = $cliente->getEmail();
		$senha = $cliente->getSenha();
		
		$sql = 'SELECT id,nome FROM clientes WHERE email = ? AND senha = ?';
		$stmt = $this->banco->preparaStatement($sql);
		$stmt->bind_param('ss', $email, $senha);
		$stmt->execute();
		$resultado = $stmt->get_result();
        $retorno = false;

        if ($resultado->num_rows == 1) 
            $retorno = $resultado->fetch_array();
        else {

            $sql = 'SELECT id FROM clientes WHERE email = ?';
            $stmt = $this->banco->preparaStatement($sql);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $resultado = $stmt->get_result();

            $retorno = $resultado->num_rows == 0 ? 'email' : 'senha';
            
        }
        return $retorno;
    }
	
	public function verificarCpf($cpf){
		$sql = 'SELECT id FROM clientes WHERE cpf = ?';
		$stmt = $this->banco->preparaStatement($sql);
		$stmt->bind_param('s', $cpf);
		$stmt->execute();
		$result = $stmt->get_result();
		
		return $result->num_rows;
	}
	
	public function verificarRg($rg){
		$sql = 'SELECT id FROM clientes WHERE rg = ?';
		$stmt = $this->banco->preparaStatement($sql);
		$stmt->bind_param('s',$rg);
		$stmt->execute();
		$result = $stmt->get_result();
		
		return $result->num_rows;
	}
	
	public function verificarEmail($email){
		$sql = 'SELECT id FROM clientes WHERE email = ?';
		$stmt = $this->banco->preparaStatement($sql);
		$stmt->bind_param('s',$email);
		$stmt->execute();
		$result = $stmt->get_result();
		
		return $result->num_rows;
	}
	
	public function verificarPreCpf($cpf){
		$sql = 'SELECT id FROM pre_clientes WHERE cpf = ?';
		$stmt = $this->banco->preparaStatement($sql);
		$stmt->bind_param('s',$cpf);
		$stmt->execute();
		$result = $stmt->get_result();
		
		return $result->num_rows;
	}
	
	public function verificarPreRg($rg){
		$sql = 'SELECT id FROM pre_clientes WHERE rg = ?';
		$stmt = $this->banco->preparaStatement($sql);
		$stmt->bind_param('s',$rg);
		$stmt->execute();
		$result = $stmt->get_result();
		
		return $result->num_rows;
	}
	
	public function verificarPreEmail($email){
		$sql = 'SELECT id FROM pre_clientes WHERE email = ?';
		$stmt = $this->banco->preparaStatement($sql);
		$stmt->bind_param('s',$email);
		$stmt->execute();
		$result = $stmt->get_result();
		
		return $result->num_rows;
	}

	public function selecionaClienteId($id){
		
		$sql = 'SELECT * FROM clientes WHERE id = ?';
		$stmt = $this->banco->preparaStatement($sql);
		$stmt->bind_param('i',$id);
		$stmt->execute();
		$result = $stmt->get_result();
		
		$cliente = null;
		
		while($linhas = $result->fetch_array()){
			$cliente = new Cliente($linhas);
		}
		
		return $cliente;
	}
	
	 public function alterarCliente($cliente) {
		
        $idCliente = $cliente->getId();
        $nome = $cliente->getNome();
        $cpf = $cliente->getCpf();
        $rg = $cliente->getRg();
        $cep = $cliente->getCep();
        $endereco = $cliente->getEndereco();
        $bairro = $cliente->getBairro();
        $estado = $cliente->getEstado();
        $telefone = $cliente->getTelefone();
		
		$stmt = $this->banco->preparaStatement('UPDATE clientes SET nome = ? WHERE id = ? AND nome != ?');
        $stmt->bind_param('sis', $nome, $idCliente, $nome);
        $stmt->execute(); 
		
		$stmt = $this->banco->preparaStatement('UPDATE clientes SET cpf = ? WHERE id = ? AND cpf != ?');
        $stmt->bind_param('sis', $cpf, $idCliente, $cpf);
        $stmt->execute();

        $stmt = $this->banco->preparaStatement('UPDATE clientes SET rg = ? WHERE id = ? AND rg != ?');
        $stmt->bind_param('sis', $rg, $idCliente, $rg);
        $stmt->execute();

        $stmt = $this->banco->preparaStatement('UPDATE clientes SET cep = ? WHERE id = ? AND cep != ?');
        $stmt->bind_param('sis', $cep, $idCliente, $cep);
        $stmt->execute();
		
		$stmt = $this->banco->preparaStatement('UPDATE clientes SET endereco = ? WHERE id = ? AND endereco != ?');
        $stmt->bind_param('sis', $endereco, $idCliente, $endereco);
        $stmt->execute();

        $stmt = $this->banco->preparaStatement('UPDATE clientes SET bairro = ? WHERE id = ? AND bairro != ?');
        $stmt->bind_param('sis', $bairro, $idCliente, $bairro);
        $stmt->execute();

        $stmt = $this->banco->preparaStatement('UPDATE clientes SET estado = ? WHERE id = ? AND estado != ?');
        $stmt->bind_param('sis', $estado, $idCliente, $estado);
        $stmt->execute(); 
		
		$stmt = $this->banco->preparaStatement('UPDATE clientes SET telefone = ? WHERE id = ? AND telefone != ?');
        $stmt->bind_param('sis', $telefone, $idCliente, $telefone);
        $stmt->execute();
    } 
}

?>