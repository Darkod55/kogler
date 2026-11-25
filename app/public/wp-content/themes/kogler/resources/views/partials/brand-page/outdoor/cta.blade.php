{{--
  Kögler Outdoor — closing CTA.
  Uses the shared Ready to Work Together panel with the outdoor variant.
  $logoId matches the hero. The artwork stays white.
  Shop on Amazon is hidden here while the Customizer URL is empty.
  The section background is outdoor-900, the same as the page, so it meets the outdoor-950 footer.
--}}
@php
    $logoId = 396;
    $logo = '';

    if ($logoId > 0 && function_exists('wp_get_attachment_image')) {
        $mime = function_exists('get_post_mime_type') ? (string) get_post_mime_type($logoId) : '';
        $isImage = function_exists('wp_attachment_is_image') && wp_attachment_is_image($logoId);

        if ($isImage || $mime === 'image/svg+xml') {
            $rendered = wp_get_attachment_image($logoId, 'full', false, [
                'class' => 'h-14 w-auto',
                'alt' => 'Kögler Outdoor',
                'loading' => 'lazy',
                'decoding' => 'async',
            ]);
            $logo = is_string($rendered) ? $rendered : '';
        }
    }

    if ($logo === '' && class_exists(\Illuminate\Support\Facades\Vite::class)) {
        try {
            $logoUrl = \Illuminate\Support\Facades\Vite::asset('resources/images/brands/logo-kogler-outdoor-white.svg');
            $logo = '<img src="' . esc_url($logoUrl) . '" alt="Kögler Outdoor" class="h-14 w-auto" width="220" height="56" loading="lazy" decoding="async">';
        } catch (\Throwable $e) {
            $logo = '';
        }
    }
@endphp
@include('partials.cta-work-together', [
    'ctaVariant' => 'outdoor',
    'ctaBackground' => 'bg-outdoor-900',
    'ctaPadTop' => false,
    'ctaId' => 'outdoor-cta',
    'ctaLogo' => $logo,
])
