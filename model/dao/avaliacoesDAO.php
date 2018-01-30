<?php

class AvaliacoesDAO {

    private $banco;

    public function __construct($bd) {
        $this->banco = $bd;
    }

    public function inserirAvaliacao($avalicao) {

	}
	
	public function selecionaMediaAvalicoes($idProduto){
		
		$sql = 'SELECT avaliacao , count(avaliacao) as quantidade  FROM avaliacoes_produtos WHERE id_produto = ? group by avaliacao ORDER BY avaliacao DESC';
		
        $stmt = $this->banco->preparaStatement($sql);
        $stmt->bind_param('i', $idProduto);
        $stmt->execute();
		
		$result = $stmt->get_result();
		
		$dados = [];
		$total = 0;
		$cores = ['88b131','add633','ffd834','ffb234','ff8b5a'];
		
		while($linhas = $result->fetch_array()){
			$dados[$linhas['avaliacao']] = $linhas['quantidade'];
			$total+= $linhas['quantidade'];
		}
		
		$ic = 0;
		for($i = 5; $i > 0; $i--){
			
			if(isset($dados[$i])){
				$porcentagem = ($dados[$i] * 100)/$total ;
				$retorno[$i] = "<div id='grafAvaliacoes'>
					<sup>$i</sup>
					<img src='img/icones/estrela.png' id='estrelaAvaliacao'>
					<div id='localPorcentagemGraf'>
						<div style='background:#{$cores[$ic]};width:{$porcentagem}%'></div>
						<div>{$dados[$i]}</div>
					</div> 
				</div>";
			}else{
				$retorno[$i] = "<div id='grafAvaliacoes'>
					<sup>$i</sup>
					<img src='img/icones/estrela.png' id='estrelaAvaliacao'>
					<div id='localPorcentagemGraf'>
						<div style='width:0%'></div>
						<div>0</div>
					</div> 
				</div>";
			}
			$ic++;
		}
		
		return implode('',$retorno);
	}
	
	public function selecionaAvaliacoesCliente($idProduto){
		
		$sql = 'SELECT C.nome, A.avaliacao, A.comentario, A.data FROM avaliacoes_produtos A INNER JOIN clientes C ON C.id = A.id_cliente WHERE id_produto = ?';
        $stmt = $this->banco->preparaStatement($sql);
        $stmt->bind_param('i', $idProduto);
        $stmt->execute();
		
		$result = $stmt->get_result();
		
		$retorno = null;
		setlocale(LC_ALL, 'pt-br');
		
		while($linhas = $result->fetch_array()){
			
			$estrelas = null;
			for($i = 0; $i < 5; $i++) $estrelas .= "<img src='img/icones/estrela.png' id='estrelaAvaliacao'>";
			
			$porcentagem = $linhas['avaliacao'] * 20;
			$data = strftime('%d de %b de %Y', strtotime($linhas['data']));
			
			$avaliacao = "<div id='avaliacoesCincoEstrelasDoProduto'>
						<sup>{$linhas['avaliacao']}</sup>
						<div id='localPorcentagemEstrelas'>
							<div style='width:{$porcentagem}%'></div>
							<div>{$estrelas}</div>
						</div> 
					</div>";
			
			$retorno.= "<div id='avalicaoCliente'>
							<div id='find1'>
								<table>
									<tr>
										<td rowspan='2'><img src='img/icones/user.png' id='user'></td>
										<td>{$linhas['nome']}</td>
									</tr>
									<tr>
										<td>{$data}</td>
									</tr>
								</table>
							</div>
							<div id='find2'>
								<a>{$linhas['comentario']}</a>
								 {$avaliacao}
							</div>
						</div>";
		}
		
		return $retorno;
	}
}

?>