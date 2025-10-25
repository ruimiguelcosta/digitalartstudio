<div class="modern-photo-upload" x-data="photoUpload()">
    <div class="upload-area" 
         :class="{ 'drag-over': isDragOver, 'uploading': isUploading }"
         @dragover.prevent="isDragOver = true"
         @dragleave.prevent="isDragOver = false"
         @drop.prevent="handleDrop($event)"
         @click="openFileDialog()">
        
        <div class="upload-content" x-show="!isUploading">
            <div class="upload-icon">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
            </div>
            
            <div class="upload-text">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                    <span x-show="!isDragOver">Arraste as suas fotos para aqui</span>
                    <span x-show="isDragOver" class="text-blue-600">Solte as fotos aqui!</span>
                </h3>
                <p class="text-gray-600 mb-4">
                    ou clique para selecionar ficheiros
                </p>
                <div class="upload-info">
                    <span class="text-sm text-gray-500">
                        Formatos suportados: JPG, PNG, GIF, WebP
                    </span>
                    <br>
                    <span class="text-sm text-gray-500">
                        Tamanho máximo: 10MB por foto
                    </span>
                </div>
            </div>
        </div>

        <div class="upload-progress" x-show="isUploading">
            <div class="progress-content">
                <svg class="animate-spin w-8 h-8 text-blue-600 mb-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                    A fazer upload...
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

    <div class="photo-preview-grid" x-show="previewPhotos.length > 0">
        <template x-for="(photo, index) in previewPhotos" :key="photo.id">
            <div class="photo-preview-item">
                <div class="photo-preview-image">
                    <img :src="photo.preview" :alt="photo.name" class="w-full h-full object-cover">
                </div>
                <div class="photo-preview-overlay">
                    <div class="photo-info">
                        <span class="photo-name" x-text="photo.name"></span>
                        <span class="photo-size" x-text="photo.size"></span>
                    </div>
                    <button @click="removePhoto(index)" class="remove-btn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

    <div class="upload-actions" x-show="previewPhotos.length > 0">
        <button @click="uploadPhotos()" 
                :disabled="isUploading"
                class="upload-btn">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
            <span x-text="isUploading ? 'A enviar...' : `Enviar ${previewPhotos.length} fotos`"></span>
        </button>
        
        <button @click="clearAll()" 
                :disabled="isUploading"
                class="clear-btn">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
            Limpar tudo
        </button>
    </div>
</div>

<style>
.modern-photo-upload {
    @apply w-full;
}

.upload-area {
    @apply border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer transition-all duration-200;
    @apply hover:border-blue-400 hover:bg-blue-50;
}

.upload-area.drag-over {
    @apply border-blue-500 bg-blue-100;
}

.upload-area.uploading {
    @apply border-blue-500 bg-blue-50 cursor-not-allowed;
}

.upload-content {
    @apply flex flex-col items-center;
}

.upload-icon {
    @apply mb-4;
}

.upload-text h3 {
    @apply mb-2;
}

.upload-info {
    @apply mt-4;
}

.upload-progress {
    @apply flex flex-col items-center;
}

.progress-content {
    @apply flex flex-col items-center;
}

.progress-bar {
    @apply w-full max-w-xs bg-gray-200 rounded-full h-2 overflow-hidden;
}

.progress-fill {
    @apply bg-blue-600 h-full transition-all duration-300 ease-out;
}

.photo-preview-grid {
    @apply grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-6;
}

.photo-preview-item {
    @apply relative aspect-square rounded-lg overflow-hidden shadow-md;
}

.photo-preview-image {
    @apply w-full h-full;
}

.photo-preview-overlay {
    @apply absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-50 transition-all duration-200;
    @apply flex flex-col justify-between p-3;
}

.photo-preview-overlay:hover {
    @apply bg-opacity-50;
}

.photo-info {
    @apply text-white text-sm opacity-0 hover:opacity-100 transition-opacity duration-200;
}

.photo-name {
    @apply font-medium truncate;
}

.photo-size {
    @apply text-xs opacity-75;
}

.remove-btn {
    @apply self-end bg-red-500 hover:bg-red-600 text-white rounded-full p-1;
    @apply opacity-0 hover:opacity-100 transition-opacity duration-200;
}

.upload-actions {
    @apply flex gap-3 mt-6 justify-center;
}

.upload-btn {
    @apply bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg;
    @apply flex items-center font-medium transition-colors duration-200;
    @apply disabled:opacity-50 disabled:cursor-not-allowed;
}

.clear-btn {
    @apply bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg;
    @apply flex items-center font-medium transition-colors duration-200;
    @apply disabled:opacity-50 disabled:cursor-not-allowed;
}
</style>

<script>
function photoUpload() {
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
                    alert(`Ficheiro ${file.name} é muito grande. Tamanho máximo: 10MB`);
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
            formData.append('album_id', '{{ $album->id }}');
            
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
                    this.showSuccess(`Sucesso! ${result.count} fotos foram adicionadas ao álbum.`);
                    this.clearAll();
                    
                    if (window.location.reload) {
                        setTimeout(() => window.location.reload(), 1000);
                    }
                } else {
                    throw new Error('Erro no upload');
                }
            } catch (error) {
                this.showError('Erro ao fazer upload das fotos. Tente novamente.');
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
            if (window.showNotification) {
                window.showNotification(message, 'success');
            } else {
                alert(message);
            }
        },

        showError(message) {
            if (window.showNotification) {
                window.showNotification(message, 'error');
            } else {
                alert(message);
            }
        }
    }
}
</script>
