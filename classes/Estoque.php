<?php
    class Estoque{

        public function retornar_itens_em_falta(){
            include '../../includes/conecta_bd.inc';

            $query = "SELECT * FROM item WHERE quantidade < quantidadeMinima ORDER BY lote, nome";

            $resultado = mysqli_query($conexao, $query);
            $linhas = mysqli_num_rows($resultado);

            if($linhas > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $nomeItem[$i] = $row['nome'];
                    $i++; 
                }
                return $nomeItem;
            }
            else{
                return null;
            }
        }

        /**
         * Valores de $status: 
         * 'all' -> todos os itens
         * 'ativo' -> itens ativos no sistema
         * 'inativo' -> itens desativados
         */
        public function retornar_itens($status){
            include '../includes/conecta_bd.inc';

            $query = "SELECT * FROM item ORDER BY nome, lote";

            if($status != 'all'){
                $query = "SELECT * FROM item WHERE status = '$status' ORDER BY nome, lote";
            }      

            $resultado = mysqli_query($conexao, $query);
            $linhas = mysqli_num_rows($resultado);

            if($linhas > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $nome[$i] = $row['nome'];
                    $quantidade[$i] = $row['quantidade'];
                    $unidadeMedida[$i] = $row['unidadeMedida'];
                    $preco[$i] = $row['preco'];
                    $quantidadeMinima[$i] = $row['quantidadeMinima'];
                    $lote[$i] = $row['lote'];
                    $i++; 
                }
                return array($nome, $quantidade, $unidadeMedida, $preco, $quantidadeMinima, $lote) ;
            }
            else{
                return null;
            }
        }

        public function gerar_lista_compras(){
            header('Location: ../listaCompras/lista_compras_pdf.php');
        }
    }