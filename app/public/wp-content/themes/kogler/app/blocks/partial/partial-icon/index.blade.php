@php
    $icon = $a['icon'] ?? 'globe';
    if (is_array($icon)) {
        $icon = $icon['value'] ?? 'globe';
    }
@endphp

<span useBlockProps class="mpx-partial-icon" aria-hidden="true">
    {!! \App\helpers()->getSvg(['icon' => $icon, 'width' => 22, 'title' => '']) !!}
</span>
