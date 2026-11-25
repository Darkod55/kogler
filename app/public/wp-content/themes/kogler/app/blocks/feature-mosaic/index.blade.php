@php
    $sectionPadding = $a['section_padding'] ?? ['p-clamp-y'];
    if (! is_array($sectionPadding)) {
        $sectionPadding = [$sectionPadding];
    }
    $paddingClasses = implode(' ', array_filter($sectionPadding));
    $bgClass = $a['bg_colour']['slug'] ?? 'bg-white';

    $tile = static function (string $title, string $buttonLabel): array {
        return ['mpx/partial-mosaic-tile', [], [
            ['core/heading', [
                'level' => 3,
                'content' => $title,
                'placeholder' => 'Add a title',
            ]],
            ['mpx/partial-button', [], [
                ['core/button', [
                    'text' => $buttonLabel,
                    'blockstudio' => [
                        'attributes' => [
                            'button_type' => 'btn-secondary',
                        ],
                    ],
                ]],
            ]],
        ]];
    };

    $template = [
        $tile('Best Selling Products', 'Explore Products'),
        $tile('Longest Warranty', 'View More'),
        $tile('Last Chance – SALE', 'Explore Products'),
        $tile('Can\'t find your size?', 'Request Custom Dimensions'),
    ];

    $allowedBlocks = ['mpx/partial-mosaic-tile'];
    $anchorId = $a['anchor'] ?? $b['anchor'] ?? '';

    $sectionClasses = trim(implode(' ', array_filter([
        'relative p-clamp-x bs-block mpx-feature-mosaic',
        $bgClass,
        $paddingClasses,
    ])));
@endphp

<section
    useBlockProps
    @if ($anchorId !== '') id="{{ $anchorId }}" @endif
    class="{{ $sectionClasses }}"
>
    @include('components.footer-icons')

    <div class="container">
        <div class="mpx-feature-mosaic__grid">
            <InnerBlocks
                allowedBlocks="{!! esc_attr(wp_json_encode($allowedBlocks)) !!}"
                template="{!! esc_attr(wp_json_encode($template)) !!}"
                templateLock="insert"
            />
        </div>
    </div>
</section>
