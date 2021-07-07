
// **************************** GESTION FILTRE AJAX **************************************

let linkFilter = document.querySelectorAll('.afilter');
 divfilter = document.querySelectorAll('.filter');
 afilter = document.querySelectorAll('.afilter');

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
afilter.forEach( element => {
    element.addEventListener("click",function(e){
        afilter.forEach( m => m.classList.remove('is-active'));
         this.classList.add('is-active');
    });
});




    //    fetch(url,{
    //     method: 'GET',
    //        headers: {
    //            "X-Reqested-with": "XMLHttpRequest"
    //        }
    //    })
    //    .then( Response => {
    //        console.log(Response);
    
    //    })
    //    .catch(alert('erreur est survenu'))
       
    // });