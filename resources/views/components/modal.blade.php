@props(['title', 'name'])

<!-- Main modal -->
<div
    x-data="{ show: false, title: '', name: '{{$name}}' }"
    x-show="show"
    class="fixed z-50 inset-0"
    style="display: none;"
    x-on:open-modal.window="title = $event.detail.title; show = ($event.detail.name === name)"
    x-on:close-modal.window="show = false"
    x-on:keydown.escape.window="show = false"
    x-on:close.stop="show = false"
    x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
>

        {{--Gray Background--}}
    <div x-on:click="show = false"
         {{--class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"--}}
         class="fixed inset-0 dark:bg-gray-900 opacity-75"
    ></div>

    {{--Modal Component--}}
    <div
        class="p-5 mb-6 mt-24 bg-white dark:bg-gray-700 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-2xl sm:mx-auto"
    >
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                {{--@isset($title)--}}
                <h3 x-text="title" class="text-lg font-semibold text-gray-900 dark:text-white"></h3>
                {{--@endisset--}}
                <button x-on:click="$dispatch('close-modal', 'updateUser')" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            {{ $body }}
        </div>
    </div>
</div>
