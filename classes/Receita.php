<?php
    class Receita{
        private $nomeReceita;
        private $idUsuario;

        function __construct($idUsuario, $nomeReceita)
        {
            $this->idUsuario = $idUsuario;
            $this->nomeReceita = $nomeReceita;
        }

        public static function selectReceitas($email){
            include '../includes/conecta_bd.inc';

            $query = "SELECT r.nomeReceita 
            FROM receita r, usuario u
            WHERE u.id = r.idUsuario
                AND u.email = '$email'";

            $resultado = mysqli_query($conexao, $query);
            $nomeReceita = null;
            if(mysqli_num_rows($resultado) > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $nomeReceita[$i] = $row['nome'];
                    $i++;
                }
            }
            mysqli_close($conexao);

            return $nomeReceita;
        }

        public static function selectId($nomeReceita, $email){
            include '../includes/conecta_bd.inc';

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

        public function cadastrarReceita(){
            include '../includes/conecta_bd.inc';

            $query = "INSERT INTO receita (idUsuario, nome) VALUES ($this->idUsuario, '$this->nomeReceita')";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }
        
    /*     public static function verificaItem($idItem, $idReceita){
            include '../includes/conecta_bd.inc';

            $query = "SELECT unidadeMedida, quantidade, nome FROM item WHERE id = '$idItem'";

            $resultado = mysqli_query($conexao, $query);
            
            $unimedItem = null;
            $quantidadeItem = null;
            $itemNome = null;
            if(mysqli_num_rows($resultado) > 0){
                while($row = mysqli_fetch_array($resultado)){
                    $unimedItem = $row['unidadedeMedida'];
                    $quantidadeItem = $row['quantidade'];                    
                    $itemNome = $row['nome'];                    
                }
            }
            
            $query = "SELECT unidadeMedida, quantidade FROM receitaitem WHERE idItem = '$idItem' and idReceita = '$idReceita'";

            $resultado = mysqli_query($conexao, $query);
            
            $unimedRec = null;
            $quantidadeRec = null;
            if(mysqli_num_rows($resultado) > 0){
                while($row = mysqli_fetch_array($resultado)){
                    $unimedRec = $row['unidadedeMedida'];
                    $quantidadeRec = $row['quantidade'];  
                }
            }
            
            
            if ($unimedItem != $unimedRec){
                $quantidadeRec = Receita_Item::converterMedidas($unimedItem, $unimedRec, $quantidadeRec, $itemNome);
            }
            
            mysqli_close($conexao);
            
            $verifica = ($quantidadeItem >= $quantidadeRec);

            return $verifica;
        }*/
        
        public static function valorItemReceita($idItem, $idReceita, $unimedRec, $quantidadeRec){
            include '../includes/conecta_bd.inc';
            

            $query = "SELECT e.preco, i.quantidade, i.unidadeMedida, i.nome, e.quantidade as quantidadeEstoque, e.lote  
            FROM item i, estoque e 
            WHERE e.idItem = '$idItem' AND i.id = e.idItem";

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
                  
            $i = 0;               
            $count = 0;            
            $custoTotal = 0;      
            $quantUsadaLote = [];  
            $custo = [];   
             
             
             
             if($quantidadeRec > $quantidadeEstoque[0]){
    
                foreach($lote as $value){
                    
                    while($count < $quantidadeRec){
                          
                        if($quantidadeEstoque[$i] > 0){
                            
                            $count++;
                            $quantidadeEstoque[$i]--;
                            
                            if($quantidadeEstoque[$i] == 0 || $count == $quantidadeRec){
                                
                                $quantUsadaLote[$i] = $count;
                                
                                if(count($quantUsadaLote) >= 2){
                                    
                                    for($j = 0; $j < count($quantUsadaLote)-1; $j++){
                                        
                                        $quantUsadaLote[$i]-=$quantUsadaLote[$j];
                                        
                                    }
                                }
                                
                                if ($unimedItem != $unimedRec){
                                     $quantUsadaLote[$i] = Receita_Item::converterMedidas($unimedItem, $unimedRec, ($quantUsadaLote[$i]), $itemNome);
                                     
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
                 
                if ($unimedItem != $unimedRec){
                    
                    $quantidadeRec = Receita_Item::converterMedidas($unimedItem, $unimedRec, $quantidadeRec, $itemNome);
                    print_r($quantidadeRec);
    
                }
                 
                $custoTotal = ($quantidadeRec*$preco[0])/$quantidadeItem;
                print_r($quantidadeRec);
         
            }
                      

              mysqli_close($conexao);

            return $custoTotal;
        }
         
             
             
            public function apagarReceita(){
                include '../includes/conecta_bd.inc';
                
                Receita_Item::apagarReceita_Item($this->idReceita);           
                

                $query = "DELETE FROM receita_item WHERE idReceita = '$this->idReceita'";

                $resultado = mysqli_query($conexao, $query);

                if($resultado){
                    return true;
                }
                return mysqli_error($conexao);
            }
    }
