@php
    $sectionPadding = $a['section_padding'] ?? ['py-clamp-xl'];
    if (! is_array($sectionPadding)) {
        $sectionPadding = [$sectionPadding];
    }
    $paddingClasses = implode(' ', array_filter($sectionPadding));

    $boxBg = $a['bg_colour']['value'] ?? '#00000070';

    $coverImage = $a['cover_image'] ?? null;
    $hasCoverImage = ! empty($coverImage['ID']);

    $clampPositionAxis = static function ($value, float $fallback): float {
        if ($value === '' || $value === null) {
            return $fallback;
        }

        return max(0, min(100, (float) $value));
    };

    $posX = $clampPositionAxis($a['image_position_x'] ?? 70, 70);
    $posY = $clampPositionAxis($a['image_position_y'] ?? 50, 50);

    $boxPosition = $a['box_position'] ?? 'left';
    if (is_array($boxPosition)) {
        $boxPosition = $boxPosition['value'] ?? 'left';
    }
    $boxPosition = $boxPosition === 'right' ? 'right' : 'left';

    $styleAttr = implode('; ', [
        '--mpx-cover-box-bg: ' . $boxBg,
        '--mpx-cover-pos: ' . $posX . '% ' . $posY . '%',
    ]);

    $template = [
        ['core/heading', [
            'level' => 2,
            'content' => 'Get Rapid Relief From Fear, Phobias and Anxiety',
            'placeholder' => 'Add a heading',
        ]],
        ['core/paragraph', [
            'content' => 'Add supporting copy for this cover section.',
            'placeholder' => 'Add supporting text',
        ]],
        ['mpx/partial-button', [], [
            ['core/button', [
                'text' => 'BOOK YOUR CLARITY CALL',
                'blockstudio' => [
                    'attributes' => [
                        'button_type' => 'btn-white',
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
    class="mpx-column-cover relative overflow-hidden text-white bs-block is-box-{{ $boxPosition }}"
    style="{{ esc_attr($styleAttr) }}"
>
    <div class="mpx-column-cover__media" @if (! $hasCoverImage) aria-hidden="true" @endif>
        @if ($hasCoverImage)
            {!! wp_get_attachment_image($coverImage['ID'], 'full', false, [
                'class' => 'mpx-column-cover__image',
                'alt' => $coverImage['alt'] ?? '',
                'loading' => 'lazy',
            ]) !!}
        @elseif (! empty($isEditor))
            <div class="mpx-column-cover__placeholder">
                {{ __('Select a cover image in the block sidebar.', 'sage') }}
            </div>
        @endif
    </div>

    <div class="mpx-column-cover__foreground px-clamp {{ $paddingClasses }}">
        <div class="container">
            <div class="mpx-column-cover__box">
                <InnerBlocks
                    allowedBlocks="{!! esc_attr(wp_json_encode(['core/heading', 'core/paragraph', 'mpx/partial-button'])) !!}"
                    template="{!! esc_attr(wp_json_encode($template)) !!}"
                />
            </div>
        </div>
    </div>
</section>
