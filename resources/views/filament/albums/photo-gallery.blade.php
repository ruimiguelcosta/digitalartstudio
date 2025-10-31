<div 
    x-data="{
        currentIndex: {{ $currentIndex }},
        photos: {{ json_encode($photos) }},
        albumId: {{ json_encode($albumId) }},
        currentOffset: {{ $currentOffset }},
        totalPhotos: {{ $totalPhotos }},
        isLoading: false,
        hasMore: {{ ($currentOffset < $totalPhotos) ? 'true' : 'false' }},
        startX: 0,
        currentX: 0,
        isDragging: false,
        async loadMorePhotos() {
            if (this.isLoading || !this.hasMore) {
                return;
            }
            
            this.isLoading = true;
            
            try {
                const csrfToken = document.querySelector('meta[name=csrf-token]')?.getAttribute('content');
                const response = await fetch('{{ url('/api/photos/load-more') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        album_id: this.albumId,
                        offset: this.currentOffset,
                    }),
                });
                
                const data = await response.json();
                
                if (data.photos && data.photos.length > 0) {
                    this.photos = [...this.photos, ...data.photos];
                    this.currentOffset += data.photos.length;
                    this.hasMore = data.has_more;
                } else {
                    this.hasMore = false;
                }
            } catch (error) {
                console.error('Erro ao carregar mais fotos:', error);
                this.hasMore = false;
            } finally {
                this.isLoading = false;
            }
        },
        async checkAndLoadMore() {
            if (this.photos && Array.isArray(this.photos) && this.photos.length > 0) {
                const remaining = this.photos.length - this.currentIndex;
                if (remaining <= 3 && this.hasMore && !this.isLoading) {
                    await this.loadMorePhotos();
                }
            }
        },
        goToNext() {
            if (this.photos && Array.isArray(this.photos) && this.photos.length > 0) {
                if (this.currentIndex < this.photos.length - 1) {
                    this.currentIndex++;
                    this.checkAndLoadMore();
                } else if (this.hasMore) {
                    this.checkAndLoadMore();
                } else {
                    this.currentIndex = 0;
                }
            }
        },
        goToPrev() {
            if (this.photos && Array.isArray(this.photos) && this.photos.length > 0) {
                if (this.currentIndex > 0) {
                    this.currentIndex--;
                } else {
                    this.currentIndex = this.photos.length - 1;
                }
            }
        },
        handleClick(e) {
            if (this.isDragging) {
                return;
            }
            const rect = e.currentTarget.getBoundingClientRect();
            const clickX = e.clientX - rect.left;
            const width = rect.width;
            
            if (clickX < width / 3) {
                this.goToPrev();
            } else if (clickX > width * 2 / 3) {
                this.goToNext();
            }
        },
        startDrag(e) {
            this.isDragging = false;
            this.startX = e.type === 'touchstart' ? e.touches[0].clientX : e.clientX;
        },
        doDrag(e) {
            if (!this.startX) return;
            this.isDragging = true;
            this.currentX = e.type === 'touchmove' ? e.touches[0].clientX : e.clientX;
        },
        endDrag(e) {
            if (!this.startX) return;
            const endX = e.type === 'touchend' ? (e.changedTouches ? e.changedTouches[0].clientX : this.currentX) : e.clientX;
            const diff = this.startX - endX;
            
            if (Math.abs(diff) > 50) {
                if (diff > 0) {
                    this.goToNext();
                } else {
                    this.goToPrev();
                }
            }
            
            this.startX = 0;
            this.currentX = 0;
            setTimeout(() => { this.isDragging = false; }, 100);
        }
    }"
    x-init="checkAndLoadMore()"
    x-on:keydown.left.window="goToPrev()"
    x-on:keydown.right.window="goToNext()"
>
    <div class="relative bg-black min-h-[600px] flex items-center justify-center overflow-hidden">
        <template x-if="photos && Array.isArray(photos) && photos.length > 0">
            <div class="relative w-full h-full flex items-center justify-center">
                <div 
                    class="flex items-center justify-center p-8 cursor-pointer select-none relative z-10"
                    x-on:click="handleClick($event)"
                    x-on:mousedown="startDrag($event)"
                    x-on:mousemove="doDrag($event)"
                    x-on:mouseup="endDrag($event)"
                    x-on:mouseleave="endDrag($event)"
                    x-on:touchstart="startDrag($event)"
                    x-on:touchmove="doDrag($event)"
                    x-on:touchend="endDrag($event)"
                >
                    <template x-for="(photo, index) in photos" :key="photo.id || index">
                        <div 
                            x-show="currentIndex === index"
                            class="flex items-center justify-center w-full h-full"
                            :style="startX && isDragging ? 'transform: translateX(' + (currentX - startX) + 'px);' : ''"
                            x-transition:enter="transition ease-out duration-400"
                            x-transition:enter-start="opacity-0 transform translate-x-full"
                            x-transition:enter-end="opacity-100 transform translate-x-0"
                            x-transition:leave="transition ease-in duration-400"
                            x-transition:leave-start="opacity-100 transform translate-x-0"
                            x-transition:leave-end="opacity-0 transform -translate-x-full"
                        >
                            <img 
                                :src="photo.url"
                                :alt="photo.original_filename || 'Foto'"
                                class="max-w-full max-h-[85vh] object-contain pointer-events-none"
                                draggable="false"
                            >
                        </div>
                    </template>
                </div>

                <template x-if="totalPhotos > 1">
                    <button 
                        x-on:click.stop.prevent="goToPrev()"
                        class="absolute left-8 top-1/2 -translate-y-1/2 bg-white/50 hover:bg-white/70 active:bg-white/90 text-black p-6 rounded-full transition-all duration-200 hover:scale-125 active:scale-100 shadow-2xl cursor-pointer border-4 border-white min-w-[70px] min-h-[70px] flex items-center justify-center z-[9999]"
                        type="button"
                        aria-label="Foto anterior"
                    >
                        <svg class="w-14 h-14 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>

                    <button 
                        x-on:click.stop.prevent="goToNext()"
                        class="absolute right-8 top-1/2 -translate-y-1/2 bg-white/50 hover:bg-white/70 active:bg-white/90 text-black p-6 rounded-full transition-all duration-200 hover:scale-125 active:scale-100 shadow-2xl cursor-pointer border-4 border-white min-w-[70px] min-h-[70px] flex items-center justify-center z-[9999]"
                        type="button"
                        aria-label="Próxima foto"
                    >
                        <svg class="w-14 h-14 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </template>

                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 bg-black/70 backdrop-blur-sm text-white px-6 py-3 rounded-full shadow-lg pointer-events-none z-50">
                    <span x-text="`${currentIndex + 1} / ${totalPhotos}`" class="text-sm font-medium"></span>
                </div>
            </div>
        </template>
        
        <template x-if="!photos || !Array.isArray(photos) || photos.length === 0">
            <div class="flex items-center justify-center h-full">
                <p class="text-white text-lg">Nenhuma foto disponível</p>
            </div>
        </template>
    </div>
</div>

