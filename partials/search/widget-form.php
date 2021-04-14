<div id="search-widget" class="search-wrapper">
  <div class="search">
    <div class="search__head">
      <form class="search__form" action="?" name="searchForm" onSubmit="return false" id="searchForm" method="get" autocomplete="off">
        <a href="#" class="search__close js--closeSearch">close</a>
        <input type="search" name="search" placeholder="Search for instruments or labs" aria-label="Search" class="search__field">
        <i class="fas fa-search search-icon"></i>
      </form>
    </div>

    <div class="search__body">
      <div class="search__results"></div>
      <div class="search__actions d-lg-flex align-items-center">
        <a href="#" class="btn btn-light link link--black mr-lg-auto js--closeSearch">
          <i class="fas fa-times"></i>
          <span>Close Search</span>
        </a>
        <a href="https://console.meenta.io/by/instrument" target="meenta" class="btn btn-dark">
            Browse More Instruments
        </a>
        <a href="https://stephansmith.typeform.com/to/Scs7Su" onclick="$('.js--closeSearch').click()" target="_blank" class="btn btn-light" data-toggle="tooltip" data-placement="bottom" title="We are adding new instrument types as we expand our service providers. Please take our (quick) survey to help us fast-track a new equipment type!">
          Request a new instrument type?
        </a>
      </div>
    </div>
  </div>
</div>

<template id="product-template">
  <div class="product">
    <div class="product__inner">
      <div class="product__content">
        <div class="product__image">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/product-placeholder.jpg" alt="">
        </div>
        <ul>
          <li>
            <h3 class="product__title"></h3>
            <h4 class="product__location"></h4>
          </li>
          <li>
            <h3 class="product__price"></h3>
            <span class="product__unit"></span>
            <p></p>
          </li>
          <li>
            <h3 class="product__available-date"></h3>
            <span class="product__availablity"></span>
          </li>
        </ul>
      </div>
      <div class="product__aside">
        <a href="#" target="meenta" class="btn btn--white btn--outline">
          Book Now
        </a>
      </div>
    </div>
  </div>
</template>

<template id="no-results-template">
	<h4 class="noResults">
		No results found!
		<br>
		<br>
		<div style="width: 50% !important; margin: auto !important;">
			<p class="clearfix">
				Sorry, we are currently focused on NGS and
				Biophysics instruments. We planning to add new
				instruments soon.
			</p>
		</div>
	</h4>
</template>
