{{--
  Shop pagination — prev/next + page numbers; clicks delegated via Alpine parent.
--}}

@php
  $links = $links ?? [];
  $current = (int) ($current ?? 1);
  $total = (int) ($total ?? 1);
  $prevUrl = '';
  $nextUrl = '';

  foreach ($links as $link) {
    $page = (int) ($link['page'] ?? 0);
    if ($page === $current - 1) {
      $prevUrl = (string) ($link['url'] ?? '');
    }
    if ($page === $current + 1) {
      $nextUrl = (string) ($link['url'] ?? '');
    }
  }
@endphp

@if ($links !== [] && $total > 1)
  <nav class="mpx-shop-pagination" aria-label="{{ __('Product pagination', 'sage') }}">
    <ul class="mpx-shop-pagination__list">
      <li>
        @if ($prevUrl !== '')
          <a
            class="mpx-shop-pagination__arrow"
            href="{{ esc_url($prevUrl) }}"
            data-mpx-shop-page="{{ $current - 1 }}"
            aria-label="{{ __('Previous page', 'sage') }}"
          >
            <span aria-hidden="true">@svgIcon('chevron-left'|22|22)</span>
          </a>
        @else
          <span class="mpx-shop-pagination__arrow is-disabled" aria-disabled="true">
            <span aria-hidden="true">@svgIcon('chevron-left'|22|22)</span>
            <span class="sr-only">{{ __('Previous page', 'sage') }}</span>
          </span>
        @endif
      </li>

      @foreach ($links as $link)
        <li>
          @if (! empty($link['current']))
            <span class="mpx-shop-pagination__link is-current" aria-current="page">
              {{ $link['page'] }}
            </span>
          @else
            <a
              class="mpx-shop-pagination__link"
              href="{{ esc_url($link['url']) }}"
              data-mpx-shop-page="{{ (int) $link['page'] }}"
            >
              {{ $link['page'] }}
            </a>
          @endif
        </li>
      @endforeach

      <li>
        @if ($nextUrl !== '')
          <a
            class="mpx-shop-pagination__arrow"
            href="{{ esc_url($nextUrl) }}"
            data-mpx-shop-page="{{ $current + 1 }}"
            aria-label="{{ __('Next page', 'sage') }}"
          >
            <span aria-hidden="true">@svgIcon('chevron-right'|22|22)</span>
          </a>
        @else
          <span class="mpx-shop-pagination__arrow is-disabled" aria-disabled="true">
            <span aria-hidden="true">@svgIcon('chevron-right'|22|22)</span>
            <span class="sr-only">{{ __('Next page', 'sage') }}</span>
          </span>
        @endif
      </li>
    </ul>
  </nav>
@endif
