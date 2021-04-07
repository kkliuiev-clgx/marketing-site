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
      <div class="search__actions">
        <a href="https://console.meenta.io/by/instrument" target="meenta" class="btn btn--primary">
            Browse More Instruments
        </a>
        <a href="https://stephansmith.typeform.com/to/Scs7Su" onclick="$('.js--closeSearch').click()" target="_blank" class="btn btn--primary-outline" data-toggle="tooltip" data-placement="bottom" title="We are adding new instrument types as we expand our service providers. Please take our (quick) survey to help us fast-track a new equipment type!">
          Request a new instrument type?
        </a>
        <a href="#" class="link link--black js--closeSearch">
          <span>Close Search</span>
          <i class="fas fa-chevron-right"></i>
        </a>
      </div>
    </div>
  </div>
</div>