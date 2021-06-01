<?php
    class Estoque{
        private $idUsuario;
        private $idFornecedor;
        private $idItem;
        private $quantidade;
        private $preco;
        private $lote;
        private $statusItem;

        function __construct($idUsuario, $idFornecedor, $idItem, $quantidade, $preco, $lote, $statusItem)
        {
            $this->idUsuario = $idUsuario;
            $this->idFornecedor = $idFornecedor;
            $this->idItem = $idItem;
            $this->quantidade = $quantidade;
            $this->preco = $preco;
            $this->lote = $lote;
            $this->statusItem = $statusItem;
        }

        public static function retornar_itens_em_falta(){
            include '../../includes/conecta_bd.inc';

            $query = "SELECT i.nome, i.marca 
            FROM item i, estoque e 
            WHERE i.id = e.idItem 
                AND e.quantidade < i.quantidadeMinima 
            ORDER BY e.lote, i.nome, i.marca";

            $resultado = mysqli_query($conexao, $query);
            $linhas = mysqli_num_rows($resultado);

            if($linhas > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $nomeItem[$i] = $row['nome']." ".$row['marca'];
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
         * '1' -> itens ativos no sistema
         * '0' -> itens desativados
         */
        public static function retornar_itens_estoque($status){
            include '../includes/conecta_bd.inc';

            $query = "SELECT i.nome, i.marca, c.descricaoCategoria, f.nomeFornecedor, e.quantidade AS quantidadeEstoque, i.unidadeMedida, e.preco, i.quantidade AS quantidadeItem, DATE_FORMAT(e.dataCadastro, '%d/%m/%Y %H:%i') AS dataCadastro, DATE_FORMAT(e.dataAtualizacao, '%d/%m/%Y %H:%i') AS dataAtualizacao, u.nomeUsuario 
            FROM item i, usuario u, categoria c, estoque e, fornecedor f
            WHERE i.idUsuario = u.id 
                AND i.idCategoria = c.id 
                AND i.id = e.idItem 
                AND e.idFornecedor = f.id
                AND e.statusItem = '$status'
            ORDER BY i.nome, i.marca";
               
            $resultado = mysqli_query($conexao, $query);
            $linhas = mysqli_num_rows($resultado);

            if($linhas > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $nome[$i] = $row['nome'];
                    $marca[$i] = $row['marca'];
                    $categoria[$i] = $row['descricaoCategoria'];
                    $fornecedor[$i] = $row['nomeForncecedor'];
                    $quantidadeEstoque[$i] = $row['quantidadeEstoque'];
                    $unidadeMedida[$i] = $row['unidadeMedida'];
                    $preco[$i] = $row['preco'];
                    $quantidadeItem[$i] = $row['quantidadeItem'];
                    $lote[$i] = $row['lote'];
                    $dataCadastro[$i] = $row['dataCadastro'];
                    $dataAtualizacao[$i] = $row['dataAtualizacao'];
                    $nomeUsuario[$i] = $row['nomeUsuario'];
                    $i++; 
                }
                return array($nome, $marca, $categoria, $fornecedor, $quantidadeEstoque, $unidadeMedida, $preco, $quantidadeItem, $lote, $dataCadastro, $dataAtualizacao, $nomeUsuario);
            }
            return null;
        }

        public static function gerar_lista_compras(){
            header('Location: ../listaCompras/lista_compras_pdf.php');
        }

        public function cadastrar_estoque(){
            include '../includes/conecta_bd.inc';

            $query = "INSERT INTO estoque (idUsuario, idFornecedor, idItem, quantidade, preco, lote, statusItem) VALUES ($this->idUsuario, $this->idFornecedor, $this->idItem, $this->quantidade, $this->preco, $this->lote, '$this->statusItem')";
        
            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return 'Cadastro realizado com sucesso!';
            }
            return mysqli_error($conexao);
        }
    }