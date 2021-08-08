<?php
    class Receita{
        private $nomeReceita;
        private $idUsuario;

        function __construct($idUsuario, $nomeReceita){
            $this->idUsuario = $idUsuario;
            $this->nomeReceita = $nomeReceita;
        }

        public function cadastrarReceita(){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "INSERT INTO receita (idUsuario, nome) VALUES ($this->idUsuario, '$this->nomeReceita')";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }

        //*Adicionar mais atributos a tabela
        public static function infoReceita($idReceita){
            include __DIR__.'./../includes/conecta_bd.inc';
            include_once __DIR__.'./Receita_Item.php';

            $query = "SELECT nome 
            FROM receita 
            WHERE id = $idReceita";

            $resultado = mysqli_query($conexao, $query);

            $nome = null;
            if(mysqli_num_rows($resultado) > 0){
                while($row = mysqli_fetch_array($resultado)){
                    $nome = $row['nome'];
                }
            }
            mysqli_close($conexao);

            list($idItem, $quantidade, $unidadeMedida, $custo) = Receita_Item::selectReceita_Itens($idReceita);

            return array($nome, $idItem, $quantidade, $unidadeMedida, $custo);
        }

        public static function selectReceitas($email){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "SELECT r.id, r.nome 
            FROM receita r, usuario u
            WHERE u.id = r.idUsuario
                AND u.email = '$email'";

            $resultado = mysqli_query($conexao, $query);
            
            $id = null;
            $nome = null;
            if(mysqli_num_rows($resultado) > 0){
                while($row = mysqli_fetch_array($resultado)){
                    $id[] = $row['id'];
                    $nome[] = $row['nome'];
                }
            }
            mysqli_close($conexao);

            return array($id, $nome);
        }

        public static function selectId($nomeReceita, $email){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "SELECT r.id 
            FROM receita r, usuario u 
            WHERE r.nome = '$nomeReceita'
                AND u.id = r.idUsuario
                AND u.email = '$email'";

            $resultado = mysqli_query($conexao, $query);
            
            $id = null;
            if(mysqli_num_rows($resultado) > 0){
                while($row = mysqli_fetch_array($resultado)){
                    $id = $row['id'];
                }
            }

            mysqli_close($conexao);

            return $id;
        }
        
        public static function valorItemReceita($idItem, $idReceita, $unimedRec, $quantidadeRec){
            include __DIR__.'./../includes/conecta_bd.inc';
            

            $query = "SELECT e.preco, i.quantidade, i.unidadeMedida, i.nome, e.quantidade as quantidadeEstoque, e.lote  
            FROM item i, estoque e 
            WHERE e.idItem = $idItem 
                AND i.id = e.idItem
                AND e.statusItem = '1'";

            $resultado = mysqli_query($conexao, $query);
            
            $preco = null;
            $quantidadeItem = null;
            $quantidadeEstoque = null;
            $unimedItem = null;
            $itemNome = null;
            $lote = null;
            if(mysqli_num_rows($resultado) > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $preco[$i] = $row['preco'];
                    $quantidadeItem = $row['quantidade'];                   
                    $quantidadeEstoque[$i] = $row['quantidadeEstoque'];                    
                    $unimedItem = $row['unidadeMedida'];                    
                    $itemNome = $row['nome'];
                    $lote[$i] = $row['lote']; 
                    $i++;                
                }
            }
                  
            $i = 0;                 //Índice p/ utilizar as quantidades de estoque e preços dos respectivos lotes            
            $count = 0;             //Contador p/ controlar a quantidade de vezes que o laço será executado
            $custoTotal = 0;        //Custo final do ingrediente
            $quantUsadaLote = [];   //Variável p/ armazenar as quantidades de estoque utilizadas por lote
            $custo = [];            //Variável p/ armazenar os custos dos lotes
            
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
                                    $quantUsadaLote[$i] = Receita_Item::converterMedidas($unimedItem, $unimedRec, $quantUsadaLote[$i], $itemNome);
                                }
                                
                                $custo[$i] = (($quantUsadaLote[$i])*$preco[$i])/$quantidadeItem;  
                            }
                        }else{
                            break 1;
                        }
                    }    
                    $i++;
                }

                for($j=0; $j < $i; $j++){
                    $custoTotal+=$custo[$j];
                }
            }else{
                //Conversão da unidade de medida
                if ($unimedItem != $unimedRec){
                    $quantidadeRec = Receita_Item::converterMedidas($unimedItem, $unimedRec, $quantidadeRec, $itemNome);
                }
                    
                $custoTotal = ($quantidadeRec*$preco[0])/$quantidadeItem;
            }
            
            mysqli_close($conexao);

            return $custoTotal;
        }

        public function apagarItensReceita(){
            include '../includes/conecta_bd.inc';
            
            Receita_Item::apagarReceita_Item($this->idReceita);           
            

            $query = "DELETE FROM receita_item WHERE idReceita = '$this->idReceita'";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }

        /**
         * @return int -> Número máximo de receitas possíveis de serem realizadas com o item informado;
         * @return null -> Receita não pode ser realizada (item inválido || estoque insuficiente)
         */
        public static function selectMaxReceitas($idItem, $quantidadeReceita, $unidadeMedidaRec, $email){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "SELECT i.nome, SUM(e.quantidade) AS quantidadeEstoque, i.unidadeMedida
            FROM estoque e, item i, usuario u
            WHERE u.id = e.idUsuario
                AND e.idItem = i.id
                AND e.statusItem = '1'
                AND u.email = '$email'
                AND i.id = $idItem
            GROUP BY i.id";

            $resultado = mysqli_query($conexao, $query);

            $nomeItem = null;
            $quantidadeEstoque = null;
            $unidadeMedidaItem = null;
            $numMaxReceitas = null;
            if(mysqli_num_rows($resultado) > 0){
                while($row = mysqli_fetch_array($resultado)){
                    $nomeItem = $row['nome'];
                    $quantidadeEstoque = $row['quantidadeEstoque'];
                    $unidadeMedidaItem = $row['unidadeMedida'];
                }
 
                if($unidadeMedidaItem != $unidadeMedidaRec){
                    include_once __DIR__.'./Receita_Item.php';

                    $unidadeMedidaRec = str_replace(" ", "_", $unidadeMedidaRec);
    
                    $quantidadeReceita = Receita_Item::converterMedidas($unidadeMedidaItem, $unidadeMedidaRec, $quantidadeReceita, $nomeItem);
                }

                if($quantidadeEstoque < $quantidadeReceita){
                    return null;
                }

                $numMaxReceitas = floor($quantidadeEstoque / $quantidadeReceita);
            }
            mysqli_close($conexao);

            return $numMaxReceitas;
        }
    }