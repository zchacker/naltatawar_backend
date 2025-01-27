@include('client.header')

<div class="flex flex-col justify-center self-center  w-full ">
    <h2 class="text-xl font-semibold mb-4 text-gray-800 text-center">{{__('save_card')}}</h2>

    @if(Session::has('errors'))
    <div class="my-3 w-full p-4 flex flex-col gap-0 space-y-2 bg-orange-500 text-white text-sm rounded-md">
        {!! session('errors')->first('error') !!}
    </div>
    @endif

    @if(Session::has('success'))
    <div class="my-3 w-full p-4 flex flex-col gap-0 space-y-2 bg-green-700 text-white text-sm rounded-md">
        {!! session('success') !!}
    </div>
    @endif

    <form id="paymentForm" class="space-y-4 w-full max-w-lg bg-white shadow-md rounded-lg p-6 self-center ">
        
        <div class="gap-2 flex flex-col">
            <label for="holder_name" class="block text-sm font-medium text-gray-700">{{ __('name') }}</label>
            <input type="text" id="holder_name" name="holder_name" placeholder="اسمك على البطاقة"
                class="input w-full focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
        </div>

        <div class="gap-2 flex flex-col">
            <label for="number" class="block text-sm font-medium text-gray-700">{{ __('card_number') }}</label>
            <input type="number" id="number" name="number" placeholder="45xxxxxxxxxxxxx"
                class="input w-full focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
        </div>

        <div class="flex gap-4">
            <div class="flex-1">
                <label for="month" class="block text-sm font-medium text-gray-700">{{__('ex_month')}} (MM)</label>
                <input type="number" max="99" maxlength="2" id="month" name="month" placeholder="12"
                class="input w-full focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
            </div>
            
            <div class="flex-1">
                <label for="year" class="block text-sm font-medium text-gray-700">{{__('ex_year')}} (YY)</label>
                <input type="number" max="99" maxlength="2" id="year" name="year" placeholder="25"
                class="input w-full focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
            </div>
        </div>
        
        <div>
            <label for="cvv" class="block text-sm font-medium text-gray-700">{{__('cvv')}}</label>
            <input type="number" max="9999" maxlength="4" id="cvv" name="cvv" placeholder="***"
                class="input w-full focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
        </div>

        <button type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 rounded-md transition">
            {{ __('save_card') }}
        </button>

        <div id="responseMessage" class="text-sm mt-4 text-center"></div>
    </form>
</div>


<div class="w-[400px] mx-auto py-16 items-center flex flex-col">
    {{--
  <div class="mysr-form"></div>
  <div class="bg-gray-100 w-full py-8 px-2 rounded-md">
    <input type="checkbox" name="save" id="save" />
    <label for="save">هل تريد حفظ البطاقة؟</label>
  </div>
  --}}

</div>

<script>
  
//   function initializeMoyasar(saveCard) {
//     Moyasar.init({
//       element: '.mysr-form',
//       amount: 0,
//       currency: 'SAR',
//       description: "Save Card",
//       publishable_api_key: '{{ env("PAYMENT_PUBLISH_KEY") }}',
//       callback_url: '{{route("payment.callback")}}',
//       methods: ['creditcard'],
//       credit_card: {
//         save_card: saveCard,
//       },
//     });
//   }

//   // Initialize Moyasar with default value (e.g., false)
//   initializeMoyasar(true);

//   // Listen to checkbox changes
//   document.getElementById('save').addEventListener('change', function () {
//     const saveCard = this.checked;
//     initializeMoyasar(saveCard);
//   });
</script>


<script>
    document.getElementById('paymentForm').addEventListener('submit', async (event) => {
        event.preventDefault(); // Prevent form submission

        const callback_url = `{{ route('client.card.callback') }}`;

        const formData = new FormData(event.target);
        const cardDetails = {
            type: 'creditcard',
            name: formData.get('holder_name'),
            number: formData.get('number'),
            cvc: formData.get('cvv'),
            save_only: false,
            month: formData.get('month'),
            year: formData.get('year'),
            callback_url: callback_url
        };

        const apiKey = `{{env('PAYMENT_PUBLISH_KEY')}}`; // Replace with your public API key

        try {
            const response = await fetch('https://api.moyasar.com/v1/tokens', {
                method: 'POST',
                headers: {
                    'Authorization': 'Basic ' + btoa(apiKey + ':'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(cardDetails)
            });

            const responseMessage = document.getElementById('responseMessage');

            if (response.ok) {
                const data = await response.json();                
                window.location.href = `${data.verification_url}`;

                //console.log('Token created:', data);
                //responseMessage.className = 'text-green-600 mt-4';
                //responseMessage.textContent = `Token created successfully: ${data.id}`;
            } else {
                const error = await response.json();
                console.error('Error creating token:', error);
                responseMessage.className = 'text-red-600 mt-4';
                responseMessage.textContent = 'حدث خطأ، الرجاء التأكد من صحة بيانات البطاقة';// `Error: ${error.message}`;
            }
        } catch (error) {
            console.error('Network error:', error);
            const responseMessage = document.getElementById('responseMessage');
            responseMessage.className = 'text-red-600 mt-4';
            responseMessage.textContent = "حدث خطأ بالشبكة أثناء التحقق، حاول مرة أخرى"// 'A network error occurred. Please try again.';
        }
    });
</script>

@include('client.footer')