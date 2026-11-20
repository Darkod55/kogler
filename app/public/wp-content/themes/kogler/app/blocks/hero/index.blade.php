@php
    $sectionPadding = $a['section_padding'] ?? ['py-clamp-xl'];
    if (! is_array($sectionPadding)) {
        $sectionPadding = [$sectionPadding];
    }
    $paddingClasses = implode(' ', array_filter($sectionPadding));

    $heroImage = $a['hero_image'] ?? null;
    $hasHeroImage = ! empty($heroImage['ID']);
    $heroVideo = $a['hero_video'] ?? null;
    $hasHeroVideo = ! empty($heroVideo['ID']);

    $videoUrl = $hasHeroVideo ? wp_get_attachment_url((int) $heroVideo['ID']) : '';
    $videoMime = $hasHeroVideo ? (get_post_mime_type((int) $heroVideo['ID']) ?: 'video/mp4') : '';
    $posterUrl = $hasHeroImage ? wp_get_attachment_image_url((int) $heroImage['ID'], 'full') : '';

    $clampPositionAxis = static function ($value, float $fallback): float {
        if ($value === '' || $value === null) {
            return $fallback;
        }

        return max(0, min(100, (float) $value));
    };

    $desktopX = $clampPositionAxis($a['image_position_x'] ?? 100, 100);
    $desktopY = $clampPositionAxis($a['image_position_y'] ?? 50, 50);
    $desktopPosition = $desktopX . '% ' . $desktopY . '%';

    $styleVars = [
        '--mpx-hero-pos-desktop: ' . $desktopPosition,
    ];

    if (! empty($a['custom_position_tablet'])) {
        $tabletX = $clampPositionAxis($a['image_position_x_tablet'] ?? null, $desktopX);
        $tabletY = $clampPositionAxis($a['image_position_y_tablet'] ?? null, $desktopY);
        $styleVars[] = '--mpx-hero-pos-tablet: ' . $tabletX . '% ' . $tabletY . '%';
    }

    if (! empty($a['custom_position_mobile'])) {
        $mobileX = $clampPositionAxis($a['image_position_x_mobile'] ?? null, $desktopX);
        $mobileY = $clampPositionAxis($a['image_position_y_mobile'] ?? null, $desktopY);
        $styleVars[] = '--mpx-hero-pos-mobile: ' . $mobileX . '% ' . $mobileY . '%';
    }

    $styleAttr = implode('; ', $styleVars);
    $hasMedia = $hasHeroVideo || $hasHeroImage;

    $template = [
        ['core/heading', [
            'level' => 1,
            'content' => 'Sleep Better Drive Safer',
            'placeholder' => 'Add a heading',
        ]],
        ['core/paragraph', [
            'content' => 'Premium truck mattresses and heavy-duty parts from America\'s trusted manufacturer. Serving 500+ fleets nationwide with next-day shipping.',
            'placeholder' => 'Add supporting text',
        ]],
        ['mpx/partial-button', [], [
            ['core/button', [
                'text' => 'Explore All Products',
                'blockstudio' => [
                    'attributes' => [
                        'button_type' => 'btn-secondary',
                    ],
                ],
            ]],
        ]],
        ['mpx/partial-button', [], [
            ['core/button', [
                'text' => 'Request Custom Dimensions',
                'blockstudio' => [
                    'attributes' => [
                        'button_type' => 'btn-link-white',
                        'include_icon' => true,
                    ],
                ],
            ]],
        ]],
    ];

    $anchorId = $a['anchor'] ?? $b['anchor'] ?? '';
@endphp

<section
    useBlockProps
    @if ($anchorId !== '') id="{{ $anchorId }}" @endif
    class="mpx-hero relative overflow-hidden text-white bs-block"
    style="{{ esc_attr($styleAttr) }}"
>
    <div class="mpx-hero__media" @if (! $hasMedia) aria-hidden="true" @endif>
        @if ($hasHeroVideo && $videoUrl)
            <video
                class="mpx-hero__video"
                autoplay
                muted
                loop
                playsinline
                @if ($posterUrl) poster="{{ esc_url($posterUrl) }}" @endif
            >
                <source src="{{ esc_url($videoUrl) }}" type="{{ esc_attr($videoMime) }}">
            </video>
        @elseif ($hasHeroImage)
            {!! wp_get_attachment_image($heroImage['ID'], 'full', false, [
                'class' => 'mpx-hero__image',
                'alt' => $heroImage['alt'] ?? '',
                'loading' => 'eager',
                'fetchpriority' => 'high',
            ]) !!}
        @elseif (! empty($isEditor))
            <div class="mpx-hero__placeholder">
                {{ __('Select a background image (and optional video) in the block sidebar.', 'sage') }}
            </div>
        @endif
    </div>

    <div class="mpx-hero__scrim" aria-hidden="true"></div>

    <div class="mpx-hero__foreground px-clamp {{ $paddingClasses }}">
        <div class="container">
            <div class="mpx-hero__content">
                <InnerBlocks
                    allowedBlocks="{!! esc_attr(wp_json_encode(['mpx/partial-subheading', 'core/heading', 'core/paragraph', 'mpx/partial-button'])) !!}"
                    template="{!! esc_attr(wp_json_encode($template)) !!}"
                />
            </div>
        </div>
    </div>
</section>
