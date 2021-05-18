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

    /**
     * @todo: REWRITE WITH VUE-JS!
     */
    var collapseToggles = document.querySelectorAll('[data-meenta-toggle="collapse"]');
    if(collapseToggles.length){
      for(var i = 0; i < collapseToggles.length; i++){
        collapseToggles[i].addEventListener('click', function(e){
          e.preventDefault();
          var open = false;
          var toggle = this;
          var id = toggle.hash.slice(1);
          // switch the toggle
          this.classList.toggle('open');
          // store it
          open = this.classList.contains('open');
          // update the toggle's text and icon
          toggle.childNodes.forEach(n => {
            if(n.classList && n.classList.contains('the-text')){
              console.log(n);
              n.innerHTML = open ? 'Read Less' : 'Read More';
            } else if(n.classList && n.classList.contains('fas')){
              if(open) {
                n.classList.remove('fa-chevron-down')
                n.classList.add('fa-chevron-up')
              } else {
                n.classList.add('fa-chevron-down')
                n.classList.remove('fa-chevron-up')

              }
            }
          })
          document.getElementById(id).classList.toggle('open');
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