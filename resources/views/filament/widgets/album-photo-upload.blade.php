<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            📸 Upload de Fotos Moderno
        </x-slot>

        <x-slot name="description">
            Arraste e solte múltiplas fotos aqui ou clique para selecionar ficheiros
        </x-slot>

        <div class="modern-upload-container" x-data="modernUpload()">
            <!-- Área de Drop -->
            <div class="drop-zone" 
                 :class="{ 'drag-over': isDragOver, 'uploading': isUploading }"
                 @dragover.prevent="isDragOver = true"
                 @dragleave.prevent="isDragOver = false"
                 @drop.prevent="handleDrop($event)"
                 @click="openFileDialog()">
                
                <div class="drop-content" x-show="!isUploading">
                    <div class="upload-icon">
                        <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                    </div>
                    
                    <div class="upload-text">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            <span x-show="!isDragOver">🎯 Arraste as suas fotos para aqui</span>
                            <span x-show="isDragOver" class="text-blue-600 animate-pulse">✨ Solte as fotos aqui!</span>
                        </h3>
                        <p class="text-gray-600 mb-4 text-lg">
                            ou <span class="text-blue-600 font-semibold cursor-pointer">clique para selecionar ficheiros</span>
                        </p>
                        <div class="upload-info bg-blue-50 p-4 rounded-lg">
                            <div class="flex items-center justify-center space-x-6 text-sm text-gray-600">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                    </svg>
                                    JPG, PNG, GIF, WebP
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    Máx. 10MB por foto
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress -->
                <div class="upload-progress" x-show="isUploading">
                    <div class="progress-content">
                        <svg class="animate-spin w-12 h-12 text-blue-600 mb-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            🚀 A fazer upload...
                        </h3>
                        <p class="text-gray-600 mb-4">
                            <span x-text="uploadedCount"></span> de <span x-text="totalFiles"></span> fotos enviadas
                        </p>
                        <div class="progress-bar">
                            <div class="progress-fill" :style="`width: ${uploadProgress}%`"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preview Grid -->
            <div class="preview-grid" x-show="previewPhotos.length > 0">
                <template x-for="(photo, index) in previewPhotos" :key="photo.id">
                    <div class="preview-item">
                        <div class="preview-image">
                            <img :src="photo.preview" :alt="photo.name" class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="preview-overlay">
                            <div class="photo-info">
                                <span class="photo-name" x-text="photo.name"></span>
                                <span class="photo-size" x-text="photo.size"></span>
                            </div>
                            <button @click="removePhoto(index)" class="remove-btn">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <input type="file" 
                   x-ref="fileInput" 
                   @change="handleFileSelect($event)"
                   multiple 
                   accept="image/*" 
                   class="hidden">

            <!-- Actions -->
            <div class="upload-actions" x-show="previewPhotos.length > 0">
                <button @click="uploadPhotos()" 
                        :disabled="isUploading"
                        class="upload-btn">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <span x-text="isUploading ? 'A enviar...' : `🚀 Enviar ${previewPhotos.length} fotos`"></span>
                </button>
                
                <button @click="clearAll()" 
                        :disabled="isUploading"
                        class="clear-btn">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    🗑️ Limpar tudo
                </button>
            </div>
        </div>

        <style>
        .modern-upload-container {
            @apply w-full;
        }

        .drop-zone {
            @apply border-3 border-dashed border-gray-300 rounded-xl p-12 text-center cursor-pointer transition-all duration-300;
            @apply hover:border-blue-400 hover:bg-blue-50 hover:shadow-lg;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .drop-zone.drag-over {
            @apply border-blue-500 bg-blue-100 shadow-xl;
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            transform: scale(1.02);
        }

        .drop-zone.uploading {
            @apply border-blue-500 bg-blue-50 cursor-not-allowed;
        }

        .drop-content {
            @apply flex flex-col items-center;
        }

        .upload-icon {
            @apply mb-6;
        }

        .upload-text h3 {
            @apply mb-4;
        }

        .upload-info {
            @apply mt-6;
        }

        .upload-progress {
            @apply flex flex-col items-center;
        }

        .progress-content {
            @apply flex flex-col items-center;
        }

        .progress-bar {
            @apply w-full max-w-md bg-gray-200 rounded-full h-3 overflow-hidden shadow-inner;
        }

        .progress-fill {
            @apply bg-gradient-to-r from-blue-500 to-blue-600 h-full transition-all duration-500 ease-out;
        }

        .preview-grid {
            @apply grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4 mt-8;
        }

        .preview-item {
            @apply relative aspect-square rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300;
        }

        .preview-image {
            @apply w-full h-full;
        }

        .preview-overlay {
            @apply absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-60 transition-all duration-300;
            @apply flex flex-col justify-between p-3;
        }

        .photo-info {
            @apply text-white text-sm opacity-0 hover:opacity-100 transition-opacity duration-300;
        }

        .photo-name {
            @apply font-semibold truncate;
        }

        .photo-size {
            @apply text-xs opacity-75;
        }

        .remove-btn {
            @apply self-end bg-red-500 hover:bg-red-600 text-white rounded-full p-2;
            @apply opacity-0 hover:opacity-100 transition-all duration-300 shadow-lg;
        }

        .upload-actions {
            @apply flex gap-4 mt-8 justify-center;
        }

        .upload-btn {
            @apply bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-8 py-4 rounded-xl;
            @apply flex items-center font-semibold transition-all duration-300 shadow-lg hover:shadow-xl;
            @apply disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none;
            @apply hover:scale-105 active:scale-95;
        }

        .clear-btn {
            @apply bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white px-8 py-4 rounded-xl;
            @apply flex items-center font-semibold transition-all duration-300 shadow-lg hover:shadow-xl;
            @apply disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none;
            @apply hover:scale-105 active:scale-95;
        }
        </style>

        <script>
        function modernUpload() {
            return {
                isDragOver: false,
                isUploading: false,
                previewPhotos: [],
                uploadedCount: 0,
                totalFiles: 0,
                uploadProgress: 0,

                openFileDialog() {
                    if (!this.isUploading) {
                        this.$refs.fileInput.click();
                    }
                },

                handleDrop(event) {
                    this.isDragOver = false;
                    const files = Array.from(event.dataTransfer.files);
                    this.processFiles(files);
                },

                handleFileSelect(event) {
                    const files = Array.from(event.target.files);
                    this.processFiles(files);
                },

                processFiles(files) {
                    const imageFiles = files.filter(file => file.type.startsWith('image/'));
                    
                    imageFiles.forEach(file => {
                        if (file.size > 10 * 1024 * 1024) {
                            this.showError(`Ficheiro ${file.name} é muito grande. Tamanho máximo: 10MB`);
                            return;
                        }

                        const reader = new FileReader();
                        reader.onload = (e) => {
                            const photo = {
                                id: Date.now() + Math.random(),
                                file: file,
                                name: file.name,
                                size: this.formatFileSize(file.size),
                                preview: e.target.result
                            };
                            this.previewPhotos.push(photo);
                        };
                        reader.readAsDataURL(file);
                    });

                    this.$refs.fileInput.value = '';
                },

                removePhoto(index) {
                    this.previewPhotos.splice(index, 1);
                },

                clearAll() {
                    this.previewPhotos = [];
                    this.uploadedCount = 0;
                    this.uploadProgress = 0;
                },

                async uploadPhotos() {
                    if (this.previewPhotos.length === 0) return;

                    this.isUploading = true;
                    this.totalFiles = this.previewPhotos.length;
                    this.uploadedCount = 0;

                    const formData = new FormData();
                    formData.append('album_id', '{{ $this->record->id }}');
                    
                    this.previewPhotos.forEach((photo, index) => {
                        formData.append(`photos[${index}]`, photo.file);
                    });

                    try {
                        const response = await fetch('{{ route("photos.store") }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });

                        if (response.ok) {
                            const result = await response.json();
                            this.showSuccess(`🎉 Sucesso! ${result.count} fotos foram adicionadas ao álbum.`);
                            this.clearAll();
                            
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            throw new Error('Erro no upload');
                        }
                    } catch (error) {
                        this.showError('❌ Erro ao fazer upload das fotos. Tente novamente.');
                    } finally {
                        this.isUploading = false;
                    }
                },

                formatFileSize(bytes) {
                    if (bytes === 0) return '0 Bytes';
                    const k = 1024;
                    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
                },

                showSuccess(message) {
                    $wire.dispatch('notify', {
                        type: 'success',
                        message: message
                    });
                },

                showError(message) {
                    $wire.dispatch('notify', {
                        type: 'error',
                        message: message
                    });
                }
            }
        }
        </script>
    </x-filament::section>
</x-filament-widgets::widget>
