@php
    $parent = $c['mpx/partial-cards'] ?? [];
    $parentGrid = ($parent && function_exists('bs_get_group'))
        ? bs_get_group($parent, 'grid_controls')
        : [];
    $widthStyle = \App\helpers()->resolveGridItemWidthStyle($a, $parentGrid);

    $bleedImage = (bool) ($a['bleed_image'] ?? false);
    $centerContent = (bool) ($a['center_content'] ?? false);
    $intrinsicImage = ! $bleedImage && (bool) ($a['intrinsic_image'] ?? false);

    $cardClass = trim(implode(' ', array_filter([
        'mpx-card mpx-card--image',
        $bleedImage ? 'is-bleed-image' : null,
        $centerContent ? 'is-content-centered' : null,
        $intrinsicImage ? 'is-intrinsic-image' : null,
    ])));

    $allowedBlocks = [
        'core/image',
        'core/heading',
        'core/paragraph',
        'mpx/partial-button',
    ];
    $template = [
        ['core/image', []],
        ['core/heading', [
            'level' => 3,
            'placeholder' => 'Add a heading',
        ]],
        ['core/paragraph', [
            'placeholder' => 'Add supporting text',
        ]],
        ['mpx/partial-button', []],
    ];
@endphp

<div
    useBlockProps
    class="{{ $cardClass }}"
    @if ($widthStyle !== '')
        style="{!! esc_attr($widthStyle) !!}"
    @endif
>
    <InnerBlocks
        allowedBlocks="{!! esc_attr(wp_json_encode($allowedBlocks)) !!}"
        template="{!! esc_attr(wp_json_encode($template)) !!}"
    />
</div>
