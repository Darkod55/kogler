{{--
  Goliath Steel — closing CTA.
  Uses the shared Ready to Work Together panel (partials/cta-work-together)
  with the goliath variant: logo, gloves photo, and brand buttons.
  $logoId is the same full-colour artwork as the hero. Do not recolour it.
  Set $imageId to the Media Library attachment of the gloved hand.
  resources/images/brands/goliath-gloves-wrench.webp is used when that file
  is in the build and no attachment is set.
--}}
@php
    $logoId = 397;
    $imageId = 414;

    $logo = '';

    if ($logoId > 0 && function_exists('wp_get_attachment_image')) {
        $mime = function_exists('get_post_mime_type') ? (string) get_post_mime_type($logoId) : '';
        $isImage = function_exists('wp_attachment_is_image') && wp_attachment_is_image($logoId);

        if ($isImage || $mime === 'image/svg+xml') {
            $rendered = wp_get_attachment_image($logoId, 'full', false, [
                'class' => 'h-auto w-[200px] min-[1000px]:w-[260px]',
                'alt' => 'Goliath Steel',
                'loading' => 'lazy',
                'decoding' => 'async',
            ]);
            $logo = is_string($rendered) ? $rendered : '';
        }
    }

    if ($logo === '' && class_exists(\Illuminate\Support\Facades\Vite::class)) {
        try {
            $logoUrl = \Illuminate\Support\Facades\Vite::asset('resources/images/brands/logo-goliath-steel-full-colour.svg');
            $logo = '<img src="' . esc_url($logoUrl) . '" alt="Goliath Steel" class="h-auto w-[200px] min-[1000px]:w-[260px]" loading="lazy" decoding="async">';
        } catch (\Throwable $e) {
            $logo = '';
        }
    }

    $photo = '';
    $photoClass = 'block min-h-[260px] w-full min-w-0 shrink grow basis-full self-stretch object-cover object-center min-[1000px]:min-h-[360px] min-[1000px]:basis-[420px]';

    if ($imageId > 0 && function_exists('wp_get_attachment_image') && function_exists('wp_attachment_is_image') && wp_attachment_is_image($imageId)) {
        $rendered = wp_get_attachment_image($imageId, 'full', false, [
            'class' => $photoClass,
            'alt' => 'Hand in an orange Goliath Steel nitrile glove gripping a wrench',
            'loading' => 'lazy',
            'decoding' => 'async',
            'sizes' => '(min-width: 1000px) 50vw, 100vw',
        ]);
        $photo = is_string($rendered) ? $rendered : '';
    }

    if ($photo === '' && class_exists(\Illuminate\Support\Facades\Vite::class)) {
        try {
            $photoUrl = \Illuminate\Support\Facades\Vite::asset('resources/images/brands/goliath-gloves-wrench.webp');
            $photo = '<img src="' . esc_url($photoUrl) . '" alt="Hand in an orange Goliath Steel nitrile glove gripping a wrench" class="' . esc_attr($photoClass) . '" loading="lazy" decoding="async">';
        } catch (\Throwable $e) {
            $photo = '';
        }
    }
@endphp
@include('partials.cta-work-together', [
    'ctaVariant' => 'goliath',
    'ctaBackground' => 'bg-goliath-900',
    'ctaPadTop' => false,
    'ctaId' => 'goliath-cta',
    'ctaLogo' => $logo,
    'ctaPhoto' => $photo,
])
