{{--
  Kögler Sleep — Ordering Information.
  Cards are edited in the array below. The theme has no ACF.
  Labels are stored in normal case; CSS supplies the capitals.
--}}
@php
    $orderingCards = [
        ['label' => 'Quantities', 'value' => 'Skid = 30 · ½ Skid = 15'],
        ['label' => 'Standard lead time', 'value' => '3–5 days'],
        ['label' => 'Special order / MTO', 'value' => '1–2 weeks · quoted on request'],
        ['label' => 'Made in', 'value' => 'Cleveland, Tennessee, USA'],
        ['label' => 'Ships from', 'value' => 'Cleveland, TN · Romeoville, IL'],
        ['label' => 'Packaging', 'value' => 'Roll-packed & sealed'],
    ];
@endphp
<section id="ordering" class="relative bg-white p-clamp-xl">
  <div class="container">
    <h2 class="mb-0 font-fraunces text-dark-blue">
      Ordering <em class="italic font-medium text-darker-blue">Information</em>
    </h2>

    <dl class="mt-10 mb-0 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
      @foreach ($orderingCards as $card)
        <div class="rounded-t-[4px] rounded-b-[20px] border-t-[3px] border-dark-blue bg-light px-7 py-6">
          <dt class="fs-xs font-bold tracking-widest text-(--site-ink)/70 uppercase">{{ $card['label'] }}</dt>
          <dd class="mt-2 mb-0 text-[19px] font-bold leading-[1.4] text-dark-blue">{{ $card['value'] }}</dd>
        </div>
      @endforeach
    </dl>
  </div>
</section>
