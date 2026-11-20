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
    $backgroundImageUrl = $hasBackgroundImage
        ? wp_get_attachment_image_url((int) $backgroundImage['ID'], 'full')
        : '';
    $useBackgroundOverlay = $hasBackgroundImage && (bool) ($a['use_background_overlay'] ?? true);

    $limitWidth = (bool) ($a['limit_width'] ?? false);
    $enableContentPosition = (bool) ($a['enable_content_position'] ?? false);
    $positionClass = null;
    if ($enableContentPosition) {
        $positionClass = match ($a['content_position'] ?? 'left') {
            'center' => 'content-pos-center',
            'right' => 'content-pos-right',
            default => 'content-pos-left',
        };
    }
    $contentClasses = trim(implode(' ', array_filter([
        'container relative',
        $limitWidth ? 'mw-1000' : null,
        $positionClass,
    ])));

    $allowedBlocks = [
        'core/heading',
        'core/paragraph',
        'core/list',
        'core/image',
        'core/video',
        'core/embed',
        'mpx/partial-button',
        'mpx/partial-subheading',
        'mpx/partial-cards',
        'mpx/partial-products',
        'mpx/partial-checklist',
        'rank-math/faq-block',
        'fluentfom/guten-block',
    ];

    $template = [
        ['core/heading', [
            'level' => 2,
            'placeholder' => 'Add a heading',
        ]],
        ['core/paragraph', [
            'placeholder' => 'Add supporting text',
        ]],
    ];

    $anchorId = $a['anchor'] ?? $b['anchor'] ?? '';

    // overflow-hidden breaks background-attachment:fixed — skip it with a bg image.
    $sectionClasses = trim(implode(' ', array_filter([
        'relative px-clamp bs-block mpx-one-column-section',
        $hasBackgroundImage ? 'has-bg-image' : 'overflow-hidden',
        $bgClass,
        $paddingClasses,
    ])));
@endphp

<section
    useBlockProps
    @if ($anchorId !== '') id="{{ $anchorId }}" @endif
    class="{{ $sectionClasses }}"
>
    @if ($hasBackgroundImage && $backgroundImageUrl)
        <div
            class="mpx-one-column__media"
            style="background-image: url('{{ esc_url($backgroundImageUrl) }}')"
            aria-hidden="true"
        ></div>
        @if ($useBackgroundOverlay)
            <div class="mpx-one-column__scrim" aria-hidden="true"></div>
        @endif
    @endif

    <div class="{{ $contentClasses }}">
        <InnerBlocks
            allowedBlocks="{!! esc_attr(wp_json_encode($allowedBlocks)) !!}"
            template="{!! esc_attr(wp_json_encode($template)) !!}"
        />
    </div>
</section>
