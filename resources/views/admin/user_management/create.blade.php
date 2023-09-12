<x-app-layout>
    <div class="flex flex-row h-screen">
        <x-side />

        <div class="flex flex-col w-full relative">
            <x-nav />
            <div class="shadow-lg flex-grow bg-white p-10 ml-[40px] mt-[50px] overflow-y-auto">
                <x-add-user />
            </div>
        </div>
    </div>
</x-app-layout>
