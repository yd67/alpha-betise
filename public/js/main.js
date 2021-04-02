
// let req = new XMLHttpRequest();

// req.open("GET"," {{path('evenements')}} ",false)
// req.send();
// if(req.status == 200){
//     console.log(req);
//     console.log("ca fonction");
// }else{
//     console.log("erreur")
//}
// responsive nav-bar 
document.addEventListener('DOMContentLoaded', function () {

  // Get all "navbar-burger" elements
  var $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

  // Check if there are any navbar burgers
  if ($navbarBurgers.length > 0) {

    // Add a click event on each of them
    $navbarBurgers.forEach(function ($el) {
      $el.addEventListener('click', function () {

        // Get the target from the "data-target" attribute
        var target = $el.dataset.target;
        var $target = document.getElementById(target);

        // Toggle the class on both the "navbar-burger" and the "navbar-menu"
        $el.classList.toggle('is-active');
        $target.classList.toggle('is-active');

      });
    });
  }

});




// le carousel   

const swiper = new Swiper('.swiper-container', {
    // Optional parameters
   
    loop: true,
  
    // If we need pagination
    pagination: {
      el: '.swiper-pagination',
    },
  
    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  
    // And if we need scrollbar
    scrollbar: {
      el: '.swiper-scrollbar',
    },
  });
  

bulmaCarousel.attach('#carousel-demo', {
    slidesToScroll: 1,
    slidesToShow: 1,
    
    
});


// document.addEventListener('DOMContentLoaded', function() {
//     var calendarEl = document.getElementById('calendar');
//     var calendar = new FullCalendar.Calendar(calendarEl, {
//       initialView: 'dayGridMonth',
//       locale: 'fr',
//       timeZone: 'Europe/Paris',
//       headerToolBar: {

//         center: 'title',
        
//        },
//        buttonText:{
//         today: 'aujourd\'hui',
//         month: 'mois',
//         week: 'semaines',
//         day:  'jour',
//         list: 'liste'
//        }
//     });
//     calendar.render();
//   });