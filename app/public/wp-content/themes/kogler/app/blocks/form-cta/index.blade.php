@php
    $sectionPadding = $a['section_padding'] ?? ['py-clamp'];
    if (! is_array($sectionPadding)) {
        $sectionPadding = [$sectionPadding];
    }
    $paddingClasses = implode(' ', array_filter($sectionPadding));
    $bgClass = $a['bg_colour']['slug'] ?? 'bg-white';

    $gapColDesktop = $a['gap_col_desktop'] ?: '40px';
    $gapRowDesktop = $a['gap_row_desktop'] ?: '20px';
    $widthStyle = \App\helpers()->resolveColumnsWidthStyle($a);
    $layoutStyle = implode('; ', array_filter([
        "--grid-gap-col: {$gapColDesktop}",
        "--grid-gap-row: {$gapRowDesktop}",
        '--mpx-col-justify: start',
        $widthStyle,
    ]));

    $columnAllowed = 'core/heading,core/paragraph,core/list,core/image,core/html,mpx/partial-button,mpx/partial-subheading,mpx/partial-checklist,fluentfom/guten-block';

    $template = [
        ['mpx/partial-column', [
            'allowedBlocks' => $columnAllowed,
        ], [
            ['core/paragraph', [
                'content' => 'CONTACT',
                'placeholder' => 'Add a tagline',
                'className' => 'fs-tagline',
            ]],
            ['core/heading', [
                'level' => 2,
                'content' => 'Ready to Experience the Difference?',
                'placeholder' => 'Add a heading',
            ]],
            ['core/paragraph', [
                'content' => 'Fill out the form and receive a detailed quote within 24 hours',
                'placeholder' => 'Add supporting text',
            ]],
        ]],
        ['mpx/partial-column', [
            'allowedBlocks' => $columnAllowed,
        ], [
            ['fluentfom/guten-block', []],
        ]],
    ];

    $anchorId = $a['anchor'] ?? $b['anchor'] ?? '';

    $sectionClasses = trim(implode(' ', array_filter([
        'relative px-clamp bs-block mpx-form-cta',
        $bgClass,
        $paddingClasses,
    ])));
@endphp

<section
    useBlockProps
    @if ($anchorId !== '') id="{{ $anchorId }}" @endif
    class="{{ $sectionClasses }}"
    style="--mpx-col-justify: center"
>
    {{--
      Same shell as mpx/columns (container + mpx-columns + grid-auto-cards)
      so FE/editor column width rules apply. Panel class adds border + padding.
    --}}
    <div
        class="container relative mpx-form-cta__panel mpx-columns grid-auto-cards grid-auto-cards-gap is-v-align-center"
        style="{!! esc_attr($layoutStyle) !!}"
    >
        <InnerBlocks
            allowedBlocks="{!! esc_attr(wp_json_encode(['mpx/partial-column'])) !!}"
            template="{!! esc_attr(wp_json_encode($template)) !!}"
        />
    </div>
</section>
