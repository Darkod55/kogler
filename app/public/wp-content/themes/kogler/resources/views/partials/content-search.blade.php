@php
  $postType = get_post_type();
  $typeLabel = match ($postType) {
    'product' => __('Product', 'sage'),
    'page' => __('Page', 'sage'),
    'post' => __('Post', 'sage'),
    default => '',
  };
@endphp

<article @php(post_class('search-result py-4 first:pt-0'))>
  <div class="search-result__heading mb-1">
    <h2 class="search-result__title h4 mb-0">
      <a href="{{ get_permalink() }}" class="search-result__link">
        {!! $title !!}
      </a>
    </h2>
    @if ($typeLabel !== '')
      <span class="search-result__badge">{{ $typeLabel }}</span>
    @endif
  </div>

  @if (has_excerpt() || get_the_content())
    <div class="search-result__summary entry-summary max-w-3xl [&_p]:mb-0">
      @php(the_excerpt())
    </div>
  @endif
</article>
