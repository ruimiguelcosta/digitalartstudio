<div 
    x-data="{
        currentIndex: {{ $currentIndex }},
        photos: @js($photos),
        goToNext() {
            if (this.currentIndex < this.photos.length - 1) {
                this.currentIndex++;
            } else {
                this.currentIndex = 0;
            }
        },
        goToPrev() {
            if (this.currentIndex > 0) {
                this.currentIndex--;
            } else {
                this.currentIndex = this.photos.length - 1;
            }
        },
        goToPhoto(index) {
            this.currentIndex = index;
        }
    }"
    x-on:keydown.left.window="goToPrev()"
    x-on:keydown.right.window="goToNext()"
>
    <div class="relative bg-black min-h-[500px] flex items-center justify-center">
        @if(count($photos) > 0)
            <div class="absolute inset-0 flex items-center justify-center p-4">
                <template x-for="(photo, index) in photos" :key="index">
                    <img 
                        x-show="currentIndex === index"
                        :src="photo.url"
                        :alt="photo.original_filename || 'Foto'"
                        class="max-w-full max-h-[80vh] object-contain"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                    >
                </template>
            </div>

            @if(count($photos) > 1)
                <button 
                    @click="goToPrev()"
                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/30 text-white p-3 rounded-full transition z-10"
                    type="button"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>

                <button 
                    @click="goToNext()"
                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/30 text-white p-3 rounded-full transition z-10"
                    type="button"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 bg-black/50 text-white px-4 py-2 rounded z-10">
                    <span x-text="`${currentIndex + 1} / ${photos.length}`"></span>
                </div>

                <div class="absolute bottom-20 left-1/2 -translate-x-1/2 flex gap-2 max-w-full overflow-x-auto px-4 pb-2 z-10">
                    <template x-for="(photo, index) in photos" :key="index">
                        <button
                            @click="goToPhoto(index)"
                            class="flex-shrink-0 w-20 h-20 rounded overflow-hidden border-2 transition"
                            :class="currentIndex === index ? 'border-white' : 'border-transparent opacity-60 hover:opacity-100'"
                            type="button"
                        >
                            <img 
                                :src="photo.url"
                                :alt="photo.original_filename || 'Foto'"
                                class="w-full h-full object-cover"
                            >
                        </button>
                    </template>
                </div>
            @else
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 bg-black/50 text-white px-4 py-2 rounded z-10">
                    <span>1 / 1</span>
                </div>
            @endif
        @else
            <p class="text-white">Nenhuma foto disponível</p>
        @endif
    </div>
</div>

