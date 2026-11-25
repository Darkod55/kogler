{{--
  Checkout form — two columns:
  left: billing + shipping / additional information
  right: order review + payment

  @see https://woocommerce.com/document/template-structure/
  @version 9.4.0
--}}

@php
  do_action('woocommerce_before_checkout_form', $checkout);
@endphp

@if (! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in())
  <p>
    {{ apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')) }}
  </p>
@else
  <form
    name="checkout"
    method="post"
    class="checkout woocommerce-checkout mpx-checkout"
    action="{{ esc_url(wc_get_checkout_url()) }}"
    enctype="multipart/form-data"
    aria-label="{{ esc_attr__('Checkout', 'woocommerce') }}"
  >
    <div class="mpx-checkout__layout">
      <div class="mpx-checkout__primary">
        @if ($checkout->get_checkout_fields())
          @php do_action('woocommerce_checkout_before_customer_details'); @endphp

          <div id="customer_details" class="mpx-checkout__customer">
            <div class="mpx-checkout__billing">
              @php do_action('woocommerce_checkout_billing'); @endphp
            </div>

            <div class="mpx-checkout__shipping">
              @php do_action('woocommerce_checkout_shipping'); @endphp
            </div>
          </div>

          @php do_action('woocommerce_checkout_after_customer_details'); @endphp
        @endif
      </div>

      <div class="mpx-checkout__secondary">
        @php do_action('woocommerce_checkout_before_order_review_heading'); @endphp

        <h3 id="order_review_heading">{{ esc_html__('Your Order', 'woocommerce') }}</h3>

        @php do_action('woocommerce_checkout_before_order_review'); @endphp

        <div id="order_review" class="woocommerce-checkout-review-order">
          @php do_action('woocommerce_checkout_order_review'); @endphp
        </div>

        @php do_action('woocommerce_checkout_after_order_review'); @endphp
      </div>
    </div>
  </form>
@endif

@php
  do_action('woocommerce_after_checkout_form', $checkout);
@endphp
