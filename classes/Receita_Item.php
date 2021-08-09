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

		public static function selectQuantidadeLote($idItem, $unimedRec, $quantidadeRec){
			include __DIR__.'./../includes/conecta_bd.inc';
            

            $query = "SELECT e.id, i.nome, i.unidadeMedida, e.quantidade as quantidadeEstoque, e.lote 
            FROM item i, estoque e 
            WHERE e.idItem = $idItem 
                AND i.id = e.idItem
                AND e.statusItem = '1'";

            $resultado = mysqli_query($conexao, $query);
            
			$idEstoque = null;
            $quantidadeEstoque = null;
            $nomeItem = null;
            $unimedItem = null;
            $lote = null;
            if(mysqli_num_rows($resultado) > 0){
                while($row = mysqli_fetch_array($resultado)){ 
					$idEstoque[] = $row['id'];                
                    $quantidadeEstoque[] = $row['quantidadeEstoque'];   
					$lote[] = $row['lote'];  
					$nomeItem = $row['nome'];                
                    $unimedItem = $row['unidadeMedida'];           
                }
            }
                  
            $i = 0;                 //Índice p/ utilizar as quantidades de estoque e preços dos respectivos lotes            
            $count = 0;             //Contador p/ controlar a quantidade de vezes que o laço será executado
            $quantUsadaLote = [];   //Variável p/ armazenar as quantidades de estoque utilizadas por lote
            
            /**
             * ($quantidadeRec > $quantidadeEstoque[0])  -> Mútiplos lotes
             * !($quantidadeRec > $quantidadeEstoque[0]) -> Cálculo simples
             */
            if($quantidadeRec > $quantidadeEstoque[0]){
                foreach($lote as $value){
                    while($count < $quantidadeRec){
                        if($quantidadeEstoque[$i] > 0){
                            $count++;
                            $quantidadeEstoque[$i]--;

                             /**
                             * Se o lote acabar, ou a quantidade necessária for suprida,
                             * é calculado a quantidade usada deste lote
                             */
                            if($quantidadeEstoque[$i] == 0 || $count == $quantidadeRec){ 
                                $quantUsadaLote[$i] = $count;

                                if(count($quantUsadaLote) >= 2){
                                    for($j = 0; $j < count($quantUsadaLote)-1; $j++){
                                        $quantUsadaLote[$i]-=$quantUsadaLote[$j];
                                    }
                                }
                                
                                //Conversão da unidade de medida
                                if ($unimedItem != $unimedRec){
                                    $quantUsadaLote[$i] = Receita_Item::converterMedidas($unimedItem, $unimedRec, $quantUsadaLote[$i], $nomeItem);
								}
                            }
                        }else{
                            break 1;
                        }
                    }    
                    $i++;
                }
            }else{
				$quantUsadaLote[0] = $quantidadeRec;
                //Conversão da unidade de medida
                if ($unimedItem != $unimedRec){
                    $quantUsadaLote[0] = Receita_Item::converterMedidas($unimedItem, $unimedRec, $quantUsadaLote[0], $nomeItem);
                }
            }
            
            mysqli_close($conexao);

            return array($idEstoque, $quantUsadaLote);
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

    	public static function converterMedidas($unimedItem, $unimedReceita, $quantidadeReceita, $itemNome){
            switch ($unimedItem) {
                case 'ML':

					switch ($unimedReceita) {
						case 'GRAMAS':
							$novaQuantidade = $quantidadeReceita;
						break;

						case 'COLHER_DE_SOPA':
							$novaQuantidade = $quantidadeReceita * 15;
						break;

						case 'COLHER_DE_CHA':
							$novaQuantidade = $quantidadeReceita * 5;
						break;

						case 'COLHER_DE_CAFE':
							$novaQuantidade = $quantidadeReceita * 2;
						break;

						case 'XICARA':
							$novaQuantidade = $quantidadeReceita * 240;
						break;

						case 'LITRO(S)':
							$novaQuantidade = $quantidadeReceita * 1000;
						break;

						case 'QUILO':
							$novaQuantidade = $quantidadeReceita * 1000;
						break;
					}
                break;

				case 'GRAMAS':

					switch ($unimedReceita) {
						case 'ML':
							$novaQuantidade = $quantidadeReceita;
						break;

						case 'COLHER_DE_SOPA':
							//Valor padrão
							$novaQuantidade = $quantidadeReceita * 14;

							if(strpos($itemNome, 'AÇÚCAR') !== false || strpos($itemNome, 'AÇUCAR') !== false){
								$novaQuantidade = $quantidadeReceita * 10;
							}
							if(strpos($itemNome, 'TRIGO') !== false){
								$novaQuantidade = $quantidadeReceita * 7.5;
							}
							if(strpos($itemNome, 'CHOCOLATE EM PÓ') !== false){
								$novaQuantidade = $quantidadeReceita * 6;
							}
							if(strpos($itemNome, 'COCO RALADO') !== false){
								$novaQuantidade = $quantidadeReceita * 5;
							}
						break;

						case 'COLHER_DE_CHA':
							//Valor padrão
							$novaQuantidade = $quantidadeReceita * 4;

							if(strpos($itemNome, 'AÇÚCAR') !== false || strpos($itemNome, 'AÇUCAR') !== false){
								$novaQuantidade = $quantidadeReceita * 3.5;
							}
							if(strpos($itemNome, 'TRIGO') !== false){
								$novaQuantidade = $quantidadeReceita * 2.5;
							}
							if(strpos($itemNome, 'CHOCOLATE EM PÓ') !== false){
								$novaQuantidade = $quantidadeReceita * 2;
							}
							if(strpos($itemNome, 'COCO RALADO') !== false){
								$novaQuantidade = $quantidadeReceita * 1.5;
							}
						break;

						case 'COLHER_DE_CAFE':
							$novaQuantidade = $quantidadeReceita * 1.5;
						break;

						case 'XICARA':
							//Valor padrão
							$novaQuantidade = $quantidadeReceita * 165;

							if(strpos($itemNome, 'MANTEIGA') !== false || strpos($itemNome, 'MARGARINA') !== false){
								$novaQuantidade = $quantidadeReceita * 200;
							}
							if(strpos($itemNome, 'AÇÚCAR') !== false || strpos($itemNome, 'AÇUCAR') !== false){
								$novaQuantidade = $quantidadeReceita * 160;
							}
							if(strpos($itemNome, 'TRIGO') !== false){
								$novaQuantidade = $quantidadeReceita * 120;
							}
							if(strpos($itemNome, 'CHOCOLATE EM PÓ') !== false){
								$novaQuantidade = $quantidadeReceita * 90;
							}
							if(strpos($itemNome, 'COCO RALADO') !== false){
								$novaQuantidade = $quantidadeReceita * 80;
							}
						break;

						case 'LITRO(S)':
							$novaQuantidade = $quantidadeReceita * 1000;
						break;

						case 'QUILO':
							$novaQuantidade = $quantidadeReceita * 1000;
						break;
					}
                break;

				case 'COLHER_DE_SOPA':

					switch ($unimedReceita) {
						case 'ML':
							$novaQuantidade = $quantidadeReceita / 15;
						break;

						case 'GRAMAS':
							//Valor padrão
							$novaQuantidade = $quantidadeReceita / 14;

							if(strpos($itemNome, 'AÇÚCAR') !== false || strpos($itemNome, 'AÇUCAR') !== false){
								$novaQuantidade = $quantidadeReceita / 10;
							}
							if(strpos($itemNome, 'TRIGO') !== false){
								$novaQuantidade = $quantidadeReceita / 7.5;
							}
							if(strpos($itemNome, 'CHOCOLATE EM PÓ') !== false){
								$novaQuantidade = $quantidadeReceita / 6;
							}
							if(strpos($itemNome, 'COCO RALADO') !== false){
								$novaQuantidade = $quantidadeReceita / 5;
							}
						break;

						case 'COLHER_DE_CHA':
							$novaQuantidade = $quantidadeReceita / 3;

							if(strpos($itemNome, 'AÇÚCAR') !== false || strpos($itemNome, 'AÇUCAR') !== false){
								$novaQuantidade = $quantidadeReceita / 2.85;
							}
							if(strpos($itemNome, 'TRIGO') !== false){
								$novaQuantidade = $quantidadeReceita / 3;
							}
							if(strpos($itemNome, 'CHOCOLATE EM PÓ') !== false){
								$novaQuantidade = $quantidadeReceita / 3;
							}
							if(strpos($itemNome, 'COCO RALADO') !== false){
								$novaQuantidade = $quantidadeReceita / 3.33;
							}
						break;

						case 'COLHER_DE_CAFE':
							$novaQuantidade = $quantidadeReceita / 9;
						break;

						case 'XICARA':
							//Valor padrão
							$novaQuantidade = $quantidadeReceita * 16;

							if(strpos($itemNome, 'CHOCOLATE EM PÓ') !== false){
								$novaQuantidade = $quantidadeReceita * 15;
							}
						break;

						case 'LITRO(S)':
							$novaQuantidade = ($quantidadeReceita /15) * 1000;
						break;

						case 'QUILO(S)':
							//Valor padrão
							$novaQuantidade = ($quantidadeReceita / 14) * 1000;

							if(strpos($itemNome, 'AÇÚCAR') !== false || strpos($itemNome, 'AÇUCAR') !== false){
								$novaQuantidade = ($quantidadeReceita / 10) * 1000;
							}
							if(strpos($itemNome, 'TRIGO') !== false){
								$novaQuantidade = ($quantidadeReceita / 7.5) * 1000;
							}
							if(strpos($itemNome, 'CHOCOLATE EM PÓ') !== false){
								$novaQuantidade = ($quantidadeReceita / 6) * 1000;
							}
							if(strpos($itemNome, 'COCO RALADO') !== false){
								$novaQuantidade = ($quantidadeReceita / 5) * 1000;
							}
						break;
					}

				break;

                case 'COLHER_DE_CHA':

					switch ($unimedReceita) {
						case 'ML':
							$novaQuantidade = $quantidadeReceita / 5;
						break;

						case 'GRAMAS':
							//Valor padrão
							$novaQuantidade = $quantidadeReceita / 4;

							if(strpos($itemNome, 'AÇÚCAR') !== false || strpos($itemNome, 'AÇUCAR') !== false){
								$novaQuantidade = $quantidadeReceita / 3.5;
							}
							if(strpos($itemNome, 'TRIGO') !== false){
								$novaQuantidade = $quantidadeReceita / 2.5;
							}
							if(strpos($itemNome, 'CHOCOLATE EM PÓ') !== false){
								$novaQuantidade = $quantidadeReceita / 2;
							}
							if(strpos($itemNome, 'COCO RALADO') !== false){
								$novaQuantidade = $quantidadeReceita / 1.5;
							}
						break;

						case 'COLHER_DE_SOPA':
							//Valor padrão
							$novaQuantidade = $quantidadeReceita * 3;

							if(strpos($itemNome, 'AÇÚCAR') !== false || strpos($itemNome, 'AÇUCAR') !== false){
								$novaQuantidade = $quantidadeReceita * 2.85;
							}
							if(strpos($itemNome, 'TRIGO') !== false){
								$novaQuantidade = $quantidadeReceita * 3;
							}
							if(strpos($itemNome, 'CHOCOLATE EM PÓ') !== false){
								$novaQuantidade = $quantidadeReceita * 3;
							}
							if(strpos($itemNome, 'COCO RALADO') !== false){
								$novaQuantidade = $quantidadeReceita * 3.33;
							}
						break;

						case 'COLHER_DE_CAFE':
							$novaQuantidade = $quantidadeReceita / 3;
						break;

						case 'XICARA':
							$novaQuantidade = $quantidadeReceita * 48;
						break;

						case 'LITRO(S)':
							$novaQuantidade = ($quantidadeReceita /5) * 1000;
						break;

						case 'QUILO(S)':
							//Valor padrão
							$novaQuantidade = ($quantidadeReceita /4) * 1000;

							if(strpos($itemNome, 'AÇÚCAR') !== false || strpos($itemNome, 'AÇUCAR') !== false){
								$novaQuantidade = ($quantidadeReceita / 3.5) * 1000;
							}
							if(strpos($itemNome, 'TRIGO') !== false){
								$novaQuantidade = ($quantidadeReceita / 2.5) * 1000;
							}
							if(strpos($itemNome, 'CHOCOLATE EM PÓ') !== false){
								$novaQuantidade = ($quantidadeReceita / 2) * 1000;
							}
							if(strpos($itemNome, 'COCO RALADO') !== false){
								$novaQuantidade = ($quantidadeReceita / 1.5) * 1000;
							}
						break;
					}
                break;

				case 'COLHER_DE_CAFE':

					switch ($unimedReceita) {
						case 'ML':
							$novaQuantidade = $quantidadeReceita / 2;
						break;

						case 'GRAMAS':
							$novaQuantidade = $quantidadeReceita / 1.5;
						break;

						case 'COLHER_DE_SOPA':
							$novaQuantidade = $quantidadeReceita * 9;
						break;

						case 'COLHER_DE_CHA':
							$novaQuantidade = $quantidadeReceita * 3;
						break;

						case 'XICARA':
							$novaQuantidade = $quantidadeReceita * 144;
						break;

						case 'LITRO(S)':
							$novaQuantidade = ($quantidadeReceita /2) * 1000;
						break;

						case 'QUILO(S)':
							$novaQuantidade = ($quantidadeReceita /1.5) * 1000;
						break;
					}
				break;

				case 'XICARA':

					switch ($unimedReceita) {
						case 'ML':
							$novaQuantidade = $quantidadeReceita / 240;
						break;

						case 'GRAMAS':
							//Valor padrão
							$novaQuantidade = $quantidadeReceita / 165;

							if(strpos($itemNome, 'MANTEIGA') !== false || strpos($itemNome, 'MARGARINA') !== false){
								$novaQuantidade = $quantidadeReceita / 200;
							}
							if(strpos($itemNome, 'AÇÚCAR') !== false || strpos($itemNome, 'AÇUCAR') !== false){
								$novaQuantidade = $quantidadeReceita / 160;
							}
							if(strpos($itemNome, 'TRIGO') !== false){
								$novaQuantidade = $quantidadeReceita / 120;
							}
							if(strpos($itemNome, 'CHOCOLATE EM PÓ') !== false){
								$novaQuantidade = $quantidadeReceita / 90;
							}
							if(strpos($itemNome, 'COCO RALADO') !== false){
								$novaQuantidade = $quantidadeReceita / 80;
							}
						break;

						case 'COLHER_DE_SOPA':
							//Valor padrão
							$novaQuantidade = $quantidadeReceita / 16;

							if(strpos($itemNome, 'CHOCOLATE EM PÓ') !== false){
								$novaQuantidade = $quantidadeReceita / 15;
							}
						break;

						case 'COLHER_DE_CHA':
							$novaQuantidade = $quantidadeReceita / 48;
						break;

						case 'COLHER_DE_CAFE':
							$novaQuantidade = $quantidadeReceita / 144;
						break;

						case 'LITRO(S)':
							$novaQuantidade = ($quantidadeReceita /240) * 1000;
						break;

						case 'QUILO(S)':
							$novaQuantidade = ($quantidadeReceita /165) * 1000;
						break;
					}
				break;

				case 'LITRO(S)':

					switch ($unimedReceita) {

						case 'ML':
							$novaQuantidade = $quantidadeReceita / 1000;
						break;

						case 'GRAMAS':
							$novaQuantidade = $quantidadeReceita / 1000;
						break;

						case 'COLHER_DE_SOPA':
							$novaQuantidade = ($quantidadeReceita * 15) / 1000;
						break;

						case 'COLHER_DE_CHA':
							$novaQuantidade = ($quantidadeReceita * 5) / 1000;
						break;

						case 'COLHER_DE_CAFE':
							$novaQuantidade = ($quantidadeReceita * 2) / 1000 ;
						break;

						case 'XICARA':
							$novaQuantidade = ($quantidadeReceita * 240) / 1000 ;
						break;

						case 'QUILO(S)':
							$novaQuantidade = $quantidadeReceita;
						break;
					}
				break;

				case 'QUILO(S)':

					switch ($unimedReceita) {

						case 'ML':
							$novaQuantidade = $quantidadeReceita / 1000;
						break;

						case 'GRAMAS':
							$novaQuantidade = $quantidadeReceita / 1000;
						break;

						case 'COLHER_DE_SOPA':
							//Valor padrão
							$novaQuantidade = ($quantidadeReceita * 14) / 1000;

							if(strpos($itemNome, 'AÇÚCAR') !== false || strpos($itemNome, 'AÇUCAR') !== false){
								$novaQuantidade = ($quantidadeReceita * 10) / 1000;
							}
							if(strpos($itemNome, 'TRIGO') !== false){
								$novaQuantidade = ($quantidadeReceita * 7.5) / 1000;
							}
							if(strpos($itemNome, 'CHOCOLATE EM PÓ') !== false){
								$novaQuantidade = ($quantidadeReceita * 6) / 1000;
							}
							if(strpos($itemNome, 'COCO RALADO') !== false){
								$novaQuantidade = ($quantidadeReceita * 5) / 1000;
							}
						break;

						case 'COLHER_DE_CHA':
							//Valor padrão
							$novaQuantidade = ($quantidadeReceita * 4) / 1000;

							if(strpos($itemNome, 'AÇÚCAR') !== false || strpos($itemNome, 'AÇUCAR') !== false){
								$novaQuantidade = ($quantidadeReceita * 3.5) / 1000;
							}
							if(strpos($itemNome, 'TRIGO') !== false){
								$novaQuantidade = ($quantidadeReceita * 2.5) / 1000;
							}
							if(strpos($itemNome, 'CHOCOLATE EM PÓ') !== false){
								$novaQuantidade = ($quantidadeReceita * 2) / 1000;
							}
							if(strpos($itemNome, 'COCO RALADO') !== false){
								$novaQuantidade = ($quantidadeReceita * 1.5) / 1000;
							}
						break;

						case 'COLHER_DE_CAFE':
							$novaQuantidade = ($quantidadeReceita * 1.5) / 1000 ;
						break;

						case 'XICARA':
							$novaQuantidade = ($quantidadeReceita * 165) / 1000 ;
						break;

						case 'LITRO(S)':
							$novaQuantidade = $quantidadeReceita;
						break;
					}
				break;
            }
			return $novaQuantidade;
        }
    }