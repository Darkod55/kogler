{{--
  Kögler Sleep — The 2027 Lineup.
  Part numbers come from App\Sleep\MattressCatalog.
  Set the image IDs to Media Library attachments. The named WebP files are
  used when they are in the theme build.
--}}
@php
    $innerspringImageId = 0;
    $gelClothImageId = 0;
    $gelWipeableImageId = 0;

    $lineupImage = function (int $id, string $file): string {
        if ($id && function_exists('wp_attachment_is_image') && wp_attachment_is_image($id)) {
            $url = wp_get_attachment_image_url($id, 'full');

            return is_string($url) ? $url : '';
        }

        if (class_exists(\Illuminate\Support\Facades\Vite::class)) {
            try {
                return \Illuminate\Support\Facades\Vite::asset('resources/images/brands/' . $file);
            } catch (\Throwable $e) {
                return '';
            }
        }

        return '';
    };

    $innerspringParts = \App\Sleep\MattressCatalog::partsForCover('Innerspring');
    $gelParts = \App\Sleep\MattressCatalog::partsForCover('Gel Foam');
@endphp
<section id="lineup" class="relative bg-light px-clamp py-clamp-xl">
  <div class="container">
    <h2 class="mb-0 font-fraunces text-[clamp(34px,3.8vw,54px)] font-semibold leading-[1.08] tracking-tight text-dark-blue">
      The 2027 <em class="italic font-medium text-darker-blue">Lineup</em>
    </h2>
    <p class="mt-[18px] mb-0 max-w-[640px] text-[length:var(--font-size-tagline)] leading-[1.7] text-(--site-ink)/80">
      Two constructions, two cover options. All 7" deep, roll-packed and sealed, made in Cleveland, TN.
    </p>

    @include('partials.brand-page.sleep.lineup-card', [
        'cardClass' => 'mt-14',
        'cardId' => 'innerspring',
        'title' => 'Innerspring Mattress',
        'intro' => 'Premium coil support with a familiar feel. 7" deep. Cloth or wipeable cover.',
        'tabLabel' => 'Innerspring cover',
        'imageLast' => false,
        'caption' => false,
        'parts' => $innerspringParts,
        'clothImage' => [
            'url' => $lineupImage($innerspringImageId, 'kogler-sleep-innerspring-mattress.webp'),
            'alt' => 'Kögler innerspring mattress showing the coil core, with its roll-pack box',
        ],
        'wipeableImage' => ['url' => '', 'alt' => ''],
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
        'title' => 'Gel-Infused Foam Mattress',
        'intro' => 'Gel-infused high-density foam through the entire mattress. 7" deep.',
        'tabLabel' => 'Gel foam cover',
        'imageLast' => true,
        'caption' => true,
        'parts' => $gelParts,
        'clothImage' => [
            'url' => $lineupImage($gelClothImageId, 'kogler-sleep-gel-foam-cloth-cover.webp'),
            'alt' => 'Gel-infused foam mattress with grey cloth cover, with its roll-pack box',
        ],
        'wipeableImage' => [
            'url' => $lineupImage($gelWipeableImageId, 'kogler-sleep-gel-foam-wipeable-cover.webp'),
            'alt' => 'Gel-infused foam mattress with wipeable navy nylon cover, with its roll-pack box',
        ],
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
