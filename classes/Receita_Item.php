<?php
    class Receita_Item{
        private $idReceita;
        private $idItem;
        private $quantidade;
        private $unidadeMedida;
        

        function __construct($idReceita, $idItem, $quantidade, $unidadeMedida)
        {
            $this->idReceita = $idReceita;
            $this->idItem = $idItem;
            $this->quantidade = $quantidade;
            $this->unidadeMedida = $unidadeMedida;
        }

        public static function selectReceita_Itens($idReceita){
            include '../includes/conecta_bd.inc';

            $query = "SELECT idItem, quantidade, unidadeMedida FROM receita_item WHERE idReceita = '$idReceita' ";

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

            $query = "INSERT INTO receita_item (idReceita, idItem, quantidade, unidadeMedida) VALUES ('$this->idReceita', '$this->idItem', '$this->quantidade', $this->unidadeMedida)";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }
        
        public function editarReceita_Item(){
            include '../includes/conecta_bd.inc';

            $query = "UPDATE receita_item  
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

            $query = "DELETE FROM receita_item WHERE  idItem = '$this->idItem' AND idReceita = '$this->idReceita'";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }
        
        public function apagarReceita_Item($idReceita){
            include '../includes/conecta_bd.inc';

            $query = "DELETE FROM receita_item WHERE idReceita = '$idReceita' ";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }
        
        
        public static function converterMedidas($unimedPrinc, $unimedSec, $quantidadeSec, $itemNome){
            
            switch ($unimedPrinc) {
                  case 'ml':
                    {
                        switch ($unimedSec) {
                              case 'grama':
                               {
                                   $novaQuantidade = $quantidadeSec;
                                }
                              break;

                              case 'colher de sopa':
                                {
                                    $novaQuantidade = $quantidadeSec * 15;
                                }
                              break;

                              case 'colher de chá':
                                {
                                    $novaQuantidade = $quantidadeSec * 5;
                                }
                              break;

                              case 'colher de café':
                                {
                                    $novaQuantidade = $quantidadeSec * 2;
                                }
                              break;

                              case 'xícara':
                                {
                                    $novaQuantidade = $quantidadeSec * 240;
                                }
                              break;

                              case 'litro':
                               {
                                   $novaQuantidade = $quantidadeSec * 1000;
                                }
                              break;

                              case 'quilo':
                                {
                                    $novaQuantidade = $quantidadeSec * 1000;
                                }
                              break;    
                        }
                    }
                  break;
                    
                  case 'grama':
                   {
                         switch ($unimedSec) {
                              case 'ml':
                               {
                                   $novaQuantidade = $quantidadeSec;
                                }
                              break;

                              case 'colher de sopa':
                                {
                                    $novaQuantidade = $quantidadeSec * 14;
                                }
                              break;

                              case 'colher de chá':
                                {
                                    $novaQuantidade = $quantidadeSec * 4;
                                }
                              break;

                              case 'colher de café':
                                {
                                    $novaQuantidade = $quantidadeSec * 1.5;
                                }
                              break;

                              case 'xícara':
                                {
                                    $novaQuantidade = $quantidadeSec * 165;
                                }
                              break;

                              case 'litro':
                               {
                                   $novaQuantidade = $quantidadeSec * 1000;
                                }
                              break;

                              case 'quilo':
                                {
                                    $novaQuantidade = $quantidadeSec * 1000;
                                }
                              break;    
                        }     
                    }
                  break;
                    
                  case 'colher de sopa':
                    {
                        switch ($unimedSec) {
                              case 'ml':
                               {
                                   $novaQuantidade = $quantidadeSec / 15;
                                }
                              break;

                              case 'grama':
                                {
                                    $novaQuantidade = $quantidadeSec / 14;
                                }
                              break;

                              case 'colher de chá':
                                {
                                    $novaQuantidade = $quantidadeSec / 3;
                                }
                              break;

                              case 'colher de café':
                                {
                                    $novaQuantidade = $quantidadeSec / 9;
                                }
                              break;

                              case 'xícara':
                                {
                                    $novaQuantidade = $quantidadeSec * 16;
                                }
                              break;

                              case 'litro':
                               {
                                   $novaQuantidade = ($quantidadeSec /15) * 1000;
                                }
                              break;

                              case 'quilo':
                                {
                                    $novaQuantidade = ($quantidadeSec /14) * 1000;
                                }
                              break;    
                        }  
                    }
                  break;
                    
                  case 'colher de chá':
                    {
                         switch ($unimedSec) {
                              case 'ml':
                               {
                                   $novaQuantidade = $quantidadeSec / 5;
                                }
                              break;

                              case 'grama':
                                {
                                    $novaQuantidade = $quantidadeSec / 4;
                                }
                              break;

                              case 'colher de sopa':
                                {
                                    $novaQuantidade = $quantidadeSec * 3;
                                }
                              break;

                              case 'colher de café':
                                {
                                    $novaQuantidade = $quantidadeSec / 3;
                                }
                              break;

                              case 'xícara':
                                {
                                    $novaQuantidade = $quantidadeSec * 48;
                                }
                              break;

                              case 'litro':
                               {
                                   $novaQuantidade = ($quantidadeSec /5) * 1000;
                                }
                              break;

                              case 'quilo':
                                {
                                    $novaQuantidade = ($quantidadeSec /4) * 1000;
                                }
                              break;    
                        }  
                    }
                  break;
                    
                  case 'colher de café':
                    {
                         switch ($unimedSec) {
                              case 'ml':
                               {
                                   $novaQuantidade = $quantidadeSec / 2;
                                }
                              break;

                              case 'grama':
                                {
                                    $novaQuantidade = $quantidadeSec / 1.5;
                                }
                              break;

                              case 'colher de sopa':
                                {
                                    $novaQuantidade = $quantidadeSec * 9;
                                }
                              break;

                              case 'colher de chá':
                                {
                                    $novaQuantidade = $quantidadeSec * 3;
                                }
                              break;

                              case 'xícara':
                                {
                                    $novaQuantidade = $quantidadeSec * 144;
                                }
                              break;

                              case 'litro':
                               {
                                   $novaQuantidade = ($quantidadeSec /2) * 1000;
                                }
                              break;

                              case 'quilo':
                                {
                                    $novaQuantidade = ($quantidadeSec /1.5) * 1000;
                                }
                              break;    
                        }  
                    }
                  break;
                    
                  case 'xícara':
                    {
                        switch ($unimedSec) {
                              case 'ml':
                               {
                                   $novaQuantidade = $quantidadeSec / 240;
                                }
                              break;

                              case 'grama':
                                {
                                    $novaQuantidade = $quantidadeSec / 165;
                                }
                              break;

                              case 'colher de sopa':
                                {
                                    $novaQuantidade = $quantidadeSec / 16;
                                }
                              break;

                              case 'colher de chá':
                                {
                                    $novaQuantidade = $quantidadeSec / 48;
                                }
                              break;

                              case 'colher de café':
                                {
                                    $novaQuantidade = $quantidadeSec / 144;
                                }
                              break;

                              case 'litro':
                               {
                                   $novaQuantidade = ($quantidadeSec /240) * 1000;
                                }
                              break;

                              case 'quilo':
                                {
                                    $novaQuantidade = ($quantidadeSec /165) * 1000;
                                }
                              break;    
                        }     
                    }
                  break;
                    
                  case 'litro':
                   {
                      switch ($unimedSec) {
                              
                              case 'ml':
                               {
                                   $novaQuantidade = $quantidadeSec / 1000;
                                }
                              break;
                              
                              case 'grama':
                               {
                                   $novaQuantidade = $quantidadeSec / 1000;
                                }
                              break;

                              case 'colher de sopa':
                                {
                                    $novaQuantidade = ($quantidadeSec * 15) / 1000;
                                }
                              break;

                              case 'colher de chá':
                                {
                                    $novaQuantidade = ($quantidadeSec * 5) / 1000;
                                }
                              break;

                              case 'colher de café':
                                {
                                    $novaQuantidade = ($quantidadeSec * 2) / 1000 ; 
                                }
                              break;

                              case 'xícara':
                                {
                                    $novaQuantidade = ($quantidadeSec * 240) / 1000 ;
                                }
                              break;
                  
                              case 'quilo':
                                {
                                    $novaQuantidade = $quantidadeSec;
                                }
                              break;    
                        }
                    }
                  break;
                    
                  case 'quilo':
                    {
                        switch ($unimedSec) {
                              
                              case 'ml':
                               {
                                   $novaQuantidade = $quantidadeSec / 1000;
                                }
                              break;
                              
                              case 'grama':
                               {
                                   $novaQuantidade = $quantidadeSec / 1000;
                                }
                              break;

                              case 'colher de sopa':
                                {
                                    $novaQuantidade = ($quantidadeSec * 14) / 1000;
                                }
                              break;

                              case 'colher de chá':
                                {
                                    $novaQuantidade = ($quantidadeSec * 4) / 1000;
                                }
                              break;

                              case 'colher de café':
                                {
                                    $novaQuantidade = ($quantidadeSec * 1.5) / 1000 ; 
                                }
                              break;

                              case 'xícara':
                                {
                                    $novaQuantidade = ($quantidadeSec * 165) / 1000 ;
                                }
                              break;
                  
                              case 'litro':
                                {
                                    $novaQuantidade = $quantidadeSec;
                                }
                              break;    
                        }
                    }
                  break;
            }
                
            return $novaQuantidade;
        }
    }
?>
