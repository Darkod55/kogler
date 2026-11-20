@php
    $parent = $c['mpx/partial-cards'] ?? [];
    $parentGrid = ($parent && function_exists('bs_get_group'))
        ? bs_get_group($parent, 'grid_controls')
        : [];
    $widthStyle = \App\helpers()->resolveGridItemWidthStyle($a, $parentGrid);

    $includeIcon = (bool) ($a['include_icon'] ?? true);
    $icon = $a['icon'] ?? 'check';
    if (is_array($icon)) {
        $icon = $icon['value'] ?? 'check';
    }

    $cardClass = 'mpx-card' . ($includeIcon ? ' mpx-card--check' : ' mpx-card--plain');

    $allowedBlocks = ['core/heading', 'core/paragraph', 'mpx/partial-button'];
    $template = [
        ['core/paragraph', [
            'placeholder' => 'Add card text',
        ]],
    ];
@endphp

<div
    useBlockProps
    class="{{ $cardClass }}"
    @if ($widthStyle !== '')
        style="{!! esc_attr($widthStyle) !!}"
    @endif
>
    @if ($includeIcon)
        <span class="mpx-card__icon" aria-hidden="true">
            {!! \App\helpers()->getSvg(['icon' => $icon, 'width' => 16, 'title' => '']) !!}
        </span>
    @endif
    <div class="mpx-card__body">
        <InnerBlocks
            allowedBlocks="{!! esc_attr(wp_json_encode($allowedBlocks)) !!}"
            template="{!! esc_attr(wp_json_encode($template)) !!}"
        />
    </div>
</div>
