<?php
    class Receita_Item{
        private $idReceita;
        private $idItem;
        private $quantidade;
        private $unidadeMedida;
        private $custo;

        function __construct($idReceita, $idItem, $quantidade, $unidadeMedida,$custo)
        {
            $this->idReceita = $idReceita;
            $this->idItem = $idItem;
            $this->quantidade = $quantidade;
            $this->unidadeMedida = $unidadeMedida;
            $this->custo = $custo;
        }

        public static function selectReceita_Itens($idReceita){
            include '../includes/conecta_bd.inc';

            $query = "SELECT idItem, quantidade, unidadeMedida FROM receitaitem WHERE idReceita = '$idReceita' ";

            $resultado = mysqli_query($conexao, $query);
            $idItem = null;
            $quantidade = null;
            $unidadeMedida = null;
            if(mysqli_num_rows($resultado) > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $idItem[$i] = $row['idItem'];
                    $quantidade[$i] = $row['quantidade'];
                    $unidadeMedida[$i] = $row['unidadeMedida'];
                    $i++;
                }
            }
            mysqli_close($conexao);

            return array ($idItem, $quantidade, $unidadeMedida);
        }

        public function cadastrarReceita_Item(){
            include '../includes/conecta_bd.inc';

            $query = "INSERT INTO receitaitem (idReceita, idItem, quantidade, unidadeMedida) 
            VALUES ('$this->idReceita', '$this->idItem', '$this->quantidade', '$this->unidadeMedida')";
        
            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }
        
        public function editarReceita_Item(){
            include '../includes/conecta_bd.inc';

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
            include '../includes/conecta_bd.inc';

            $query = "DELETE FROM receitaitem WHERE  idItem = '$this->idItem' AND idReceita = '$this->idReceita'";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }
        
        public function apagarReceita_Item($idReceita){
            include '../includes/conecta_bd.inc';

            $query = "DELETE FROM receitaitem WHERE idReceita = '$idReceita' ";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }
        
        
        public static function converterMedidas($unimedPrinc, $unimedSec, $quantidadeSec, $itemNome){
        /*  print_r($unimedPrinc).'<br>';
        print_r($unimedSec).'<br>';
        print_r($quantidadeSec).'<br>';
         print_r($itemNome).'<br>';*/
            
            switch ($unimedPrinc) {
                  case 'ml':
                    
                        switch ($unimedSec) {
                              case 'gramas':
                               
                                   $novaQuantidade = $quantidadeSec;
                                
                              break;

                              case 'colher_de_sopa':
                                
                                    $novaQuantidade = $quantidadeSec * 15;
                                
                              break;

                              case 'colher_de_cha':
                                
                                    $novaQuantidade = $quantidadeSec * 5;
                                
                              break;

                              case 'colher_de_cafe':
                                
                                    $novaQuantidade = $quantidadeSec * 2;
                                
                              break;

                              case 'xicara':
                                
                                    $novaQuantidade = $quantidadeSec * 240;
                                
                              break;

                              case 'litro(s)':
                               
                                   $novaQuantidade = $quantidadeSec * 1000;
                                
                              break;

                              case 'quilo':
                                
                                    $novaQuantidade = $quantidadeSec * 1000;
                                
                              break;    
                        }
                    
                  break;
                    
                  case 'gramas':
                   
                         switch ($unimedSec) {
                              case 'ml':
                               
                                   $novaQuantidade = $quantidadeSec;
                                
                              break;

                              case 'colher_de_sopa':
                                
                                    $novaQuantidade = $quantidadeSec * 14;
                                
                              break;

                              case 'colher_de_chá':
                                
                                    $novaQuantidade = $quantidadeSec * 4;
                                
                              break;

                              case 'colher_de_café':
                                
                                    $novaQuantidade = $quantidadeSec * 1.5;
                                
                              break;

                              case 'xicara':
                                
                                    $novaQuantidade = $quantidadeSec * 165;
                                
                              break;

                              case 'litro(s)':
                               
                                   $novaQuantidade = $quantidadeSec * 1000;
                                
                              break;

                              case 'quilo':
                                
                                    $novaQuantidade = $quantidadeSec * 1000;
                                
                              break;    
                        }     
                    
                  break;
                    
                  case 'colher_de_sopa':
                    
                        switch ($unimedSec) {
                              case 'ml':
                               
                                   $novaQuantidade = $quantidadeSec / 15;
                                
                              break;

                              case 'gramas':
                                
                                    $novaQuantidade = $quantidadeSec / 14;
                                
                              break;

                              case 'colher_de_cha':
                                
                                    $novaQuantidade = $quantidadeSec / 3;
                                
                              break;

                              case 'colher_de_cafe':
                                
                                    $novaQuantidade = $quantidadeSec / 9;
                                
                              break;

                              case 'xicara':
                                
                                    $novaQuantidade = $quantidadeSec * 16;
                                
                              break;

                              case 'litro(s)':
                               
                                   $novaQuantidade = ($quantidadeSec /15) * 1000;
                                
                              break;

                              case 'quilo':
                                
                                    $novaQuantidade = ($quantidadeSec /14) * 1000;
                                
                              break;    
                        }  
                    
                  break;
                    
                  case 'colher_de_cha':
                    
                         switch ($unimedSec) {
                              case 'ml':
                               
                                   $novaQuantidade = $quantidadeSec / 5;
                                
                              break;

                              case 'gramas':
                                
                                    $novaQuantidade = $quantidadeSec / 4;
                                
                              break;

                              case 'colher_de_sopa':
                                
                                    $novaQuantidade = $quantidadeSec * 3;
                                
                              break;

                              case 'colher_de_cafe':
                                
                                    $novaQuantidade = $quantidadeSec / 3;
                                
                              break;

                              case 'xicara':
                                
                                    $novaQuantidade = $quantidadeSec * 48;
                                
                              break;

                              case 'litro(s)':
                               
                                   $novaQuantidade = ($quantidadeSec /5) * 1000;
                                
                              break;

                              case 'quilo':
                                
                                    $novaQuantidade = ($quantidadeSec /4) * 1000;
                                
                              break;    
                        }  
                    
                  break;
                    
                  case 'colher_de_cafe':
                    
                         switch ($unimedSec) {
                              case 'ml':
                               
                                   $novaQuantidade = $quantidadeSec / 2;
                                
                              break;

                              case 'gramas':
                                
                                    $novaQuantidade = $quantidadeSec / 1.5;
                                
                              break;

                              case 'colher_de_sopa':
                                
                                    $novaQuantidade = $quantidadeSec * 9;
                                
                              break;

                              case 'colher_de_cha':
                                
                                    $novaQuantidade = $quantidadeSec * 3;
                                
                              break;

                              case 'xicara':
                                
                                    $novaQuantidade = $quantidadeSec * 144;
                                
                              break;

                              case 'litro(s)':
                               
                                   $novaQuantidade = ($quantidadeSec /2) * 1000;
                                
                              break;

                              case 'quilo':
                                
                                    $novaQuantidade = ($quantidadeSec /1.5) * 1000;
                                
                              break;    
                        }  
                    
                  break;
                    
                  case 'xicara':
                    
                        switch ($unimedSec) {
                              case 'ml':
                               
                                   $novaQuantidade = $quantidadeSec / 240;
                                
                              break;

                              case 'gramas':
                                
                                    $novaQuantidade = $quantidadeSec / 165;
                                
                              break;

                              case 'colher_de_sopa':
                                
                                    $novaQuantidade = $quantidadeSec / 16;
                                
                              break;

                              case 'colher_de_cha':
                                
                                    $novaQuantidade = $quantidadeSec / 48;
                                
                              break;

                              case 'colher_de_cafe':
                                
                                    $novaQuantidade = $quantidadeSec / 144;
                                
                              break;

                              case 'litro(s)':
                               
                                   $novaQuantidade = ($quantidadeSec /240) * 1000;
                                
                              break;

                              case 'quilo':
                                
                                    $novaQuantidade = ($quantidadeSec /165) * 1000;
                                
                              break;    
                        }     
                    
                  break;
                    
                  case 'litro(s)':
                   
                      switch ($unimedSec) {
                              
                              case 'ml':
                               
                                   $novaQuantidade = $quantidadeSec / 1000;
                                
                              break;
                              
                              case 'gramas':
                               
                                   $novaQuantidade = $quantidadeSec / 1000;
                                
                              break;

                              case 'colher_de_sopa':
                                
                                    $novaQuantidade = ($quantidadeSec * 15) / 1000;
                                
                              break;

                              case 'colher_de_cha':
                                
                                    $novaQuantidade = ($quantidadeSec * 5) / 1000;
                                
                              break;

                              case 'colher_de_cafe':
                                
                                    $novaQuantidade = ($quantidadeSec * 2) / 1000 ; 
                                
                              break;

                              case 'xicara':
                                
                                    $novaQuantidade = ($quantidadeSec * 240) / 1000 ;
                                
                              break;
                  
                              case 'quilo':
                                
                                    $novaQuantidade = $quantidadeSec;
                                
                              break;    
                        }
                    
                  break;
                    
                  case 'quilo':
                    
                        switch ($unimedSec) {
                              
                              case 'ml':
                               
                                   $novaQuantidade = $quantidadeSec / 1000;
                                
                              break;
                              
                              case 'gramas':
                               
                                   $novaQuantidade = $quantidadeSec / 1000;
                                
                              break;

                              case 'colher_de_sopa':
                                
                                    $novaQuantidade = ($quantidadeSec * 14) / 1000;
                                
                              break;

                              case 'colher_de_cha':
                                
                                    $novaQuantidade = ($quantidadeSec * 4) / 1000;
                                
                              break;

                              case 'colher_de_cafe':
                                
                                    $novaQuantidade = ($quantidadeSec * 1.5) / 1000 ; 
                                
                              break;

                              case 'xicara':
                                
                                    $novaQuantidade = ($quantidadeSec * 165) / 1000 ;
                                
                              break;
                  
                              case 'litro(s)':
                                
                                    $novaQuantidade = $quantidadeSec;
                                
                              break;    
                        }
                    
                  break;
                  return $novaQuantidade;
                       
                        
            }
                
      
        }
    }
?>
