@php
    $parent = $c['mpx/partial-cards'] ?? [];
    $parentGrid = ($parent && function_exists('bs_get_group'))
        ? bs_get_group($parent, 'grid_controls')
        : [];
    $widthStyle = \App\helpers()->resolveGridItemWidthStyle($a, $parentGrid);

    $coverImage = $a['cover_image'] ?? null;
    $hasCoverImage = ! empty($coverImage['ID']);

    $clampPositionAxis = static function ($value, float $fallback): float {
        if ($value === '' || $value === null) {
            return $fallback;
        }

        return max(0, min(100, (float) $value));
    };

    $posX = $clampPositionAxis($a['image_position_x'] ?? 50, 50);
    $posY = $clampPositionAxis($a['image_position_y'] ?? 50, 50);

    $styleParts = array_filter([
        $widthStyle,
        '--mpx-card-cover-pos: ' . $posX . '% ' . $posY . '%',
    ]);
    $styleAttr = implode('; ', $styleParts);

    $allowedBlocks = [
        'core/heading',
        'core/paragraph',
        'mpx/partial-button',
    ];

    $template = [
        ['core/heading', [
            'level' => 3,
            'content' => 'Fleet Manager',
            'placeholder' => 'Add a title',
        ]],
        ['mpx/partial-button', [], [
            ['core/button', [
                'text' => 'Shop Parts',
                'blockstudio' => [
                    'attributes' => [
                        'button_type' => 'btn-primary',
                    ],
                ],
            ]],
        ]],
    ];
@endphp

<div
    useBlockProps
    class="mpx-card mpx-card--cover-small"
    @if ($styleAttr !== '')
        style="{!! esc_attr($styleAttr) !!}"
    @endif
>
    <div class="mpx-card--cover__media" @if (! $hasCoverImage) aria-hidden="true" @endif>
        @if ($hasCoverImage)
            {!! wp_get_attachment_image((int) $coverImage['ID'], 'large', false, [
                'class' => 'mpx-card--cover__image',
                'alt' => $coverImage['alt'] ?? '',
                'loading' => 'lazy',
            ]) !!}
        @elseif (! empty($isEditor))
            <div class="mpx-card--cover__placeholder">
                {{ __('Select a background image in the block sidebar.', 'sage') }}
            </div>
        @endif
    </div>

    <div class="mpx-card--cover__scrim" aria-hidden="true"></div>

    <div class="mpx-card--cover-small__content">
        <InnerBlocks
            allowedBlocks="{!! esc_attr(wp_json_encode($allowedBlocks)) !!}"
            template="{!! esc_attr(wp_json_encode($template)) !!}"
        />
    </div>
</div>
