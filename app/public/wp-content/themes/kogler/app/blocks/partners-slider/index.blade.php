@php
    $sectionPadding = $a['section_padding'] ?? ['p-clamp-y'];
    if (! is_array($sectionPadding)) {
        $sectionPadding = [$sectionPadding];
    }
    $paddingClasses = implode(' ', array_filter($sectionPadding));
    $bgClass = $a['bg_colour']['slug'] ?? 'bg-tertiary';

    $template = [
        ['core/gallery', [
            'linkTo' => 'none',
        ]],
        ['core/paragraph', [
            'align' => 'center',
            'placeholder' => 'Add supporting text',
        ]],
    ];

    $allowedBlocks = ['core/gallery', 'core/heading', 'core/paragraph'];

    $anchorId = $a['anchor'] ?? $b['anchor'] ?? '';
@endphp

<section
    useBlockProps
    @if ($anchorId !== '') id="{{ $anchorId }}" @endif
    class="mpx-partners-slider overflow-x-hidden p-clamp-x bs-block {{ $bgClass }} {{ $paddingClasses }}{{ $isEditor ? ' is-editor' : '' }}"
>
    <div class="container">
        <InnerBlocks
            allowedBlocks="{!! esc_attr(wp_json_encode($allowedBlocks)) !!}"
            template="{!! esc_attr(wp_json_encode($template)) !!}"
        />
    </div>
</section>
