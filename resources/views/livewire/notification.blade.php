<div class="bg-white/10 col-span-9 rounded-lg p-6">
    <h1 class="font-bold py-4 uppercase">{{ $title }}</h1>
    <div class="w-2/3 py-4">
        <h2>Someone has logged into your account from a new browser/device. If it wasn't you, please change your password. Here is the login information:</h2><br />
        <p>IP: {{ $notification['login_information']['IP'] }}</p>
        <p>City: {{ $notification['login_information']['City'] }}</p>
        <p>State: {{ $notification['login_information']['State'] }}</p>
        <p>FU: {{ $notification['login_information']['FU'] }}</p>
        <p>Country: {{ $notification['login_information']['Country'] }}</p>
        <p>Date: {{ $notification['login_information']['Date'] }}</p>
        <div class="text-left mt-10 pr-[12%]">
            <a href="{{ route('dashboard') }}" class="py-[14px] px-8 bg-gray-700 hover:bg-gray-800 text-white font-bold"><i class="fa-solid fa-arrow-left"></i>&nbsp;Back</a>
        </div>
    </div>
</div>
