@include('subscriptions.header')

<div class="max-w-7xl2 md:container mx-auto pb-16">

    <div class="flex items-center justify-center pt-10 mb-8">
        <img src="{{ asset('imgs/n-logo.png') }}" class="w-[200px]" alt="web site logo">
    </div>

    <div class="my-8 flex items-center justify-center">
        <h2 class="font-bold text-2xl">اختر الباقة التي تريد الاشتراك بها</h2>
    </div>
    <!-- Tabs -->

    <div class="mb-12">
        <div class="flex justify-center gap-4 mb-4">
            <button id="individualTab" class="px-16 py-2 bg-primary text-white rounded-md">الأفراد</button>
            <button id="companyTab" class="px-16 py-2 bg-secondary text-white rounded-md">الشركات</button>
        </div>

        <div class="flex justify-center gap-4 border-b-4 border-b-secondary pb-4">
            <button id="monthlyTab" class="px-8 py-2 bg-primary text-white rounded-md">شهري</button>
            <button id="annualTab" class="px-8 py-2 bg-secondary text-white rounded-md">سنوي</button>
        </div>
    </div>

    <!-- Pricing Table -->
    <div id="pricingTable" class="grid gap-8 lg:grid-cols-3">
        <!-- Silver -->
        <div class="bg-white rounded-lg shadow-md p-6 text-center flex flex-col gap-4">
            <div>
                <h2 class="font-bold text-4xl text-black mb-8">{{$monthly_individual[0]->name}}</h2>
                <h3 data-individual="باقة تناسب الأفراد والمنشئات الصغيرة"
                    data-company="باقة تناسب الشركات الصغيرة"
                    class="text-xl font-semibold text-gray-700 mb-4"></h3>
                <p data-monthly="{{$monthly_individual[0]->price}}<span class='text-sm'>SAR</span>"
                    data-annual="{{$yearly_individual[0]->price}}<span class='text-sm'>SAR</span>"
                    data-company-monthly="{{$monthly_businesses[0]->price}}<span class='text-sm'>SAR</span>"
                    data-company-annual="{{$yearly_businesses[0]->price}}<span class='text-sm'>SAR</span>"
                    class="text-3xl font-bold text-black mb-6"></p>
                <a href="#" 
                    data-monthly="{{$monthly_individual[0]->id}}"
                    data-annual="{{$yearly_individual[0]->id}}"
                    data-company-monthly="{{$monthly_businesses[0]->id}}"
                    data-company-annual="{{$yearly_businesses[0]->id}}"
                    class="mt-6 px-4 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 w-full">اشترك الآن</a>
            </div>
            <div>
                <ul class="text-gray-600 space-y-2">
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>نشر حتى {{$monthly_individual[0]->items}} إعلانات</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>رسوم الاشتراك معفاة من عمولة البيع أو الإيجار</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>تصوير العقار عالي الدقة ونشره</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>عدد {{$monthly_individual[0]->user}} مستخدمين</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>اصدار ترخيص الإعلان (بـ تكاليف)</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>خدمة عملاء مميزة</li>
                </ul>
            </div>
        </div>

        <!-- Gold -->
        <div class="bg-white rounded-lg shadow-md p-6 text-center flex flex-col gap-4">
            <div>
                <h2 class="font-bold text-4xl text-black mb-8">{{$monthly_individual[1]->name}}</h2>
                <h3 data-individual="باقة تناسب نمو الأعمال"
                    data-company="باقة تناسب الشركات المتوسطة"
                    class="text-xl font-semibold text-gray-700 mb-4"></h3>
                <p data-monthly="{{$monthly_individual[1]->price}}<span class='text-sm'>SAR</span>"
                    data-annual="{{$yearly_individual[1]->price}}<span class='text-sm'>SAR</span>"
                    data-company-monthly="{{$monthly_businesses[1]->price}}<span class='text-sm'>SAR</span>"
                    data-company-annual="{{$yearly_businesses[1]->price}}<span class='text-sm'>SAR</span>"
                    class="text-3xl font-bold text-black mb-6"></p>
                <a href="#" 
                    data-monthly="{{$monthly_individual[1]->id}}"
                    data-annual="{{$yearly_individual[1]->id}}"
                    data-company-monthly="{{$monthly_businesses[1]->id}}"
                    data-company-annual="{{$yearly_businesses[1]->id}}"
                    class="mt-6 px-4 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 w-full">اشترك الآن</a>
            </div>
            <div>
                <ul class="text-gray-600 space-y-2">
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>نشر حتى {{$monthly_individual[1]->items}} إعلانات</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>رسوم الاشتراك معفاة من عمولة البيع أو الإيجار</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>تصوير العقار عالي الدقة ونشره</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>عدد {{$monthly_individual[1]->user}} مستخدمين</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>اصدار ترخيص الإعلان (بـ تكاليف)</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>خدمة عملاء مميزة</li>
                </ul>
            </div>
        </div>

        <!-- Diamond -->
        <div class="bg-white rounded-lg shadow-md p-6 text-center flex flex-col gap-4">
            <div class="w-full">
                <h2 class="font-bold text-4xl text-black mb-8">{{$monthly_individual[2]->name}}</h2>
                <h3 data-individual="باقة تناسب التوسع بالأعمال"
                    data-company="باقة تناسب الشركات الكبيرة"
                    class="text-xl font-semibold text-gray-700 mb-4"></h3>
                <p data-monthly="{{$monthly_individual[2]->price}}<span class='text-sm'>SAR</span>"
                    data-annual="{{$yearly_individual[2]->price}}<span class='text-sm'>SAR</span>"
                    data-company-monthly="{{$monthly_businesses[2]->price}}<span class='text-sm'>SAR</span>"
                    data-company-annual="{{$yearly_businesses[2]->price}}<span class='text-sm'>SAR</span>"
                    class="text-3xl font-bold text-black mb-6"></p>
                <a href="#" 
                data-monthly="{{$monthly_individual[2]->id}}"
                data-annual="{{$yearly_individual[2]->id}}"
                data-company-monthly="{{$monthly_businesses[2]->id}}"
                data-company-annual="{{$yearly_businesses[2]->id}}"
                class="mt-6 px-4 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 w-full">اشترك الآن</a>
            </div>
            <div>
                <ul class="text-gray-600 space-y-2">
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span> نشر حتى {{$monthly_individual[2]->items}} إعلانات</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span> رسوم الاشتراك معفاة من عمولة البيع أو الإيجار</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span> تصوير العقار عالي الدقة ونشره</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span> عدد {{$monthly_individual[2]->user}} مستخدمين</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span> اصدار ترخيص الإعلان (بـ تكاليف)</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span> خدمة عملاء مميزة</li>
                </ul>
            </div>
        </div>

        <!-- VIP -->
        <div class="bg-white rounded-lg shadow-md p-6 text-start lg:col-span-3 flex gap-4">
            <div>
                <h2 class="font-bold text-4xl text-black mb-8">{{$monthly_individual[3]->name}}</h2>
                <h3 data-individual="باقة تناسب الأفراد والمنشئات الصغيرة"
                    data-company="باقة تناسب الشركات الفاخرة"
                    class="text-xl font-semibold text-gray-700 mb-4"></h3>
                <p data-monthly="{{$monthly_individual[3]->price}}<span class='text-sm'>SAR</span>"
                    data-annual="{{$yearly_individual[3]->price}}<span class='text-sm'>SAR</span>"
                    data-company-monthly="{{$monthly_businesses[3]->price}}<span class='text-sm'>SAR</span>"
                    data-company-annual="{{$yearly_businesses[3]->price}}<span class='text-sm'>SAR</span>"
                    class="text-3xl font-bold text-black mb-6"></p>
                <a href="#" 
                    data-monthly="{{$monthly_individual[3]->id}}"
                    data-annual="{{$yearly_individual[3]->id}}"
                    data-company-monthly="{{$monthly_businesses[3]->id}}"
                    data-company-annual="{{$yearly_businesses[3]->id}}"
                    class="mt-6 px-4 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 w-full">اشترك الآن</a>
            </div>
            <div>
                <ul class="text-gray-600 space-y-2">
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>نشر حتى {{$monthly_individual[3]->items}} إعلانات واكثر</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>رسوم الاشتراك معفاة من عمولة البيع أو الإيجار</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>تصوير العقار عالي الدقة ونشره</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>عدد {{$monthly_individual[3]->user}} مستخدمين</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>اصدار ترخيص الإعلان (بـ تكاليف)</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>خدمة عملاء مميزة</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    const individualTab = document.getElementById('individualTab');
    const companyTab = document.getElementById('companyTab');
    const monthlyTab = document.getElementById('monthlyTab');
    const annualTab = document.getElementById('annualTab');
    const packages = document.querySelectorAll('#pricingTable div h3, #pricingTable div p, #pricingTable div a');

    let isIndividual = true;
    let isMonthly = true;

    function updateTabs() {
        packages.forEach(pkg => {
            const title = pkg.getAttribute(isIndividual ? 'data-individual' : 'data-company');
            const price = pkg.getAttribute(
                isIndividual ?
                isMonthly ? 'data-monthly' : 'data-annual' :
                isMonthly ? 'data-company-monthly' : 'data-company-annual'
            );
            if (pkg.tagName === 'H3') {
                pkg.textContent = title;
            } else if (pkg.tagName === 'P') {
                pkg.innerHTML = `${price}<span class="text-base font-medium text-gray-500">/${isMonthly ? 'شهرياً' : 'سنويًا'}</span>`;
            } else if (pkg.tagName === 'A') {
                pkg.href = "{{ route('payment.pay', ':price') }}".replace(':price', price);
            }
        });
    }

    function toggleTab(activeTab, inactiveTab, activeClass, inactiveClass) {
        activeTab.classList.add(activeClass);
        activeTab.classList.remove(inactiveClass);
        inactiveTab.classList.add(inactiveClass);
        inactiveTab.classList.remove(activeClass);
    }

    individualTab.addEventListener('click', () => {
        isIndividual = true;
        toggleTab(individualTab, companyTab, 'bg-primary', 'bg-secondary');
        updateTabs();
    });

    companyTab.addEventListener('click', () => {
        isIndividual = false;
        toggleTab(companyTab, individualTab, 'bg-primary', 'bg-secondary');
        updateTabs();
    });

    monthlyTab.addEventListener('click', () => {
        isMonthly = true;
        toggleTab(monthlyTab, annualTab, 'bg-primary', 'bg-secondary');
        updateTabs();
    });

    annualTab.addEventListener('click', () => {
        isMonthly = false;
        toggleTab(annualTab, monthlyTab, 'bg-primary', 'bg-secondary');
        updateTabs();
    });

    updateTabs();
</script>

@include('subscriptions.footer')