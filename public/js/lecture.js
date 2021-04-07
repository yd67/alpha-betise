    
     //*********************/ GESTIO DES ETOILES ****************************

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
              } else{
                star.style.color = "orange";
            } 
        }
}
}

// **************************** GESTION FILTRE AJAX **************************************

let linkFilter = document.querySelectorAll('.afilter');
 divfilter = document.querySelectorAll('.filter');

linkFilter.forEach( element => {
    element.addEventListener("click",function(e){
       e.preventDefault();
        let url = this.href;
        // console.log(url);
       fetch( url,{
        headers: {
            "X-Requested-with": "XMLHttpRequest"
        }
    }).then(
        // On récupère la réponse en JSON  
        response => 
            response.json()
        
    ).then(data => {
        let contenue = document.querySelector('#contenueFiltre');
        contenue.innerHTML = data.content ; 
        console.log(data.content);
    }).catch( e => alert(e));
   
    });
});
divfilter.forEach( element => {
    element.addEventListener("click",function(e){
         divfilter.forEach( m => m.classList.remove('active'));
         this.classList.add('active');
    });
});


//  let inputList = document.querySelectorAll("#formfilter input");

//  inputList.forEach( element => {
//       element.addEventListener("change",() => {
//         // list.forEach( m => m.classList.remove('active'));
//         // this.classList.add('active');
//         let form = new FormData(formfilter);
//         let params = new URLSearchParams();

//         form.forEach((key,value) => {
//             params.append(key,value)
//         })
//         let Url = new URL(window.location.href);

//         fetch(Url.pathname + "?" + params.toString() + "&ajax=1",{
//             headers: {
//                 "X-Requested-with": "XMLHttpRequest"
//             }
//         }).then(
//             // On récupère la réponse en JSON  
//             response =>  {
//                 response.json()
//             } 
//         )
//         .then(data => {
//             console.log(data);
//         }) .catch( e => alert(e));
        
//     });
//  });


 

//
 





 
