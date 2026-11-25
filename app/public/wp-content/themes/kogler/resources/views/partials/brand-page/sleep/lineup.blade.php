{{--
  Kögler Sleep — The 2027 Lineup.
  Part numbers come from App\Sleep\MattressCatalog.
  Set the image IDs to Media Library attachments.
--}}
@php
    $innerspringImageId = 401;
    $gelClothImageId = 399;
    $gelWipeableImageId = 400;

    $innerspringParts = \App\Sleep\MattressCatalog::partsForCover('Innerspring');
    $gelParts = \App\Sleep\MattressCatalog::partsForCover('Gel Foam');
@endphp
<section id="lineup" class="relative scroll-mt-chrome bg-light p-clamp-xl">
  <div class="container">
    <h2 class="mb-0 font-fraunces text-dark-blue">
      The 2027 <em class="italic font-medium text-darker-blue">Lineup</em>
    </h2>
    <p class="mt-[18px] mb-0 max-w-[640px] lead leading-[1.7] text-(--site-ink)/80">
      Two constructions, two cover options. All 7" deep, roll-packed and sealed, made in Cleveland, TN.
    </p>

    @include('partials.brand-page.sleep.lineup-card', [
        'cardClass' => 'mt-14',
        'cardId' => 'innerspring',
        'anchorId' => 'lineup-innerspring',
        'title' => 'Innerspring Mattress',
        'intro' => 'Premium coil support with a familiar feel. 7" deep. Cloth or wipeable cover.',
        'tabLabel' => 'Innerspring cover',
        'imageLast' => false,
        'caption' => false,
        'parts' => $innerspringParts,
        'clothImageId' => $innerspringImageId,
        'clothAlt' => 'Kögler innerspring mattress showing the coil core, with its roll-pack box',
        'wipeableImageId' => 0,
        'wipeableAlt' => '',
        'features' => [
            ['feature' => 'Premium 5" innerspring core', 'benefit' => 'Responsive, supportive feel drivers already know'],
            ['feature' => '7" profile', 'benefit' => 'Fits standard sleeper bunks'],
            ['feature' => 'Cloth or wipeable cover', 'benefit' => 'Cloth for comfort; wipeable cover cleans up fast between drivers'],
            ['feature' => 'Roll-packed & sealed', 'benefit' => 'Less shelf space; easy for one person to carry into the cab'],
            ['feature' => 'Made in Cleveland, TN', 'benefit' => 'Standard sizes ship in 3–5 days'],
        ],
    ])

    @include('partials.brand-page.sleep.lineup-card', [
        'cardClass' => 'mt-6',
        'cardId' => 'gel',
        'anchorId' => 'lineup-gel-foam',
        'title' => 'Gel-Infused Foam Mattress',
        'intro' => 'Gel-infused high-density foam through the entire mattress. 7" deep.',
        'tabLabel' => 'Gel foam cover',
        'imageLast' => true,
        'caption' => true,
        'parts' => $gelParts,
        'clothImageId' => $gelClothImageId,
        'clothAlt' => 'Gel-infused foam mattress with grey cloth cover, with its roll-pack box',
        'wipeableImageId' => $gelWipeableImageId,
        'wipeableAlt' => 'Gel-infused foam mattress with wipeable navy nylon cover, with its roll-pack box',
        'features' => [
            ['feature' => 'Gel-infused foam, top to bottom', 'benefit' => 'Helps drivers sleep cooler, with even support across the whole mattress'],
            ['feature' => 'High-density foam', 'benefit' => 'Supportive and durable for nightly use on the road'],
            ['feature' => 'Cloth or wipeable nylon cover', 'benefit' => 'Cloth for comfort; nylon wipes clean between drivers'],
            ['feature' => 'Roll-packed & sealed', 'benefit' => 'Less shelf space; easy to carry into the cab'],
            ['feature' => 'Made in Cleveland, TN', 'benefit' => 'Standard sizes ship in 3–5 days'],
        ],
    ])
  </div>
</section>
