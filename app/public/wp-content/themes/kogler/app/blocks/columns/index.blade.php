@php
    $sectionPadding = $a['section_padding'] ?? ['py-clamp'];
    if (! is_array($sectionPadding)) {
        $sectionPadding = [$sectionPadding];
    }
    $paddingClasses = implode(' ', array_filter($sectionPadding));

    $bgClass = $a['bg_colour']['slug'] ?? 'bg-white';

    $useBackgroundImage = (bool) ($a['use_background_image'] ?? false);
    $backgroundImage = $a['background_image'] ?? null;
    $hasBackgroundImage = $useBackgroundImage && ! empty($backgroundImage['ID']);
    $useBackgroundOverlay = $hasBackgroundImage && (bool) ($a['use_background_overlay'] ?? true);

    $flipColumns = (bool) ($a['flip_columns'] ?? false);

    $verticalAlign = $a['vertical_align'] ?? 'top';
    if (is_array($verticalAlign)) {
        $verticalAlign = $verticalAlign['value'] ?? 'top';
    }
    $verticalAlign = in_array($verticalAlign, ['top', 'center', 'bottom'], true)
        ? $verticalAlign
        : 'top';
    $vAlignClass = 'is-v-align-' . $verticalAlign;
    $vAlignJustify = match ($verticalAlign) {
        'center' => 'center',
        'bottom' => 'flex-end',
        default => 'flex-start',
    };

    $stickyColumn = $a['sticky_column'] ?? 'none';
    if (is_array($stickyColumn)) {
        $stickyColumn = $stickyColumn['value'] ?? 'none';
    }
    $stickyColumn = in_array($stickyColumn, ['none', 'left', 'right'], true)
        ? $stickyColumn
        : 'none';
    $stickyClass = $stickyColumn !== 'none' ? 'is-sticky-' . $stickyColumn : null;

    $gapColDesktop = $a['gap_col_desktop'] ?: '20px';
    $gapRowDesktop = $a['gap_row_desktop'] ?: '20px';
    $widthStyle = \App\helpers()->resolveColumnsWidthStyle($a);
    $layoutStyle = implode('; ', array_filter([
        "--grid-gap-col: {$gapColDesktop}",
        "--grid-gap-row: {$gapRowDesktop}",
        "--mpx-col-justify: {$vAlignJustify}",
        $widthStyle,
    ]));

    $columnAllowed = 'core/heading,core/paragraph,core/list,core/image,core/html,mpx/partial-button,mpx/partial-subheading,mpx/partial-checklist,fluentfom/guten-block';

    $template = [
        ['mpx/partial-column', [
            'allowedBlocks' => $columnAllowed,
        ], [
            ['core/heading', [
                'level' => 2,
                'placeholder' => 'Add a heading',
            ]],
            ['core/paragraph', [
                'placeholder' => 'Add supporting text',
            ]],
        ]],
        ['mpx/partial-column', [
            'allowedBlocks' => $columnAllowed,
        ], [
            ['core/heading', [
                'level' => 2,
                'placeholder' => 'Add a heading',
            ]],
            ['core/paragraph', [
                'placeholder' => 'Add supporting text',
            ]],
        ]],
    ];

    $anchorId = $a['anchor'] ?? $b['anchor'] ?? '';

    // overflow-hidden breaks position:sticky — only use it when not sticky.
    $sectionClasses = trim(implode(' ', array_filter([
        'relative px-clamp bs-block mpx-columns-section',
        $stickyClass ? null : 'overflow-hidden',
        $vAlignClass,
        $bgClass,
        $paddingClasses,
    ])));
@endphp

<section
    useBlockProps
    @if ($anchorId !== '') id="{{ $anchorId }}" @endif
    class="{{ $sectionClasses }}"
    style="--mpx-col-justify: {{ esc_attr($vAlignJustify) }}"
>
    @if ($hasBackgroundImage)
        {!! wp_get_attachment_image($backgroundImage['ID'], 'full', false, [
            'class' => 'pointer-events-none absolute inset-0 h-full w-full object-cover',
            'alt' => $backgroundImage['alt'] ?? '',
            'loading' => 'lazy',
        ]) !!}

        @if ($useBackgroundOverlay)
            <div class="absolute inset-0 hero-overlay"></div>
        @endif
    @endif

    <div
        class="container relative mpx-columns grid-auto-cards grid-auto-cards-gap {{ $vAlignClass }}{{ $stickyClass ? ' ' . $stickyClass : '' }}{{ $flipColumns ? ' is-flipped' : '' }}"
        style="{!! esc_attr($layoutStyle) !!}"
    >
        {{-- No templateLock: it cascades into nested column InnerBlocks and
             freezes heading/paragraph (can't add/delete). Two columns still
             come from the template; allowedBlocks limits top-level to columns. --}}
        <InnerBlocks
            allowedBlocks="{!! esc_attr(wp_json_encode(['mpx/partial-column'])) !!}"
            template="{!! esc_attr(wp_json_encode($template)) !!}"
        />
    </div>
</section>
