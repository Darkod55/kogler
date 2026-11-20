@php
    $coverImage = $a['cover_image'] ?? null;
    $hasCoverImage = ! empty($coverImage['ID']);

    $tileBg = $a['tile_bg'] ?? null;
    if (is_array($tileBg)) {
        $tileBgHex = trim((string) ($tileBg['value'] ?? $tileBg['color'] ?? ''));
    } else {
        $tileBgHex = trim((string) ($tileBg ?? ''));
    }
    if ($tileBgHex === '') {
        $tileBgHex = 'var(--color-primary)';
    }

    $clampPositionAxis = static function ($value, float $fallback): float {
        if ($value === '' || $value === null) {
            return $fallback;
        }

        return max(0, min(100, (float) $value));
    };

    $posX = $clampPositionAxis($a['image_position_x'] ?? 50, 50);
    $posY = $clampPositionAxis($a['image_position_y'] ?? 50, 50);

    $styleAttr = implode('; ', [
        '--mpx-mosaic-tile-bg: ' . $tileBgHex,
        '--mpx-mosaic-tile-pos: ' . $posX . '% ' . $posY . '%',
    ]);

    $allowedBlocks = [
        'core/heading',
        'core/paragraph',
        'mpx/partial-button',
    ];

    $template = [
        ['core/heading', [
            'level' => 3,
            'placeholder' => 'Add a title',
        ]],
        ['mpx/partial-button', [], [
            ['core/button', [
                'text' => 'Learn more',
                'blockstudio' => [
                    'attributes' => [
                        'button_type' => 'btn-secondary',
                    ],
                ],
            ]],
        ]],
    ];

    $tileClass = trim(implode(' ', array_filter([
        'mpx-mosaic-tile',
        $hasCoverImage ? 'has-image' : null,
    ])));
@endphp

<div
    useBlockProps
    class="{{ $tileClass }}"
    style="{!! esc_attr($styleAttr) !!}"
>
    <div class="mpx-mosaic-tile__media" @if (! $hasCoverImage) aria-hidden="true" @endif>
        @if ($hasCoverImage)
            {!! wp_get_attachment_image((int) $coverImage['ID'], 'large', false, [
                'class' => 'mpx-mosaic-tile__image',
                'alt' => $coverImage['alt'] ?? '',
                'loading' => 'lazy',
            ]) !!}
        @endif
    </div>

    @if ($hasCoverImage)
        <div class="mpx-mosaic-tile__scrim" aria-hidden="true"></div>
    @endif

    <div class="mpx-mosaic-tile__content">
        <InnerBlocks
            allowedBlocks="{!! esc_attr(wp_json_encode($allowedBlocks)) !!}"
            template="{!! esc_attr(wp_json_encode($template)) !!}"
        />
    </div>
</div>
