@include('payments.pay_header')

<div class="max-w-7xl2 md:container mx-auto py-16">
  <div class="mysr-form"></div>
</div>

<script>
  
  Moyasar.init({
    element: '.mysr-form',
    // Amount in the smallest currency unit.
    // For example:
    // 10 SAR = 10 * 100 Halalas
    // 10 KWD = 10 * 1000 Fils
    // 10 JPY = 10 JPY (Japanese Yen does not have fractions)
    amount: `{{ $price }}`,
    currency: 'SAR',
    description: 'اشتراك باقة ' + ' {{ $name }} ',
    publishable_api_key: 'pk_test_xfDnxnDCrLwR6BtmP8sKhpF9rBYc3tQKbvLoDXTJ',
    callback_url: 'https://moyasar.com/thanks',
    methods: ['creditcard']
  })
</script>

@include('payments.header')