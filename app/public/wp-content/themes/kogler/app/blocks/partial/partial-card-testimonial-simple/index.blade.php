@php
    $parent = $c['mpx/partial-cards'] ?? [];
    $parentGrid = ($parent && function_exists('bs_get_group'))
        ? bs_get_group($parent, 'grid_controls')
        : [];
    $widthStyle = \App\helpers()->resolveGridItemWidthStyle($a, $parentGrid);

    $showRating = (bool) ($a['show_rating'] ?? true);
    $rating = (int) ($a['rating'] ?? 5);
    $rating = max(1, min(5, $rating));

    $allowedBlocks = ['core/paragraph', 'core/heading'];
    $template = [
        ['core/heading', [
            'level' => 4,
            'placeholder' => 'Name',
        ]],
        ['core/paragraph', [
            'placeholder' => 'Role / title (optional)',
            'className' => 'mpx-card__company',
        ]],
        ['core/paragraph', [
            'placeholder' => 'Add the testimonial quote…',
        ]],
    ];
@endphp

<div
    useBlockProps
    class="mpx-card mpx-card--testimonial-simple"
    @if ($widthStyle !== '')
        style="{!! esc_attr($widthStyle) !!}"
    @endif
>
    <span class="mpx-card__quote-mark" aria-hidden="true">
        {!! \App\helpers()->getSvg(['icon' => 'quote', 'width' => 48, 'title' => '']) !!}
    </span>
    <div class="mpx-card__body">
        <InnerBlocks
            allowedBlocks="{!! esc_attr(wp_json_encode($allowedBlocks)) !!}"
            template="{!! esc_attr(wp_json_encode($template)) !!}"
        />
    </div>
    @if ($showRating)
        <div
            class="mpx-card__rating"
            role="img"
            aria-label="{{ esc_attr(sprintf(__('%d out of 5 stars', 'sage'), $rating)) }}"
        >
            @for ($i = 1; $i <= 5; $i++)
                <span class="mpx-card__star{{ $i <= $rating ? ' is-filled' : ' is-empty' }}" aria-hidden="true">
                    {!! \App\helpers()->getSvg([
                        'icon' => $i <= $rating ? 'star-filled' : 'star',
                        'width' => 18,
                        'title' => '',
                    ]) !!}
                </span>
            @endfor
        </div>
    @endif
</div>
