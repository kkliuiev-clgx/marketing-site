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

/**
 * Jquery zone..avoiding this wherever possible......
 */
jQuery(document).ready(function($){
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
})