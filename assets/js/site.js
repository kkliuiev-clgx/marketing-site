var headerSearchTerm = '';
(function(){


  document.addEventListener("DOMContentLoaded", function() {
    var chatTriggers = document.querySelectorAll('.meenta-chat-trigger');
    if(chatTriggers.length){
      // browser support <3
      for(var i = 0; i < chatTriggers.length; i++){
        chatTriggers[i].addEventListener('click', function(e){
          e.preventDefault();
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

    /**
     * When the search input in the header changes, update the search term variable
     */
    var headerSearchInput = document.querySelector('.main-header .search-form-wrapper .lorada-search-form .searchform-inner input[type="text"]');
    headerSearchInput.addEventListener('change', function(evt){
      console.log('search change', this.value);
      window.dataLayer.push({headerSearchTerm: this.value});
      headerSearchTerm = this.value;
    })
    
  });
  
  
}())

/**
 * Jquery zone..avoiding this wherever possible......
 */
jQuery(document).ready(function($){

  // function checkShippingOptions(e){
  //   console.log('checkShippingOptions');
  //   setTimeout(function(){
  //     var freeShippingRadioOption = $('input[name^="shipping_method"][value^="free_shipping');
  //     if(freeShippingRadioOption.length && !freeShippingRadioOption.prop('checked')) {
  //       console.log('option exists', freeShippingRadioOption.prop('checked'));
  //       freeShippingRadioOption.prop('checked', true).trigger('change')
  //       disableUpdateCartHandlers() // prevent never-ending loop
  //     }
  //   }, 1000)
  // }


  // /**
  //  * Enable event listeners for the cart and checkout pages. These are what we are using to detect when we need to trigger manual selection of the "Free Shipping" option
  //  */
  // function enableUpdateCartHandlers(){
  //   console.log('enabling cart handler');
  //   $('body').on('updated_cart_totals', checkShippingOptions)
  //   $('body').on('updated_checkout', checkShippingOptions)
  //   $(document).on('change', 'ul#shipping_method input[name^="shipping_method"]', disableUpdateCartHandlers)
  // }

  // /**
  //  * Disable event listeners for cart and checkout pages. Otherwise, this will turn into a never-ending loop
  //  */
  // function disableUpdateCartHandlers(){
  //   console.log('disabling cart handler');
  //   $('body').off('updated_cart_totals', checkShippingOptions)
  //   $('body').off('updated_checkout', checkShippingOptions)
  //   $(document).off('change', 'ul#shipping_method input[name^="shipping_method"]', disableUpdateCartHandlers)
  // }

  // enableUpdateCartHandlers()
  
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
	
  
  /**
   * When Lorada autocomplete suggestion is clicked, send a request to GA
   */
  $('.autocomplete-suggestions').on('click', '.autocomplete-suggestion', function(e){
    try {
      var selectionTitle = e.currentTarget.querySelector('.suggestion-title').innerHTML.replace(/(<([^>]+)>)/gi, "");
    } catch(e) {
      var selectionTitle = e;
    }

	 var trackers =   ga.getAll();
	 var firstTracker = trackers[0];

   ga(
    'send', 
    'event', 
    'Behavior Tracking - Search', 
    'Search Selection', 
    selectionTitle, 
    headerSearchTerm ? headerSearchTerm : 'nothing'
  );
   
	  /**
	   *  Send a GA event to each tracker
	   */
	 trackers.map(function(t){
		 var trackerName = t.get('name');
		 ga(
		  trackerName + '.send', 
		  'event', 
		  'Behavior Tracking - Search', 
		  'Search Selection', 
		  selectionTitle, 
		  headerSearchTerm ? headerSearchTerm : 'nothing'
		);
	 })
	
  })
  
})