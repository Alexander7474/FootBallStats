// JavaScript code
function search_joueur() {
    let input = document.getElementById('searchbar').value
    if(input =='yobama'){
        console.log('ok');
    }
    input=input.toLowerCase();
    let x = document.getElementsByClassName('search');
    
    for (i = 0; i < x.length; i++) { 
        if (!x[i].innerHTML.toLowerCase().includes(input)) {
            x[i].style.display="none";
        }
        else {
            x[i].style.display="list-item";          
        }
    }
}