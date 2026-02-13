<x-filament-panels::page>
    <div class="space-y-6">
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Programming Jokes</h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">A collection of hilarious programming jokes to brighten your day!</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($jokes as $joke)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                {{ ucfirst($joke->type) }}
                            </span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                #{{ $joke->id }}
                            </span>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="setup">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                    {{ $joke->setup }}
                                </h3>
                            </div>
                            
                            <div class="punchline">
                                <div class="bg-gradient-to-r from-green-50 to-blue-50 dark:from-green-900/20 dark:to-blue-900/20 rounded-lg p-4 border-l-4 border-green-400">
                                    <p class="text-green-800 dark:text-green-300 font-medium">
                                        {{ $joke->punchline }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if (empty($jokes))
            <div class="text-center py-12">
                <div class="mx-auto h-12 w-12 text-gray-400">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.009-5.824-2.562M15 6.306a7.962 7.962 0 00-6 0m6 0V4a2 2 0 00-2-2h-2a2 2 0 00-2 2v2.306"/>
                    </svg>
                </div>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No jokes available</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Check back later for some programming humor!</p>
            </div>
        @endif
    </div>
</x-filament-panels::page>
