<div class="relative inline-block text-left mr-4" onclick="toggleMenu()">
    <div>
        <button type="button"
            class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs hover:bg-gray-50"
            id="menu-button" aria-expanded="true" aria-haspopup="true">
            <p class="line-clamp-1 max-w-80">Hi, {{ Auth::user()->name }} </p>
            <svg class="-mr-1 size-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                data-slot="icon">
                <path fill-rule="evenodd"
                    d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    <div id="menu" style="display:none;"
        class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white ring-1 shadow-lg ring-black/5 focus:outline-hidden"
        role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
        <div class="py-1" role="none">
            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                id="menu-item-0">Account</a>
            <a href="{{ route('user.logout') }}">
                <button
                    class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 outline-hidden"
                    role="menuitem" tabindex="-1" id="menu-item-3">Logout</button>
            </a>
        </div>
    </div>
</div>
