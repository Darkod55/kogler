@php
    $allowedBlocks = ['mpx/partial-tag'];
    $template = [
        ['mpx/partial-tag', [], [
            ['core/paragraph', [
                'content' => 'Truck Mattresses',
                'placeholder' => 'Tag…',
            ]],
        ]],
        ['mpx/partial-tag', [], [
            ['core/paragraph', [
                'content' => 'Pillows',
                'placeholder' => 'Tag…',
            ]],
        ]],
        ['mpx/partial-tag', [], [
            ['core/paragraph', [
                'content' => 'RV Mattresses',
                'placeholder' => 'Tag…',
            ]],
        ]],
    ];
@endphp

<ul useBlockProps class="mpx-tags">
    <InnerBlocks
        allowedBlocks="{!! esc_attr(wp_json_encode($allowedBlocks)) !!}"
        template="{!! esc_attr(wp_json_encode($template)) !!}"
    />
</ul>
