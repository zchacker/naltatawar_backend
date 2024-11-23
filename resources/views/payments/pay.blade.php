@include('payments.pay_header')

<div class="w-[400px] mx-auto py-16 items-center flex flex-col">
  <div class="mysr-form"></div>
  <div class="bg-gray-100 w-full py-8 px-2 rounded-md">
    <input type="checkbox" name="save" id="save" />
    <label for="save">هل تريد حفظ البطاقة؟</label>
  </div>
</div>

<script>
  
  function initializeMoyasar(saveCard) {
    Moyasar.init({
      element: '.mysr-form',
      amount: `{{ $price }}`,
      currency: 'SAR',
      description: 'اشتراك باقة ' + ' {{ $name }} ',
      publishable_api_key: 'pk_test_xfDnxnDCrLwR6BtmP8sKhpF9rBYc3tQKbvLoDXTJ',
      callback_url: '{{route("payment.callback")}}',
      methods: ['creditcard'],
      credit_card: {
        save_card: saveCard,
      },
    });
  }

  // Initialize Moyasar with default value (e.g., false)
  initializeMoyasar(false);

  // Listen to checkbox changes
  document.getElementById('save').addEventListener('change', function () {
    const saveCard = this.checked;
    initializeMoyasar(saveCard);
  });
</script>

@include('payments.header')