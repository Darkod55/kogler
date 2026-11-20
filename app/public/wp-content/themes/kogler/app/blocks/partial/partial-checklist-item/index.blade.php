@php
    $allowedBlocks = ['core/paragraph'];
    $template = [
        ['core/paragraph', [
            'placeholder' => 'Add list item…',
        ]],
    ];
@endphp

<li useBlockProps class="mpx-checklist__item">
    <span class="mpx-checklist__icon" aria-hidden="true">
        {!! \App\helpers()->getSvg(['icon' => 'check', 'width' => 14, 'title' => '']) !!}
    </span>
    <div class="mpx-checklist__body">
        <InnerBlocks
            allowedBlocks="{!! esc_attr(wp_json_encode($allowedBlocks)) !!}"
            template="{!! esc_attr(wp_json_encode($template)) !!}"
            templateLock="false"
        />
    </div>
</li>
