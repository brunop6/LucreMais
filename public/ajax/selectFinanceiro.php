<?php
    header('Content-Type: application/json');
    include_once './../../classes/ReceitaFinanceiro.php';
    include_once './../../classes/Despesa.php';

    $email = $_POST['email'];
    
    list($valorReceitas, $mesesReceitas) = ReceitaFinanceiro::selectUltimosMeses($email);
    list($custoDespesas, $mesesDespesas) = Despesa::selectUltimosMeses($email);
      
    $i = 0;
    foreach($valorReceitas as $value){
        $receitas[0][$i] = $value;
        $receitas[1][$i] = $mesesReceitas[$i];
        $i++;
    }
    $i = 0;
    foreach($custoDespesas as $value){
        $despesas[0][$i] = $value;
        $despesas[1][$i] = $mesesDespesas[$i];
        $i++;
    }
    echo json_encode(array($receitas, $despesas));
    