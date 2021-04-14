(function(){

  document.addEventListener("DOMContentLoaded", function() {
    var chatTriggers = document.querySelectorAll('.meenta-chat-trigger');
    console.log(chatTriggers);
    if(chatTriggers.length){
      // browser support <3
      for(var i = 0; i < chatTriggers.length; i++){
        chatTriggers[i].addEventListener('click', function(){
          window.fcWidget.open();
          window.fcWidget.show();
        });
      }
    }
  });
  
  
}())


// jQuery(document).ready(function($){
//   $('.meenta-chat-trigger').on('click', function(e){
//     e.preventDefault();
//     window.fcWidget.open();
//     window.fcWidget.show();
//   })
// })