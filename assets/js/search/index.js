;(function(window, document, $) {
  var $win = $(window);
  var $doc = $(document);
  var $search, $searchResults, $searchClose, $loader, $searchField;
  var domain, index;

  switch (window.location.hostname) {
    case 'localhost':
    case 'staging.meenta.io':
      domain = 'console.staging.meenta.io';
      index = 'instruments';
      break;
    default:
      domain = 'console.meenta.io';
      index = 'instruments';
  }

  var applicationId = 'SV1FR11FH0';
  var apiKey = 'd364d48f0624fb45e4220fefaf7dd1c1';
  var client = algoliasearch(applicationId, apiKey);

  // Expose the helper
  var helper = algoliasearchHelper(client, index, {
    disjunctiveFacets: ['equipment.name'],
    hitsPerPage: 10,
    maxValuesPerFacet: 10,
    filters: 'status: online'
  });

  helper.on('search', function(results) {
    $searchResults.find('.noResults').remove();
    if ($searchResults.find('.products').length) {
      $searchResults.find('.products').fadeOut('400', function() {
        $loader.appendTo($searchResults);
      });
    } else {
      $loader.appendTo($searchResults);
    }
  })

  // Helper function to format the currency.
  function formatMoney(n, c, d, t) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
      d = d == undefined ? "." : d,
      t = t == undefined ? "," : t,
      s = n < 0 ? "-" : "",
      i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
      j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
  };

  // Helper function to fix images images that
  // would take too long in the DB :)
  var asPNG = function(img) {
    if (img === 'https://assets.illumina.com/content/dam/illumina-marketing/images/systems/nextseq/nextseq-large.jpg')
      img = 'https://cdn.meenta.io/equipment/nextseq-500.jpg'
    img = img.replace('.jpg', '.png')
    img = img.replace('.jpeg', '.png')
    return img;
  }

  // Algolia helper.
  helper.on('result', function(results) {
    var searchFieldVal = $searchField.val();
    var source = $searchResults.data('source');

    try {
      // if (searchFieldVal !== '') {}

      var params = {
        event: 'query',
        attributes: {
          term: searchFieldVal || 'empty',
          method: 'full-text',
          results: results.nbHits || '?'
        }
      }

      window.dataLayer.push(params);

    } catch(err) {
      console.log('Got Error in dataLayer', err.message);
    }

    setTimeout(function() {
      $search.find('.loader').fadeOut();

      var expression = new RegExp(searchFieldVal, "i");
      var count = 0;
      var noResults = '<h4 class="noResults">No results found!</h4>';
      var productTemplate = $('#product-template').html();
      var $productTemplateCotent = $(productTemplate);
      var url = `https://${domain}/machine/`

      $searchResults.html('<div class="products"></div>');

      $.each(results.hits, function(key, value) {
        count++;
        var transitionDelay = (0.15 * count).toFixed(2);

        var $product = $productTemplateCotent.clone();

        // Get the lowest active external price.
        var price = _.chain(value.prices)
          .filter({ group: 'external', enabled: true })
          .map((function(v) { v.price = parseFloat(v.price); return v; }))
          .min(function(o) { return o.price; })
          .value();

        var numOfPrices = _.chain(value.prices)
          .filter({ group: 'external', enabled: true })
          .size()
          .value();

        $product
        .find('.product__image img').attr('src', asPNG(value.photoUrl)).end()
        .find('.product__title').html(value.equipment.name).end()
        .find('.product__location').html(value.address.organization + ' | ' + value.address.city + ' ' + value.address.state).end()
        .find('.product__price').html(value.price || 'NA').end()
        .find('.product__availablity').html(value.availablity || 'available in 3 days').end()
        .find('.btn').attr('href', url + value.instrumentID).end()
        .addClass('animate--in').css('transition', 'opacity .4s ' + transitionDelay + 's ease');

        if (price) {
          $product
            .find('.product__price').html('$' + formatMoney(price.price, ",", ".")).end()
            .find('.product__unit').html(price.unit).end()
            .find('.product__available-date').html(numOfPrices + ' options').end()
            .find('p').html(price.label || 'specifics').end()
        } else {
          $product
            .find('.product__price').html('NA').end()
            .find('.product__unit').html('').end()
        }

        $product.appendTo($searchResults.find('.products'));
      });

      setTimeout(function() {
        $('.product').removeClass('animate--in');
      }, 50);

      if (!(count > 0)) {
        $searchResults.html(noResults);
      }
    }, 500);
  })

  function loadInstruments() {
    var query = $search.find('.search__field').val();
    helper.setQuery(query).search();
  }

  $doc.ready(function() {
    // Set the global so we do not need to find again.
    $search = $('.search');
    
    $searchField = $search.find('.search__field');
    $searchResults = $search.find('.search__results');
    $searchClose = $('.js--closeSearch');
    $loader = $('<span class="loader"></span>');
    $searchForm = $search.find('#searchForm');
    
    
    if(!$searchForm[0]) return false;
    // This will ensure that on return will force a search.
    $searchForm[0].addEventListener('submit', function() {
      loadInstruments()
      return false;
    });

    var $body = $('body');
    var $main = $('.main');
    var $footer = $('.footer');

    var inputTimer;
    var smallDesktopWidth = 1201;
    var tabletWidth = 1024;
    var mobileWidth = 768;

    $searchField.on('click', function() {
      if (!($body.hasClass('search-is-open'))) {
        $body.addClass('search-is-open');
        $search.addClass('search--open');

        // $main.find('.main__inner').fadeOut();

        // $footer.fadeOut();

        // $search.siblings('.link').fadeOut();

        $searchClose.fadeIn();
        $search.find('.search__head').animate({
          width: '100%'
        },
        300, function() {
          $(this).closest('.search').find('.search__body').fadeIn();

          loadInstruments()
        });
      }
    }).on('input', function() {
      clearTimeout(inputTimer);

      inputTimer = setTimeout(function() {
        loadInstruments()
      }, 300);
    });

    $searchClose.on('click', function(event) {
      var searchWidth = '570px';

      if ($win.outerWidth() < smallDesktopWidth) {
        searchWidth = '570px';
      }

      if ($win.outerWidth() < tabletWidth) {
        searchWidth = '85%';
      }

      if ($win.outerWidth() < mobileWidth) {
        searchWidth = '100%';
      }

      $body.removeClass('search-is-open');
      $search.removeClass('search--open');

      $searchField.val('');

      $search.siblings('.link').fadeIn();

      $main.find('.main__inner').fadeIn();

      $footer.fadeIn();

      $search.find('.search__head').animate({
        width: searchWidth
      }, 200);

      $search.find('.search__body').fadeOut(200, function() {
        $(this).closest('.search').find('.search__results').html('');

        $('html, body').animate({scrollTop: $("body").offset().top}, 1000); 
      });

      event.preventDefault();
    });

  });
})(window, document, window.jQuery);
