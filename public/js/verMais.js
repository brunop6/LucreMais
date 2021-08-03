function verMais(){
    if(mais[0].style.display === "none"){
        
        for(let i = 0; i < mais.length; i++){
            mais[i].style.display = "";
        }
    }else{
        for(let i = 0; i < mais.length; i++){
            mais[i].style.display = "none";
        }
    }
}

let mais = document.getElementsByClassName('mais');

for(let i = 0; i < mais.length; i++){
    mais[i].style.display = "none";
}