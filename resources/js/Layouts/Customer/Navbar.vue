<script setup>
import { ref } from "vue";

const open = ref(false);
const navLinks = [
    {
        href: "/",
        name: "Home",
    },
    {
        href: "/menus",
        name: "Menus",
    },
    {
        href: "/about",
        name: "About",
    },
    {
        href: "/contact",
        name: "Contact",
    },
];

const handleClick = () => {
    open.value = !open.value;
};

const handleClose = () => {
    open.value = false;
};
</script>

<template>
    <nav
        class="w-full h-[8ch] bg-neutral-50 flex items-center md:flex-row lg:px-28 md:px-16 sm:px-7 px-4 fixed top-0 z-50 shadow"
    >
        <!-- Logo KFC -->
        <Link
            href="/"
            class="text-2xl text-neutral-800 font-bold mr-16 shrink-0"
        >
            <img :src="'/storage/Logo/logokfc.png'" alt="" class="h-16" />
        </Link>

        <!-- Toggle Button (only visible on small screens) -->
        <button
            @click="handleClick"
            class="flex-1 md:hidden text-neutral-600 flex items-center justify-end"
        >
            <svg
                v-if="!open"
                class="text-xl text-gray-800"
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
                    stroke-width="2"
                    d="M5 7h14M5 12h14M5 17h14"
                />
            </svg>
            <svg
                v-else
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
                    d="M6 18 17.94 6M18 18 6.06 6"
                />
            </svg>
        </button>

        <!-- Nav Links -->
        <div
            class="flex-1 md:flex flex-col md:flex-row gap-x-5 gap-y-2 md:items-center md:p-0 sm:p-4 p-4 justify-between md:bg-transparent bg-neutral-100 md:shadow-none shadow-md rounded-md"
            :class="[
                open
                    ? 'flex absolute top-[72px] left-0 w-full h-auto md:h-auto md:relative'
                    : 'hidden',
                'lg:flex',
            ]"
        >
            <ul
                class="list-none flex md:items-center items-center md:flex-row flex-col text-base text-neutral-600 font-medium flex-wrap md:flex-nowrap"
            >
                <Link
                    @click="handleClose"
                    :href="link.href"
                    class="hover:bg-red-200 hover:text-slate-100 ease-in-out duration-300 py-3 px-3 rounded-md"
                    v-for="link in navLinks"
                    :key="link.name"
                >
                    {{ link.name }}
                </Link>
            </ul>
            <div
                class="flex md:items-center items-center gap-x-5 gap-y-2 flex-wrap md:flex-row flex-col text-base font-medium text-neutral-800 shrink-0"
            >
                <div
                    class="max-w-72 px-3 py-1.5 rounded-full border border-neutral-400/70 bg-transparent flex items-center gap-x-2 shrink-0"
                >
                    <svg
                        class="size-3.5 text-gray-800"
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
                            stroke-width="2"
                            d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"
                        />
                    </svg>
                    <input
                        type="text"
                        placeholder="Search Foods..."
                        class="flex-1 bg-transparent outline-none text-base text-neutral-800 font-normal placeholder:text-neutral-400/80"
                    />
                </div>
                <button class="relative shrink-0">
                    <svg
                        class="size-7 text-gray-800"
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
                            d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"
                        />
                    </svg>
                    <div
                        class="absolute -top-2 -right-2.5 bg-red-400 text-white rounded-full text-xs p-2 py-0.5 flex items-center justify-center"
                    >
                        0
                    </div>
                </button>

                <a v-if="false"> Đăng nhập </a>
                <div v-else class="relative group shrink-0 cursor-pointer">
                    <div class="flex items-center gap-1">
                        <span class="py-2">Cong Thao</span>
                        <svg
                            class="size-4 text-gray-800 group-hover:rotate-180 transition-all duration-200"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.575 13.729C4.501 15.033 5.43 17 7.12 17h9.762c1.69 0 2.618-1.967 1.544-3.271l-4.881-5.927a2 2 0 0 0-3.088 0l-4.88 5.927Z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>

                    <ul
                        class="absolute hidden group-hover:block -left-12 right-0 shadow-md rounded-sm cursor-pointer z-30 bg-white font-normal"
                    >
                        <li
                            class="inline-block cursor-pointer w-full rounded-md py-2 px-4 hover:bg-slate-100 hover:text-green-600"
                        >
                            Tài Khoản
                        </li>
                        <li
                            class="inline-block cursor-pointer w-full rounded-md py-2 px-4 hover:bg-slate-100 hover:text-green-600"
                        >
                            Đơn Hàng
                        </li>
                        <li
                            class="inline-block cursor-pointer w-full rounded-md py-2 px-4 hover:bg-slate-100 hover:text-green-600"
                        >
                            Đăng Xuất
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</template>
