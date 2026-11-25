{{--
  Homepage capabilities. Sits flush under the hero. No heading.
  Defaults are used until the capabilities repeater on the front page has rows.
--}}
@php
    $icons = ['factory', 'tag', 'bed', 'handshake'];
    $items = [
        ['type' => 'icon', 'icon' => 'factory', 'number' => '', 'label' => 'Distribution & Manufacturing'],
        ['type' => 'icon', 'icon' => 'tag', 'number' => '', 'label' => 'Custom / PL Capabilities'],
        ['type' => 'stat', 'icon' => '', 'number' => '50+', 'label' => 'Dedicated Sales Representatives'],
        ['type' => 'icon', 'icon' => 'bed', 'number' => '', 'label' => 'Aftermarket Leader in Mattresses'],
        ['type' => 'icon', 'icon' => 'handshake', 'number' => '', 'label' => 'Strategic Partnership Solutions'],
    ];

    if (function_exists('get_field')) {
        $saved = get_field('capabilities');
        $rows = [];

        if (is_array($saved)) {
            foreach ($saved as $row) {
                if (! is_array($row) || count($rows) >= 5) {
                    continue;
                }

                $type = ($row['type'] ?? '') === 'stat' ? 'stat' : 'icon';
                $icon = in_array($row['icon'] ?? '', $icons, true) ? $row['icon'] : '';
                $number = trim((string) ($row['number'] ?? ''));
                $label = trim((string) ($row['label'] ?? ''));

                if ($label === '' && $number === '') {
                    continue;
                }

                $rows[] = [
                    'type' => $type,
                    'icon' => $icon,
                    'number' => $number,
                    'label' => $label,
                ];
            }
        }

        if ($rows !== []) {
            $items = $rows;
        }
    }
@endphp
<section aria-label="{{ __('What we offer', 'sage') }}" class="m-0 bg-white px-clamp">
  <div class="container border-b border-dark-blue/15">
    <ul class="m-0 grid list-none grid-cols-2 p-0 min-[981px]:grid-cols-5">
      @foreach ($items as $index => $item)
        @php
            $isStat = $item['type'] === 'stat';
            $itemClass = 'flex min-w-0 flex-col items-center justify-center border-dark-blue/15 px-5 py-[52px] text-center text-[16px] font-semibold leading-[1.35] text-dark-blue';
            $itemClass .= $index === 0 ? ' border-l-0' : ' border-l max-[980px]:border-l-0';

            if ($isStat) {
                $itemClass .= ' gap-3 bg-light max-[980px]:order-first max-[980px]:col-span-2';
            } else {
                $itemClass .= ' gap-[18px] max-[980px]:border-t max-[980px]:px-4 max-[980px]:py-9';
            }
        @endphp
        <li class="{{ $itemClass }}">
          @if ($isStat)
            @if ($item['number'] !== '')
              <span class="font-fraunces text-[64px] font-semibold leading-[0.9] tracking-[-1px] text-dark-blue">{{ $item['number'] }}</span>
            @endif
          @elseif (in_array($item['icon'], $icons, true))
            @include('partials.home.icons.capability-' . $item['icon'])
          @endif
          @if ($item['label'] !== '')
            <span class="text-balance">{{ $item['label'] }}</span>
          @endif
        </li>
      @endforeach
    </ul>
  </div>
</section>
