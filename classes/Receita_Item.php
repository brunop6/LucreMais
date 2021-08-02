<?php
    class Receita_Item{
		private $idReceita;
		private $idItem;
		private $quantidade;
		private $unidadeMedida;
		private $custo;

      	function __construct($idReceita, $idItem, $quantidade, $unidadeMedida, $custo)
        {
            $this->idReceita = $idReceita;
            $this->idItem = $idItem;
            $this->quantidade = $quantidade;
            $this->unidadeMedida = $unidadeMedida;
            $this->custo = $custo;
        }

		public function cadastrarReceita_Item(){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "INSERT INTO receitaitem (idReceita, idItem, quantidade, unidadeMedida, custo)
            VALUES ('$this->idReceita', '$this->idItem', '$this->quantidade', '$this->unidadeMedida', '$this->custo')";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }

        public static function selectReceita_Itens($idReceita){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "SELECT idItem, quantidade, unidadeMedida, custo
            FROM receitaitem WHERE idReceita = '$idReceita' ";

            $resultado = mysqli_query($conexao, $query);
            $idItem = null;
            $quantidade = null;
            $unidadeMedida = null;
            $custo = null;
            if(mysqli_num_rows($resultado) > 0){
                while($row = mysqli_fetch_array($resultado)){
                    $idItem[] = $row['idItem'];
                    $quantidade[] = $row['quantidade'];
                    $unidadeMedida[] = str_replace("_", " ", $row['unidadeMedida']);
                    $custo[] = number_format($row['custo'], 2);
                }
            }
            mysqli_close($conexao);

            return array ($idItem, $quantidade, $unidadeMedida, $custo);
        }

        public function editarReceita_Item(){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "UPDATE receitaitem
                SET idItem = '$this->idItem', quantidade = '$this->quantidade', unidadeMedida = $this->unidadeMedida
                WHERE idReceita = '$this->idReceita'";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }

        public function apagarItem(){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "DELETE FROM receitaitem WHERE  idItem = '$this->idItem' 
				AND idReceita = '$this->idReceita'";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }

        public static function apagarReceita_Item($idReceita){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "DELETE FROM receitaitem WHERE idReceita = '$idReceita' ";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }

    	public static function converterMedidas($unimedPrinc, $unimedSec, $quantidadeSec, $itemNome){
            switch ($unimedPrinc) {
                case 'ML':

					switch ($unimedSec) {
						case 'GRAMAS':
							$novaQuantidade = $quantidadeSec;
						break;

						case 'COLHER_DE_SOPA':
							$novaQuantidade = $quantidadeSec * 15;
						break;

						case 'COLHER_DE_CHA':
							$novaQuantidade = $quantidadeSec * 5;
						break;

						case 'COLHER_DE_CAFE':
							$novaQuantidade = $quantidadeSec * 2;
						break;

						case 'XICARA':
							$novaQuantidade = $quantidadeSec * 240;
						break;

						case 'LITRO(S)':
							$novaQuantidade = $quantidadeSec * 1000;
						break;

						case 'QUILO':
							$novaQuantidade = $quantidadeSec * 1000;
						break;
					}
                break;

				case 'GRAMAS':

					switch ($unimedSec) {
						case 'ML':
							$novaQuantidade = $quantidadeSec;
						break;

						case 'COLHER_DE_SOPA':
							$novaQuantidade = $quantidadeSec * 14;
						break;

						case 'COLHER_DE_CHA':
							$novaQuantidade = $quantidadeSec * 4;
						break;

						case 'COLHER_DE_CAFE':
							$novaQuantidade = $quantidadeSec * 1.5;
						break;

						case 'XICARA':
							$novaQuantidade = $quantidadeSec * 165;
						break;

						case 'LITRO(S)':
							$novaQuantidade = $quantidadeSec * 1000;
						break;

						case 'QUILO':
							$novaQuantidade = $quantidadeSec * 1000;
						break;
					}
                break;

				case 'COLHER_DE_SOPA':

					switch ($unimedSec) {
						case 'ML':
							$novaQuantidade = $quantidadeSec / 15;
						break;

						case 'GRAMAS':
							$novaQuantidade = $quantidadeSec / 14;
						break;

						case 'COLHER_DE_CHA':
							$novaQuantidade = $quantidadeSec / 3;
						break;

						case 'COLHER_DE_CAFE':
							$novaQuantidade = $quantidadeSec / 9;
						break;

						case 'XICARA':
							$novaQuantidade = $quantidadeSec * 16;
						break;

						case 'LITRO(S)':
							$novaQuantidade = ($quantidadeSec /15) * 1000;
						break;

						case 'QUILO(S)':
							$novaQuantidade = ($quantidadeSec /14) * 1000;
						break;
					}

				break;

                case 'COLHER_DE_CHA':

					switch ($unimedSec) {
						case 'ML':
							$novaQuantidade = $quantidadeSec / 5;
						break;

						case 'GRAMAS':
							$novaQuantidade = $quantidadeSec / 4;
						break;

						case 'COLHER_DE_SOPA':
							$novaQuantidade = $quantidadeSec * 3;
						break;

						case 'COLHER_DE_CAFE':
							$novaQuantidade = $quantidadeSec / 3;
						break;

						case 'XICARA':
							$novaQuantidade = $quantidadeSec * 48;
						break;

						case 'LITRO(S)':
							$novaQuantidade = ($quantidadeSec /5) * 1000;
						break;

						case 'QUILO(S)':
							$novaQuantidade = ($quantidadeSec /4) * 1000;
						break;
					}
                break;

				case 'COLHER_DE_CAFE':

					switch ($unimedSec) {
						case 'ML':
							$novaQuantidade = $quantidadeSec / 2;
						break;

						case 'GRAMAS':
							$novaQuantidade = $quantidadeSec / 1.5;
						break;

						case 'COLHER_DE_SOPA':
							$novaQuantidade = $quantidadeSec * 9;
						break;

						case 'COLHER_DE_CHA':
							$novaQuantidade = $quantidadeSec * 3;
						break;

						case 'XICARA':
							$novaQuantidade = $quantidadeSec * 144;
						break;

						case 'LITRO(S)':
							$novaQuantidade = ($quantidadeSec /2) * 1000;
						break;

						case 'QUILO(S)':
							$novaQuantidade = ($quantidadeSec /1.5) * 1000;
						break;
					}
				break;

				case 'XICARA':

					switch ($unimedSec) {
						case 'ML':
							$novaQuantidade = $quantidadeSec / 240;
						break;

						case 'GRAMAS':
							$novaQuantidade = $quantidadeSec / 165;
						break;

						case 'COLHER_DE_SOPA':
							$novaQuantidade = $quantidadeSec / 16;
						break;

						case 'COLHER_DE_CHA':
							$novaQuantidade = $quantidadeSec / 48;
						break;

						case 'COLHER_DE_CAFE':
							$novaQuantidade = $quantidadeSec / 144;
						break;

						case 'LITRO(S)':
							$novaQuantidade = ($quantidadeSec /240) * 1000;
						break;

						case 'QUILO(S)':
							$novaQuantidade = ($quantidadeSec /165) * 1000;
						break;
					}
				break;

				case 'LITRO(S)':

					switch ($unimedSec) {

						case 'ML':
							$novaQuantidade = $quantidadeSec / 1000;
						break;

						case 'GRAMAS':
							$novaQuantidade = $quantidadeSec / 1000;
						break;

						case 'COLHER_DE_SOPA':
							$novaQuantidade = ($quantidadeSec * 15) / 1000;
						break;

						case 'COLHER_DE_CHA':
							$novaQuantidade = ($quantidadeSec * 5) / 1000;
						break;

						case 'COLHER_DE_CAFE':
							$novaQuantidade = ($quantidadeSec * 2) / 1000 ;
						break;

						case 'XICARA':
							$novaQuantidade = ($quantidadeSec * 240) / 1000 ;
						break;

						case 'QUILO(S)':
							$novaQuantidade = $quantidadeSec;
						break;
					}
				break;

				case 'QUILO(S)':

					switch ($unimedSec) {

						case 'ML':
							$novaQuantidade = $quantidadeSec / 1000;
						break;

						case 'GRAMAS':
							$novaQuantidade = $quantidadeSec / 1000;
						break;

						case 'COLHER_DE_SOPA':
							$novaQuantidade = ($quantidadeSec * 14) / 1000;
						break;

						case 'COLHER_DE_CHA':
							$novaQuantidade = ($quantidadeSec * 4) / 1000;
						break;

						case 'COLHER_DE_CAFE':
							$novaQuantidade = ($quantidadeSec * 1.5) / 1000 ;
						break;

						case 'XICARA':
							$novaQuantidade = ($quantidadeSec * 165) / 1000 ;
						break;

						case 'LITRO(S)':
							$novaQuantidade = $quantidadeSec;
						break;
					}
				break;
            }
			return $novaQuantidade;
        }
    }
