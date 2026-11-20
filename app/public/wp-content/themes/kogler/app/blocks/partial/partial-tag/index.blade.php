@php
    $allowedBlocks = ['core/paragraph'];
    $template = [
        ['core/paragraph', [
            'placeholder' => 'Tag…',
        ]],
    ];
@endphp

<li useBlockProps class="mpx-tag">
    <div class="mpx-tag__body">
        <InnerBlocks
            allowedBlocks="{!! esc_attr(wp_json_encode($allowedBlocks)) !!}"
            template="{!! esc_attr(wp_json_encode($template)) !!}"
            templateLock="false"
        />
    </div>
</li>
