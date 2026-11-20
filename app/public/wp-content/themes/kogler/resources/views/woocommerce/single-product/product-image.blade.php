{{--
  Single Product Image + Alpine thumbnail slider.

  Thumbs sit outside `.woocommerce-product-gallery` so FlexSlider’s
  viewport append (which moves the wrapper to the end of the gallery)
  cannot reorder them above the main image, and so FlexSlider touch
  handlers on the gallery do not swallow thumb clicks.

  @see https://woocommerce.com/document/template-structure/
  @version 10.5.0
--}}

@php
  use Automattic\WooCommerce\Enums\ProductType;

  defined('ABSPATH') || exit;

  if (! function_exists('wc_get_gallery_image_html')) {
    return;
  }

  global $product;

  $columns = apply_filters('woocommerce_product_thumbnails_columns', 4);
  $post_thumbnail_id = $product->get_image_id();
  $wrapper_classes = apply_filters('woocommerce_single_product_image_gallery_classes', [
    'woocommerce-product-gallery',
    'woocommerce-product-gallery--' . ($post_thumbnail_id ? 'with-images' : 'without-images'),
    'woocommerce-product-gallery--columns-' . absint($columns),
    'images',
  ]);

  $gallery_attachment_ids = $product->get_gallery_image_ids();
  $thumb_ids = [];

  if ($post_thumbnail_id) {
    $thumb_ids[] = (int) $post_thumbnail_id;
  }

  foreach ($gallery_attachment_ids as $attachment_id) {
    $thumb_ids[] = (int) $attachment_id;
  }

  $thumb_ids = array_values(array_unique(array_filter($thumb_ids)));
@endphp

<div class="mpx-product-gallery">
  <div
    class="{{ esc_attr(implode(' ', array_map('sanitize_html_class', $wrapper_classes))) }}"
    data-columns="{{ esc_attr($columns) }}"
    style="opacity: 0; transition: opacity .25s ease-in-out;"
  >
    <div class="woocommerce-product-gallery__wrapper">
      @php
        if ($post_thumbnail_id) {
          $html = wc_get_gallery_image_html($post_thumbnail_id, true);
        } else {
          $wrapper_classname = $product->is_type(ProductType::VARIABLE) && ! empty($product->get_visible_children()) && '' !== $product->get_price()
            ? 'woocommerce-product-gallery__image woocommerce-product-gallery__image--placeholder'
            : 'woocommerce-product-gallery__image--placeholder';
          $html = sprintf('<div class="%s">', esc_attr($wrapper_classname));
          $html .= sprintf(
            '<img src="%s" alt="%s" class="wp-post-image" />',
            esc_url(wc_placeholder_img_src('woocommerce_single')),
            esc_html__('Awaiting product image', 'woocommerce')
          );
          $html .= '</div>';
        }

        echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id);

        do_action('woocommerce_product_thumbnails');
      @endphp
    </div>
  </div>

  @if (count($thumb_ids) > 1)
    <div
      class="mpx-product-thumbs"
      x-data="mpxProductThumbs"
      role="group"
      aria-label="{{ esc_attr__('Product gallery thumbnails', 'sage') }}"
    >
      <button
        type="button"
        class="mpx-product-thumbs__nav mpx-product-thumbs__nav--prev"
        x-on:click="prev"
        :disabled="! canPrev"
        :aria-disabled="(! canPrev).toString()"
        aria-label="{{ esc_attr__('Previous thumbnails', 'sage') }}"
      >
        <span class="mpx-product-thumbs__nav-icon mpx-product-thumbs__nav-icon--prev" aria-hidden="true">
          @svgIcon('arrow-right'|18|18)
        </span>
      </button>

      <div class="mpx-product-thumbs__viewport" x-ref="track" x-on:scroll.passive="updateArrows">
        <div class="mpx-product-thumbs__track">
          @foreach ($thumb_ids as $index => $attachment_id)
            <button
              type="button"
              class="mpx-product-thumbs__item"
              x-on:click.prevent="goTo({{ $index }})"
              :class="{ 'is-active': active === {{ $index }} }"
              :aria-current="active === {{ $index }} ? 'true' : null"
              aria-label="{{ esc_attr(sprintf(__('View image %d', 'sage'), $index + 1)) }}"
            >
              {!! wp_get_attachment_image($attachment_id, 'woocommerce_gallery_thumbnail', false, [
                'class' => 'mpx-product-thumbs__image',
                'loading' => 'lazy',
                'draggable' => 'false',
              ]) !!}
            </button>
          @endforeach
        </div>
      </div>

      <button
        type="button"
        class="mpx-product-thumbs__nav mpx-product-thumbs__nav--next"
        x-on:click="next"
        :disabled="! canNext"
        :aria-disabled="(! canNext).toString()"
        aria-label="{{ esc_attr__('Next thumbnails', 'sage') }}"
      >
        <span class="mpx-product-thumbs__nav-icon" aria-hidden="true">
          @svgIcon('arrow-right'|18|18)
        </span>
      </button>
    </div>
  @endif
</div>
