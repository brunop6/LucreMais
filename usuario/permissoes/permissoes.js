function desbloquearMenu(i){
    let email = document.getElementById("emailUsuario").innerHTML;
    let nivelAcesso = document.getElementById("nivel"+i).innerHTML;
    nivelAcesso = nivelAcesso.substring(0, nivelAcesso.length - 1);
    let inputNivelAlterado = document.getElementById('nivelAtual');
    inputNivelAlterado.name = "nivelAtual";
    inputNivelAlterado.hidden = true;
    inputNivelAlterado.value = nivelAcesso;

    $.ajax({
        url: '/LucreMais/public/ajax/selectMenusDisponiveis.php',
        method: 'POST',
        data: {
            nivelAcesso: nivelAcesso,
            email: email
        },
        dataType: 'json'
    }).done(function(result){
        let btnAdd = document.getElementById('btn-addMenu');
        let btnSalvar = document.getElementById('btn-salvar');
        let form = document.getElementById("form-permissoes");
        let select = document.createElement('select');
        let option = [];

        btnAdd.remove();
        btnSalvar.remove();
        select.name = "novoMenu";

        for(let i = 0; i < result['id'].length; i++){
            option[i] = document.createElement('option');
            option[i].text = result['descricao'][i];
            option[i].value = result['id'][i];

            console.log(result['descricao'][i]);
            select.appendChild(option[i]);
        }

        form.appendChild(select);
        form.appendChild(btnSalvar);
    });
}
function alterarExibicao() {
    let status = document.getElementById('status').value;
    let url = "?status=" + status;
    window.location.href = url;
}
