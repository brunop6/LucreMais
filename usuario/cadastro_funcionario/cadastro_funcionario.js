let admin = document.getElementsByName('admin');

for(let i = 0; i < admin.length; i++){
    admin[i].addEventListener('change', function(){
        if(admin[i].value == 1){
            document.querySelector('#niveldeacesso').style.display = 'none';
        }else{
            document.querySelector('#niveldeacesso').style.display = 'block';
        }
    });
}