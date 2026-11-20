@php
    $allowedBlocks = ['core/paragraph'];
    $template = [
        ['core/paragraph', [
            'placeholder' => 'Add a subheading…',
        ]],
    ];
@endphp

<div useBlockProps class="mpx-subheading">
    <InnerBlocks
        allowedBlocks="{!! esc_attr(wp_json_encode($allowedBlocks)) !!}"
        template="{!! esc_attr(wp_json_encode($template)) !!}"
        templateLock="false"
    />
</div>
