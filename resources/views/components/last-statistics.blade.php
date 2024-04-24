<div id="24h">
    <h1 class="font-bold py-4 uppercase">{{ $title }}</h1>
    <div id="stats" class="grid gird-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($statistics as $stat)
            <div class="bg-black/60 to-white/5 p-6 rounded-lg">
                <div class="flex flex-row space-x-4 items-center">
                    <div id="stats-1">
                        {!! $stat['icon'] !!}
                    </div>
                    <div>
                        <p class="{{ $stat['textColor'] }} text-sm font-medium uppercase leading-4">{{ $stat['name'] }}</p>
                        <p class="text-white font-bold text-2xl inline-flex items-center space-x-2">
                            <span>{{ $stat['number'] }}</span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                                </svg>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>