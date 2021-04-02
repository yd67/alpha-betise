// const allStars = document.querySelectorAll('.fa-star');

// init();
// function init(){
//     allStars.forEach((star) => {
//         star.addEventListener("click",getRating);
//         star.addEventListener("mouseover",ajoutCouleur);
//         star.addEventListener("mouseleave",removeCouleur);
//     })
// }
// function getRating(e){

// }
// function ajoutCouleur(e, css="checked"){
//     e.target.classList.add(css);
// }
// function removeCouleur(e, css="checked"){
//     e.target.classList.remove(css);
// }
// function getPreviousiblings(elem){
//     let siblings = [];
//     const span 
// }

    // recuperations  des etoiles
    const stars = document.querySelectorAll('.fa-star');
    const note = document.getElementById('note');
window.onload = () => {

    //  boucle sur les etoiles 
    for(star of stars ){
        star.addEventListener("mouseover",function(){
            resetStars();
            this.style.color = "orange";
            
            // element precedant dans le dom 
            let previousStar = this.previousElementSibling;

            while(previousStar){
                previousStar.style.color = "orange";
                previousStar = previousStar.previousElementSibling;
            }
            
        });
        // recuperation de la valeur au click 
        star.addEventListener('click',function(){

            note.value = this.dataset.star ;
        });
        star.addEventListener("mouseout", function(){
            resetStars(note.value);
        })
    }  

    function resetStars( note = 0){
        for(star of stars){

            if(star.dataset.star > note){
                star.style.color = "black";
            }
            else{
                star.style.color = "orange";
            }
            
        }

}

}

