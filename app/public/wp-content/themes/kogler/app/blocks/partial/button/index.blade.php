@php
    $allowedBlocks = ['core/button', 'core/buttons'];
    $template = [
        ['core/button', [
            'blockstudio' => [
                'attributes' => [
                    'button_type' => 'btn-primary',
                ],
            ],
        ]],
    ];
@endphp

@if($isEditor || $isPreview)
  <div useBlockProps>
      <InnerBlocks
          allowedBlocks="{!! esc_attr(wp_json_encode($allowedBlocks)) !!}"
          template="{!! esc_attr(wp_json_encode($template)) !!}"
      />
  </div>
@else
  <InnerBlocks
      allowedBlocks="{!! esc_attr(wp_json_encode($allowedBlocks)) !!}"
      template="{!! esc_attr(wp_json_encode($template)) !!}"
  />
@endif
