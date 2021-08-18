     //*********************/ GESTIO DES ETOILES ****************************

    const stars = document.querySelectorAll('.fa-star');
    const note = document.getElementById('note_note');
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
              } else{
                star.style.color = "orange";
            } 
        }       
}

}
/**************** GESTION FENETRE MODAL DE L'IMAGE  *********************/

 let modalImg = document.getElementById('modal-img');
 
    function modalOpen(){
        modalImg.classList.add('is-active');
    }
    
    function modalClose(){
    modalImg.classList.remove('is-active');
    }

// Rapel! le onclick se trouve dans le html





 





 
