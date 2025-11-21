<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Profile Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Profile Information</h3>
                    
                    <!-- Avatar -->
                    <div class="flex justify-center mb-4">
                        <div class="relative">
                            <img class="h-24 w-24 rounded-full object-cover border-4 border-gray-200" 
                                 src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF" 
                                 alt="{{ Auth::user()->name }}">
                            <span class="absolute bottom-0 right-0 block h-6 w-6 rounded-full bg-green-400 border-2 border-white"></span>
                        </div>
                    </div>

                    <!-- User Details -->
                    <div class="text-center mb-4">
                        <h4 class="text-xl font-bold text-gray-900">{{ Auth::user()->name }}</h4>
                        <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                    </div>

                    <div class="border-t border-gray-200 pt-4 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Member Since</span>
                            <span class="text-sm font-medium text-gray-900">{{ Auth::user()->created_at->format('M Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Account Status</span>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Last Login</span>
                            <span class="text-sm font-medium text-gray-900">{{ now()->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <div class="mt-6 space-y-3">
                        <a href="{{ route('profile.edit') }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Edit Profile
                        </a>
                        <a href="{{ route('articles.index') }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Liste des articles
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>