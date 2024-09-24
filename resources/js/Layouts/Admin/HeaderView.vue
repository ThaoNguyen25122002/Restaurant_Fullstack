<script setup></script>
<template>
    <div
        class="sm:ml-64 fixed top-0 right-0 left-0 shadow-xl bg-slate-50 px-4 py-2 z-30"
    >
        <div class="flex justify-between">
            <div class="flex items-center">
                <div class="hidden sm:block">
                    <label
                        for="default-search"
                        class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white"
                        >Search</label
                    >
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none"
                        >
                            <svg
                                class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                                />
                            </svg>
                        </div>
                        <input
                            type="search"
                            id="default-search"
                            class="block w-[300px] px-1 py-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Search Mockups, Logos..."
                        />
                    </div>
                </div>
            </div>
            <div class="group relative cursor-pointer">
                <div class="flex justify-center items-center gap-2">
                    <div>
                        <h4 class="text-lg">
                            {{ $page.props.auth.user.name }}
                        </h4>
                        <p class="text-sm text-gray-500">Admin</p>
                    </div>
                    <svg
                        class="w-6 h-6 text-gray-800"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M7.119 8h9.762a1 1 0 0 1 .772 1.636l-4.881 5.927a1 1 0 0 1-1.544 0l-4.88-5.927A1 1 0 0 1 7.118 8Z"
                        />
                    </svg>
                </div>
                <ul
                    class="absolute hidden group-hover:block bg-white text-black p-2 shadow-md rounded-md left-[-20%] right-0 top-[100%]"
                >
                    <li
                        class="inline-block py-1 px-2 w-full hover:bg-slate-100"
                    >
                        Profile
                    </li>
                    <Link
                        :href="route('admin.logout')"
                        method="post"
                        as="button"
                        class="inline-block py-1 px-2 w-full hover:bg-slate-100 text-start"
                    >
                        Logout
                    </Link>
                </ul>
            </div>
        </div>
    </div>
</template>
