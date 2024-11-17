@include('subscriptions.header')

<div class="max-w-7xl2 md:container mx-auto">

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
                <h2 class="font-bold text-4xl text-black mb-8">Silver</h2>
                <h3 data-individual="باقة تناسب الأفراد والمنشئات الصغيرة"
                    data-company="باقة تناسب الشركات الصغيرة"
                    class="text-xl font-semibold text-gray-700 mb-4"></h3>
                <p data-monthly="100<span class='text-sm'>SAR</span>"
                    data-annual="1100<span class='text-sm'>SAR</span>"
                    data-company-monthly="150<span class='text-sm'>SAR</span>"
                    data-company-annual="1600<span class='text-sm'>SAR</span>"
                    class="text-3xl font-bold text-black mb-6"></p>
                <button class="mt-6 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 w-full">اشترك الآن</button>
            </div>
            <div>
                <ul class="text-gray-600 space-y-2">
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>نشر حتى 9 إعلانات</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>رسوم الاشتراك معفاة من عمولة البيع أو الإيجار</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>تصوير العقار عالي الدقة ونشره</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>عدد 2 مستخدمين</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>اصدار ترخيص الإعلان (بـ تكاليف)</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>خدمة عملاء مميزة</li>
                </ul>
            </div>
        </div>

        <!-- Gold -->
        <div class="bg-white rounded-lg shadow-md p-6 text-center flex flex-col gap-4">
            <div>
                <h2 class="font-bold text-4xl text-black mb-8">Gold</h2>
                <h3 data-individual="باقة تناسب نمو الأعمال"
                    data-company="باقة تناسب الشركات المتوسطة"
                    class="text-xl font-semibold text-gray-700 mb-4"></h3>
                <p data-monthly="200<span class='text-sm'>SAR</span>"
                    data-annual="2200<span class='text-sm'>SAR</span>"
                    data-company-monthly="300<span class='text-sm'>SAR</span>"
                    data-company-annual="3200<span class='text-sm'>SAR</span>"
                    class="text-3xl font-bold text-black mb-6"></p>
                <button class="mt-6 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 w-full">اشترك الآن</button>
            </div>
            <div>
                <ul class="text-gray-600 space-y-2">
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>نشر حتى 19 إعلانات</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>رسوم الاشتراك معفاة من عمولة البيع أو الإيجار</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>تصوير العقار عالي الدقة ونشره</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>عدد 3 مستخدمين</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>اصدار ترخيص الإعلان (بـ تكاليف)</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>خدمة عملاء مميزة</li>
                </ul>
            </div>
        </div>

        <!-- Diamond -->
        <div class="bg-white rounded-lg shadow-md p-6 text-center flex flex-col gap-4">
            <div>
                <h2 class="font-bold text-4xl text-black mb-8">Diamond</h2>
                <h3 data-individual="باقة تناسب التوسع بالأعمال"
                    data-company="باقة تناسب الشركات الكبيرة"
                    class="text-xl font-semibold text-gray-700 mb-4"></h3>
                <p data-monthly="400<span class='text-sm'>SAR</span>"
                    data-annual="4400<span class='text-sm'>SAR</span>"
                    data-company-monthly="600<span class='text-sm'>SAR</span>"
                    data-company-annual="6400<span class='text-sm'>SAR</span>"
                    class="text-3xl font-bold text-black mb-6"></p>
                <button class="mt-6 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 w-full">اشترك الآن</button>
            </div>
            <div>
                <ul class="text-gray-600 space-y-2">
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span> نشر حتى 29 إعلانات</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span> رسوم الاشتراك معفاة من عمولة البيع أو الإيجار</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span> تصوير العقار عالي الدقة ونشره</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span> عدد 3 مستخدمين</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span> اصدار ترخيص الإعلان (بـ تكاليف)</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span> خدمة عملاء مميزة</li>
                </ul>
            </div>
        </div>

        <!-- VIP -->
        <div class="bg-white rounded-lg shadow-md p-6 text-start lg:col-span-3 flex gap-4">
            <div>
                <h2 class="font-bold text-4xl text-black mb-8">VIP</h2>
                <h3 data-individual="باقة تناسب الأفراد والمنشئات الصغيرة"
                    data-company="باقة تناسب الشركات الفاخرة"
                    class="text-xl font-semibold text-gray-700 mb-4"></h3>
                <p data-monthly="1000<span class='text-sm'>SAR</span>"
                    data-annual="11000<span class='text-sm'>SAR</span>"
                    data-company-monthly="2000<span class='text-sm'>SAR</span>"
                    data-company-annual="22000<span class='text-sm'>SAR</span>"
                    class="text-3xl font-bold text-black mb-6"></p>
                <button class="mt-6 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">اشترك الآن</button>
            </div>
            <div>
                <ul class="text-gray-600 space-y-2">
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>نشر حتى 30 إعلانات واكثر</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>رسوم الاشتراك معفاة من عمولة البيع أو الإيجار</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>تصوير العقار عالي الدقة ونشره</li>
                    <li class="flex items-start gap-1"><span class="text-green-500 mr-2">✔</span>عدد 5 مستخدمين</li>
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
    const packages = document.querySelectorAll('#pricingTable div h3, #pricingTable div p');

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