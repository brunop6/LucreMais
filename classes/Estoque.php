<?php
    class Estoque{

        public function retornar_itens_em_falta(){
            include '../includes/conecta_bd.inc';

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

        public function gerar_lista_compras(){
            header('Location: ../listaCompras/lista_compras_pdf.php');
        }
    }