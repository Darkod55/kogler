{{-- Sprite for editor iframe (layouts also include it on the frontend). --}}
@include('components.footer-icons')

@php
    $allowedBlocks = ['mpx/partial-checklist-item'];
    $template = [
        ['mpx/partial-checklist-item', [], [
            ['core/paragraph', [
                'placeholder' => 'Add list item…',
            ]],
        ]],
        ['mpx/partial-checklist-item', [], [
            ['core/paragraph', [
                'placeholder' => 'Add list item…',
            ]],
        ]],
    ];
@endphp

<ul useBlockProps class="mpx-checklist">
    <InnerBlocks
        allowedBlocks="{!! esc_attr(wp_json_encode($allowedBlocks)) !!}"
        template="{!! esc_attr(wp_json_encode($template)) !!}"
    />
</ul>
