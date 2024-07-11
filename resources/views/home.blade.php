<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div x-data="app" @map-loaded.window="addAllMarkers()" @auth@map-clicked.window="addMarker()"@endauth>
                      <div id="map" style="width: 100%; height: 600px"></div>
                        <div
                            class="fixed inset-0 z-30 flex items-center justify-center overflow-auto bg-black bg-opacity-50"
                            x-show="modalShow"
                        >
                            <!-- Modal inner -->
                            <div
                                class="max-w-3xl px-6 py-4 mx-auto text-left bg-white rounded shadow-lg"
                                @click.away="modalShow = false"
                            >
                                <!-- Title / Close-->
                                <div class="flex items-center justify-between">
                                    <h5 class="mr-3 text-black max-w-none">Добавить маркер на карту</h5>

                                    <button type="button" class="z-50 cursor-pointer" @click="modalShow = false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <div>
                                    <form method="POST" @submit.prevent="submitForm()" id="addMarker">
                                        <div>
                                            <x-input-label for="title" value="Заголовок" />
                                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="body" value="Сообщение" />
                                            <x-text-input id="body" class="block mt-1 w-full" type="text" name="body" :value="old('body')" required />
                                            <x-input-error :messages="$errors->get('body')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-text-input id="longitude" class="block mt-1 w-full" type="hidden" name="longitude" :value="old('longitude')" required />
                                        </div>
                                        <div>
                                            <x-text-input id="latitude" class="block mt-1 w-full" type="hidden" name="latitude" :value="old('latitude')" required />
                                        </div>
                                        <div class="flex items-center justify-end mt-4">
                                            <x-secondary-button @click="modalShow = false">
                                                Отмена
                                            </x-secondary-button>

                                            <x-primary-button class="ms-3">
                                                Добавить
                                            </x-primary-button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
