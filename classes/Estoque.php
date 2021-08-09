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

        public function cadastrar_estoque(){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "INSERT INTO estoque (idUsuario, idFornecedor, idItem, quantidade, preco, lote, validade, statusItem) VALUES ($this->idUsuario, $this->idFornecedor, $this->idItem, $this->quantidade, $this->preco, $this->lote, '$this->validade', '$this->statusItem')";
        
            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return 'Cadastro realizado com sucesso!';
            }
            return mysqli_error($conexao);
        }

        public function editar_estoque($id, $tipo){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "UPDATE estoque 
            SET idUsuario = $this->idUsuario, idFornecedor = $this->idFornecedor, idItem = $this->idItem, preco = $this->preco, lote = $this->lote, validade = '$this->validade', statusItem = '$this->statusItem' 
            WHERE id = $id";

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

        public static function registrarBaixa($id, $idUsuario, $quantidadeRec){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "UPDATE estoque
            SET idUsuario = $idUsuario
            WHERE id = $id";

            $resultado = mysqli_query($conexao, $query);

            if(!$resultado){
                return mysqli_error($conexao);
            }

            $query = "CALL atualizaEstoque($id, $idUsuario, $quantidadeRec, 'Receita', 'S')";

            $resultado = mysqli_query($conexao, $query);
            
            if(!$resultado){
                return mysqli_error($conexao);
            }
            mysqli_close($conexao);

            return true;
        }
        
        public static function retornar_itens_em_falta($email){
            include '../../includes/conecta_bd.inc';

            $query = "SELECT i.nome, i.marca, SUM(e.quantidade) as quantidade, i.quantidadeMinima
            FROM estoque e, item i, usuario u
            WHERE u.id = e.idUsuario
                AND u.id = i.idUsuario
                AND e.idItem = i.id
                AND u.email = '$email'
                AND e.statusItem = '1'
            GROUP BY i.id";

            $resultado = mysqli_query($conexao, $query);

            $nomeItem = null;
            if(mysqli_num_rows($resultado) > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    if($row['quantidade'] < $row['quantidadeMinima']){
                        $nomeItem[$i] = $row['nome']." ".$row['marca'];
                        $i++; 
                    }
                }
                return $nomeItem;
            }
        }

        /**
         * Valores de $status: 
         * '1' -> itens ativos no sistema
         * '0' -> itens desativados
         */
        public static function retornar_itens_estoque($status, $marcaFiltro, $nomeFiltro, $categoriaFiltro, $loteFiltro, $email){
            include '../includes/conecta_bd.inc';

            $query = "SELECT e.id, i.nome, i.marca, c.descricaoCategoria, f.nomeFornecedor, e.quantidade AS quantidadeEstoque, i.unidadeMedida, e.preco, i.quantidade AS quantidadeItem, e.lote, DATE_FORMAT(e.validade, '%d/%m/%Y') AS validade, DATE_FORMAT(e.dataCadastro, '%d/%m/%Y %H:%i') AS dataCadastro, DATE_FORMAT(e.dataAtualizacao, '%d/%m/%Y %H:%i') AS dataAtualizacao, u.nomeUsuario 
            FROM item i, usuario u, categoria c, estoque e, fornecedor f
            WHERE i.idUsuario = u.id 
                AND i.idCategoria = c.id 
                AND i.id = e.idItem 
                AND e.idFornecedor = f.id
                AND u.email = '$email'
                AND e.statusItem = '$status'";
             
             
            if ($marcaFiltro){
               $query = $query." AND i.marca LIKE '%$marcaFiltro%'";
            }
             
            if ($nomeFiltro){
               $query = $query." AND i.nome LIKE '%$nomeFiltro%'"; 
            }
             
            if ($categoriaFiltro){
               $query = $query." AND c.descricaoCategoria LIKE '%$categoriaFiltro%'";
            }
             
            if ($loteFiltro){
               $query = $query." AND e.lote = '$loteFiltro'";
            }            
             
            $query = $query." ORDER BY i.nome, i.marca, e.lote";
               
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
            include __DIR__.'./../includes/conecta_bd.inc';

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

            $id = null;
            $item = null;
            $categoria = null;
            $quantidade = null;
            $unidadeMedida = null;
            $preco = null;
            $observacao = null;
            $data = null;
            $nome = null;
            if(mysqli_num_rows($resultado) > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $id[$i] = $row['id'];
                    $item[$i] = $row['nome'].' '.$row['marca'];
                    $categoria[$i] = $row['descricaoCategoria'];
                    $quantidade[$i] = $row['quantidade'];
                    $unidadeMedida[$i] = $row['unidadeMedida'];
                    $preco[$i] = number_format($row['preco'], 2);
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
            $id = null;
            $item = null;
            $categoria = null;
            $quantidade = null;
            $unidadeMedida = null;
            $preco = null;
            $observacao = null;
            $data = null;
            $nome = null;
            if(mysqli_num_rows($resultado) > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $id[$i] = $row['id'];
                    $item[$i] = $row['nome'].' '.$row['marca'];
                    $categoria[$i] = $row['descricaoCategoria'];
                    $quantidade[$i] = $row['quantidade'];
                    $unidadeMedida[$i] = $row['unidadeMedida'];
                    $preco[$i] = number_format($row['preco'], 2);
                    $observacao[$i] = $row['observacao'];
                    $data[$i] = $row['dataAtualizacao'];
                    $nome[$i] = $row['nomeUsuario'];
                    $i++;
                }
            }
            mysqli_close($conexao);
            return array($id, $item, $categoria, $quantidade, $unidadeMedida, $preco, $observacao, $data, $nome);
        }

        public static function validarEstoque($id){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "SELECT quantidade, DATE_FORMAT(validade, '%Y/%m/%d') as validade
            FROM estoque 
            WHERE id = $id";

            $resultado = mysqli_query($conexao, $query);

            $quantidade = null;
            $validade = null;
            if(mysqli_num_rows($resultado) > 0){
                while($row = mysqli_fetch_array($resultado)){
                    $quantidade = $row['quantidade'];
                    $validade = $row['validade'];
                }

                if($validade < date('Y/m/d') || $quantidade == 0){
                    $query = "UPDATE estoque
                    SET statusItem = '0'
                    WHERE id = $id";

                    $resultado = mysqli_query($conexao, $query);

                    if(!$resultado){
                        return mysqli_error($conexao);
                    }
                }
            }
            mysqli_close($conexao);
            
            return true;
        }
    }