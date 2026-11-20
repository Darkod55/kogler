@php
    // Comma-separated list set by the parent block's template rather than
    // edited per instance — `allowedBlocks` is `hidden` in block.json.
    $allowedBlocks = array_filter(array_map('trim', explode(',', $a['allowedBlocks'] ?? '')));

    // Keep newer allows available on older columns saved before they were listed.
    if ($allowedBlocks !== []) {
        $allowedBlocks = array_values(array_unique(array_merge($allowedBlocks, [
            'mpx/partial-checklist',
            'fluentfom/guten-block',
            'core/html',
        ])));
    }

    $bgRaw = $a['bg_colour'] ?? null;
    if (is_array($bgRaw)) {
        $bgValue = trim((string) ($bgRaw['value'] ?? ''));
    } elseif (is_string($bgRaw)) {
        $bgValue = trim($bgRaw);
    } else {
        $bgValue = '';
    }
    $hasBg = $bgValue !== '';

    $columnClasses = trim(implode(' ', array_filter([
        'mpx-partial-column',
        $hasBg ? 'mpx-partial-column--has-bg' : null,
    ])));

    $columnStyle = $hasBg ? '--mpx-column-bg: ' . $bgValue : '';
@endphp

<div
    useBlockProps
    class="{{ $columnClasses }}"
    @if ($columnStyle !== '') style="{{ esc_attr($columnStyle) }}" @endif
>
    <InnerBlocks
        @if (! empty($allowedBlocks))
            allowedBlocks="{!! esc_attr(wp_json_encode(array_values($allowedBlocks))) !!}"
        @endif
    />
</div>
