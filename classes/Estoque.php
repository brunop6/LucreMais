<?php
    class Estoque{
        private $idUsuario;
        private $idFornecedor;
        private $idItem;
        private $quantidade;
        private $preco;
        private $lote;
        private $validade;
        private $statusItem;

        function __construct($idUsuario, $idFornecedor, $idItem, $quantidade, $preco, $lote, $validade, $statusItem)
        {
            $this->idUsuario = $idUsuario;
            $this->idFornecedor = $idFornecedor;
            $this->idItem = $idItem;
            $this->quantidade = $quantidade;
            $this->preco = $preco;
            $this->lote = $lote;
            $this->validade = $validade;
            $this->statusItem = $statusItem;
        }

        public static function retornar_itens_em_falta(){
            include '../../includes/conecta_bd.inc';

            $query = "SELECT i.nome, i.marca 
            FROM item i, estoque e 
            WHERE i.id = e.idItem 
                AND e.quantidade < i.quantidadeMinima
                AND e.statusItem = '1' 
            ORDER BY e.lote, i.nome, i.marca";

            $resultado = mysqli_query($conexao, $query);

            $nomeItem = null;
            if(mysqli_num_rows($resultado) > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $nomeItem[$i] = $row['nome']." ".$row['marca'];
                    $i++; 
                }
                return $nomeItem;
            }
        }

        /**
         * Valores de $status: 
         * '1' -> itens ativos no sistema
         * '0' -> itens desativados
         */
        public static function retornar_itens_estoque($status){
            include '../includes/conecta_bd.inc';

            $query = "SELECT e.id, i.nome, i.marca, c.descricaoCategoria, f.nomeFornecedor, e.quantidade AS quantidadeEstoque, i.unidadeMedida, e.preco, i.quantidade AS quantidadeItem, e.lote, DATE_FORMAT(e.validade, '%d/%m/%Y') AS validade, DATE_FORMAT(e.dataCadastro, '%d/%m/%Y %H:%i') AS dataCadastro, DATE_FORMAT(e.dataAtualizacao, '%d/%m/%Y %H:%i') AS dataAtualizacao, u.nomeUsuario 
            FROM item i, usuario u, categoria c, estoque e, fornecedor f
            WHERE i.idUsuario = u.id 
                AND i.idCategoria = c.id 
                AND i.id = e.idItem 
                AND e.idFornecedor = f.id
                AND e.statusItem = '$status'
            ORDER BY i.nome, i.marca, e.lote";
               
            $resultado = mysqli_query($conexao, $query);
            $linhas = mysqli_num_rows($resultado);

            if($linhas > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $id[$i] = $row['id'];
                    $nome[$i] = $row['nome'];
                    $marca[$i] = $row['marca'];
                    $categoria[$i] = $row['descricaoCategoria'];
                    $fornecedor[$i] = $row['nomeFornecedor'];
                    $quantidadeEstoque[$i] = $row['quantidadeEstoque'];
                    $unidadeMedida[$i] = $row['unidadeMedida'];
                    $preco[$i] = number_format($row['preco'], 2);
                    $quantidadeItem[$i] = $row['quantidadeItem'];
                    $lote[$i] = $row['lote'];
                    $validade[$i] = $row['validade'];
                    $dataCadastro[$i] = $row['dataCadastro'];
                    $dataAtualizacao[$i] = $row['dataAtualizacao'];
                    $nomeUsuario[$i] = $row['nomeUsuario'];
                    $i++; 
                }
                return array($id, $nome, $marca, $categoria, $fornecedor, $quantidadeEstoque, $unidadeMedida, $preco, $quantidadeItem, $lote, $validade, $dataCadastro, $dataAtualizacao, $nomeUsuario);
            }
            return null;
        }

        public static function selectEstoque($id){
            include '../includes/conecta_bd.inc';

            $query = "SELECT i.nome, i.marca, i.unidadeMedida, f.nomeFornecedor, e.quantidade AS quantidadeEstoque, e.preco, e.lote, e.validade, e.statusItem
            FROM item i, estoque e, fornecedor f
            WHERE i.id = e.idItem 
                AND e.idFornecedor = f.id
                AND e.id = $id
            ";

            $resultado = mysqli_query($conexao, $query);

            if(mysqli_num_rows($resultado) > 0){
                while($row = mysqli_fetch_array($resultado)){
                    $nome = $row['nome'];
                    $marca = $row['marca'];
                    $unidadeMedida = $row['unidadeMedida'];
                    $fornecedor = $row['nomeFornecedor'];
                    $quantidade = $row['quantidadeEstoque'];
                    $preco = number_format($row['preco'], 2);
                    $lote = $row['lote'];
                    $validade = $row['validade'];
                    $statusItem = $row['statusItem'];
                }
            }

            mysqli_close($conexao);

            return array($nome, $marca, $unidadeMedida, $fornecedor, $quantidade, $preco, $lote, $validade, $statusItem);
        }

        public static function gerar_lista_compras(){
            header('Location: ../listaCompras/lista_compras_pdf.php');
        }

        public function cadastrar_estoque(){
            include '../includes/conecta_bd.inc';

            $query = "INSERT INTO estoque (idUsuario, idFornecedor, idItem, quantidade, preco, lote, validade, statusItem) VALUES ($this->idUsuario, $this->idFornecedor, $this->idItem, $this->quantidade, $this->preco, $this->lote, '$this->validade', '$this->statusItem')";
        
            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return 'Cadastro realizado com sucesso!';
            }
            return mysqli_error($conexao);
        }

        public function editar_estoque($id, $tipo){
            include '../includes/conecta_bd.inc';

            $query = "UPDATE estoque SET idUsuario = $this->idUsuario, idFornecedor = $this->idFornecedor, idItem = $this->idItem, preco = $this->preco, lote = $this->lote, validade = '$this->validade', statusItem = '$this->statusItem' WHERE id = $id";

            $resultado = mysqli_query($conexao, $query);

            if(!$resultado){
                return mysqli_error($conexao);
            }

            if($tipo != null){
                $query = "CALL atualizaEstoque($id, $this->idUsuario, $this->quantidade, 'Edição', '$tipo')";

                $resultado = mysqli_query($conexao, $query);
            }
            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }
        public static function selectEntradaEstoque($email){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "SELECT e.id, i.nome, i.marca, c.descricaoCategoria, ent.quantidade, i.unidadeMedida, e.preco, ent.observacao, DATE_FORMAT(ent.dataAtualizacao, '%d/%m/%Y %H:%i') AS dataAtualizacao, u.nomeUsuario
            FROM estoque e, item i, entradaestoque ent, usuario u, categoria c
            WHERE ent.idEstoque = e.id
                AND e.idItem = i.id
                AND ent.idUsuario = u.id
                AND i.idCategoria = c.id
                AND e.idItem = i.id
                AND u.email = '$email'
            ORDER BY ent.id DESC
            LIMIT 10";

            $resultado = mysqli_query($conexao, $query);

            if(mysqli_num_rows($resultado) > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $id[$i] = $row['id'];
                    $item[$i] = $row['nome'].' '.$row['marca'];
                    $categoria[$i] = $row['descricaoCategoria'];
                    $quantidade[$i] = $row['quantidade'];
                    $unidadeMedida[$i] = $row['unidadeMedida'];
                    $preco[$i] = $row['preco'];
                    $observacao[$i] = $row['observacao'];
                    $data[$i] = $row['dataAtualizacao'];
                    $nome[$i] = $row['nomeUsuario'];
                    $i++;
                }
            }
            mysqli_close($conexao);
            return array($id, $item, $categoria, $quantidade, $unidadeMedida, $preco, $observacao, $data, $nome);
        }
        public static function selectBaixaEstoque($email){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "SELECT e.id, i.nome, i.marca, c.descricaoCategoria, b.quantidade, i.unidadeMedida, e.preco, b.observacao, DATE_FORMAT(b.dataAtualizacao, '%d/%m/%Y %H:%i') AS dataAtualizacao, u.nomeUsuario
            FROM estoque e, item i, baixaestoque b, usuario u, categoria c
            WHERE b.idEstoque = e.id
                AND e.idItem = i.id
                AND b.idUsuario = u.id
                AND i.idCategoria = c.id
                AND e.idItem = i.id
                AND u.email = '$email'
            ORDER BY b.id DESC
            LIMIT 10";

            $resultado = mysqli_query($conexao, $query);

            if(mysqli_num_rows($resultado) > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $id[$i] = $row['id'];
                    $item[$i] = $row['nome'].' '.$row['marca'];
                    $categoria[$i] = $row['descricaoCategoria'];
                    $quantidade[$i] = $row['quantidade'];
                    $unidadeMedida[$i] = $row['unidadeMedida'];
                    $preco[$i] = $row['preco'];
                    $observacao[$i] = $row['observacao'];
                    $data[$i] = $row['dataAtualizacao'];
                    $nome[$i] = $row['nomeUsuario'];
                    $i++;
                }
            }
            mysqli_close($conexao);
            return array($id, $item, $categoria, $quantidade, $unidadeMedida, $preco, $observacao, $data, $nome);
        }
    }