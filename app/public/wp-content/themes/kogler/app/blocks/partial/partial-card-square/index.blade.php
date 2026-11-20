@php
    $parent = $c['mpx/partial-cards'] ?? [];
    $parentGrid = ($parent && function_exists('bs_get_group'))
        ? bs_get_group($parent, 'grid_controls')
        : [];
    $widthStyle = \App\helpers()->resolveGridItemWidthStyle($a, $parentGrid);

    $image = $a['square_image'] ?? null;
    $imageId = (int) ($image['ID'] ?? $image['id'] ?? 0);
    $hasImage = $imageId > 0;

    $clampPositionAxis = static function ($value, float $fallback): float {
        if ($value === '' || $value === null) {
            return $fallback;
        }

        return max(0, min(100, (float) $value));
    };

    $posX = $clampPositionAxis($a['image_position_x'] ?? 50, 50);
    $posY = $clampPositionAxis($a['image_position_y'] ?? 50, 50);

    $link = is_array($a['link'] ?? null) ? $a['link'] : [];
    $href = trim((string) ($link['url'] ?? $link['href'] ?? ''));
    $linkTitle = trim((string) ($link['title'] ?? ''));
    $opensNewTab = ! empty($link['opensInNewTab'])
        || (($link['target'] ?? '') === '_blank');
    $hasLink = $href !== '';
    $isEditorView = (bool) ($isEditor ?? false);

    $styleParts = array_filter([
        $widthStyle,
        '--mpx-card-square-pos: ' . $posX . '% ' . $posY . '%',
    ]);
    $styleAttr = implode('; ', $styleParts);

    $ariaLabel = $linkTitle !== ''
        ? $linkTitle
        : trim((string) ($image['alt'] ?? ''));
@endphp

<div
    useBlockProps
    class="mpx-card mpx-card--square{{ $hasImage ? ' has-image' : '' }}"
    @if ($styleAttr !== '')
        style="{!! esc_attr($styleAttr) !!}"
    @endif
>
    @if ($hasImage)
        {!! wp_get_attachment_image($imageId, 'large', false, [
            'class' => 'mpx-card--square__image',
            'alt' => ($hasLink && ! $isEditorView) ? '' : ($image['alt'] ?? ''),
            'loading' => 'lazy',
        ]) !!}
    @elseif ($isEditorView)
        <div class="mpx-card--square__placeholder">
            {{ __('Select a square image in the block sidebar.', 'sage') }}
        </div>
    @endif

    @if ($hasLink && ! $isEditorView)
        <a
            class="mpx-card--square__link"
            href="{!! esc_url($href) !!}"
            @if ($opensNewTab)
                target="_blank"
                rel="noopener noreferrer"
            @endif
            aria-label="{!! esc_attr($ariaLabel !== '' ? $ariaLabel : __('View details', 'sage')) !!}"
        ></a>
    @endif
</div>
