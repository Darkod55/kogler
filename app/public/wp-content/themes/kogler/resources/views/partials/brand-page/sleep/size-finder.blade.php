{{--
  Kögler Sleep — Size Finder.
  Rows and SKUs come from App\Sleep\MattressCatalog::sizeGrid().
--}}
@php
    $columns = [
        ['construction' => 'Innerspring', 'cover' => 'Cloth'],
        ['construction' => 'Innerspring', 'cover' => 'Wipeable'],
        ['construction' => 'Gel foam', 'cover' => 'Cloth'],
        ['construction' => 'Gel foam', 'cover' => 'Wipeable'],
    ];
    $rows = \App\Sleep\MattressCatalog::sizeGrid();
@endphp
<section
  id="size-finder"
  class="relative scroll-mt-chrome bg-white p-clamp-xl"
  x-data="sizeFinder()"
  @fitment:widths.window="setWidths($event.detail)"
>
  <div class="container">
    <h2 class="mb-0 font-fraunces text-dark-blue">
      Size <em class="italic font-medium text-darker-blue">Finder</em>
    </h2>
    <p class="mt-[18px] mb-0 max-w-[680px] lead leading-[1.7] text-(--site-ink)/80">
      Find the bunk width (see the <a class="font-semibold text-dark-blue underline-offset-2 hover:underline" href="#fitment-guide">Fitment Guide</a>), then read across to the part number. All mattresses 7" deep; length 80" unless noted.
    </p>

    <div
      class="relative mt-10 overflow-hidden rounded-3xl border border-(--site-ink)/12"
      x-data="{ canScroll: false }"
      x-init="
        const el = $refs.tableScroll;
        const update = () => { canScroll = el.scrollWidth > el.clientWidth + 2 && el.scrollLeft + el.clientWidth < el.scrollWidth - 2 };
        update();
        el.addEventListener('scroll', update, { passive: true });
        window.addEventListener('resize', update);
      "
    >
      <div x-ref="tableScroll" class="overflow-x-auto">
        <table class="w-full min-w-[760px] border-collapse text-[length:var(--font-size-btn)]">
          <caption class="sr-only">Kogler mattress part numbers by width, construction and cover</caption>
          <thead class="bg-dark-blue text-white">
            <tr>
              <th class="sticky left-0 z-20 border-r border-white/15 bg-dark-blue px-6 py-4 text-left fs-xs font-bold tracking-widest uppercase" scope="col">Width</th>
              @foreach ($columns as $column)
                <th class="px-6 py-4 text-left" scope="col">
                  <span class="block text-[11px] tracking-widest text-white/90 uppercase">{{ $column['construction'] }}</span>
                  <span class="text-[length:var(--font-size-btn)] font-bold">{{ $column['cover'] }}</span>
                </th>
              @endforeach
            </tr>
          </thead>
          <tbody>
            @foreach ($rows as $row)
              <tr class="border-t border-(--site-ink)/10" :class="highlighted('{{ $row['key'] }}') ? 'bg-light-blue/50' : 'bg-white'">
                <th class="sticky left-0 z-10 border-r border-(--site-ink)/10 bg-inherit px-6 py-4 text-left" scope="row">
                  <span class="font-fraunces text-[24px] font-semibold text-dark-blue">{{ $row['width'] }}</span>
                  @if ($row['lengthNote'] !== '')
                    <span class="block fs-xs font-medium text-(--site-ink)/70">{{ $row['lengthNote'] }}</span>
                  @endif
                </th>
                @foreach ($row['cells'] as $sku)
                  <td class="px-6 py-4 tabular-nums">
                    @if ($sku !== '')
                      <button
                        type="button"
                        class="cursor-pointer font-bold text-dark-blue underline-offset-2 hover:underline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark-blue"
                        @click="copySku('{{ $sku }}', $event)"
                      >{{ $sku }}</button>
                      <span x-show="copied === '{{ $sku }}'" x-cloak class="ml-2 text-sm font-semibold text-darker-blue">Copied</span>
                    @else
                      <span aria-hidden="true" class="text-(--site-ink)/35">—</span>
                      <span class="sr-only">Not available</span>
                    @endif
                  </td>
                @endforeach
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div x-show="canScroll" x-cloak class="pointer-events-none absolute inset-y-0 right-0 w-10 bg-gradient-to-l from-white to-transparent" aria-hidden="true"></div>
    </div>
    <p class="sr-only" aria-live="polite" x-text="copied ? copied + ' copied' : ''"></p>
  </div>
</section>
