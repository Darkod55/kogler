<form role="search" method="get" class="search-form" action="{{ home_url('/') }}">
  <label class="search-form__field">
    <span class="sr-only">
      {{ _x('Search for:', 'label', 'sage') }}
    </span>

    <input
      type="search"
      class="search-form__input"
      placeholder="{!! esc_attr_x('Search…', 'placeholder', 'sage') !!}"
      value="{!! get_search_query() !!}"
      name="s"
    >
  </label>

  <button type="submit" class="btn btn-primary search-form__submit">
    {{ _x('Search', 'submit button', 'sage') }}
  </button>
</form>
