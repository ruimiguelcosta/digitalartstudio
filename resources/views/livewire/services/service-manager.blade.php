<div>
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-3xl font-bold tracking-tight">Gestão de Serviços</h1>
                <p class="text-muted-foreground mt-2">Gerir serviços e preços da plataforma</p>
            </div>
            
            <button 
                wire:click="openCreateModal"
                class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium py-2 px-4 rounded-lg shadow-lg transition-all duration-200 inline-flex items-center justify-center"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Novo Serviço
            </button>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    <!-- Services Table -->
    <div class="card-elevated rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-muted/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">
                            Nome
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">
                            Descrição
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">
                            Preço
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($services as $service)
                        <tr class="hover:bg-muted/25 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-foreground">{{ $service->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-muted-foreground max-w-xs truncate">
                                    {{ $service->description ?: 'Sem descrição' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-foreground">
                                    {{ number_format($service->price, 2) }} €
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($service->is_active)
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-green-100 text-green-800">
                                        Ativo
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-red-100 text-red-800">
                                        Inativo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <button 
                                        wire:click="openEditModal({{ $service->id }})"
                                        class="text-blue-600 hover:text-blue-900 transition-colors"
                                        title="Editar serviço"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button 
                                        wire:click="confirmDelete({{ $service->id }})"
                                        class="text-red-600 hover:text-red-900 transition-colors"
                                        title="Excluir serviço"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-muted-foreground">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                    <h3 class="text-lg font-semibold mb-2">Nenhum serviço encontrado</h3>
                                    <p class="mb-4">Comece criando o seu primeiro serviço.</p>
                                    <button 
                                        wire:click="openCreateModal"
                                        class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium py-2 px-4 rounded-lg shadow-lg transition-all duration-200 inline-flex items-center justify-center"
                                    >
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Criar Primeiro Serviço
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($services->hasPages())
            <div class="px-6 py-3 border-t border-border">
                {{ $services->links() }}
            </div>
        @endif
    </div>

    <!-- Create Service Modal -->
    @if($showCreateModal)
        <div class="fixed inset-0 flex items-center justify-center p-4 z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg max-w-md w-full border-2 border-primary shadow-elegant">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Novo Serviço</h2>
                        <button 
                            wire:click="closeCreateModal"
                            class="text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-100"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form wire:submit="createService" class="space-y-4">
                        <div class="space-y-2">
                            <label for="create-name" class="text-sm font-medium leading-none">Nome do Serviço</label>
                            <input
                                id="create-name"
                                wire:model="name"
                                type="text"
                                placeholder="Ex: Fotografia de Evento"
                                required
                                class="input-focus flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                            />
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="create-description" class="text-sm font-medium leading-none">Descrição</label>
                            <textarea
                                id="create-description"
                                wire:model="description"
                                placeholder="Descrição do serviço..."
                                rows="3"
                                class="input-focus flex w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                            ></textarea>
                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="create-price" class="text-sm font-medium leading-none">Preço (€)</label>
                            <input
                                id="create-price"
                                wire:model="price"
                                type="number"
                                step="0.01"
                                min="0"
                                placeholder="0.00"
                                required
                                class="input-focus flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                            />
                            @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center space-x-2">
                            <input
                                id="create-active"
                                wire:model="is_active"
                                type="checkbox"
                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded"
                            />
                            <label for="create-active" class="text-sm font-medium">Serviço ativo</label>
                        </div>

                        <div class="flex gap-3 pt-4">
                            <button 
                                type="button"
                                wire:click="closeCreateModal"
                                class="btn-secondary flex-1 inline-flex items-center justify-center px-4 py-2 text-secondary-foreground font-medium rounded-md"
                            >
                                Cancelar
                            </button>
                            <button 
                                type="submit"
                                class="btn-primary flex-1 inline-flex items-center justify-center px-4 py-2 text-white font-medium rounded-md"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Criar Serviço
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Edit Service Modal -->
    @if($showEditModal)
        <div class="fixed inset-0 flex items-center justify-center p-4 z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg max-w-md w-full border-2 border-primary shadow-elegant">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Editar Serviço</h2>
                        <button 
                            wire:click="closeEditModal"
                            class="text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-100"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form wire:submit="updateService" class="space-y-4">
                        <div class="space-y-2">
                            <label for="edit-name" class="text-sm font-medium leading-none">Nome do Serviço</label>
                            <input
                                id="edit-name"
                                wire:model="name"
                                type="text"
                                placeholder="Ex: Fotografia de Evento"
                                required
                                class="input-focus flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                            />
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="edit-description" class="text-sm font-medium leading-none">Descrição</label>
                            <textarea
                                id="edit-description"
                                wire:model="description"
                                placeholder="Descrição do serviço..."
                                rows="3"
                                class="input-focus flex w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                            ></textarea>
                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="edit-price" class="text-sm font-medium leading-none">Preço (€)</label>
                            <input
                                id="edit-price"
                                wire:model="price"
                                type="number"
                                step="0.01"
                                min="0"
                                placeholder="0.00"
                                required
                                class="input-focus flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                            />
                            @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center space-x-2">
                            <input
                                id="edit-active"
                                wire:model="is_active"
                                type="checkbox"
                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded"
                            />
                            <label for="edit-active" class="text-sm font-medium">Serviço ativo</label>
                        </div>

                        <div class="flex gap-3 pt-4">
                            <button 
                                type="button"
                                wire:click="closeEditModal"
                                class="btn-secondary flex-1 inline-flex items-center justify-center px-4 py-2 text-secondary-foreground font-medium rounded-md"
                            >
                                Cancelar
                            </button>
                            <button 
                                type="submit"
                                class="btn-primary flex-1 inline-flex items-center justify-center px-4 py-2 text-white font-medium rounded-md"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Atualizar Serviço
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
        <div class="fixed inset-0 flex items-center justify-center p-4 z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg max-w-md w-full border-2 border-red-500 shadow-elegant">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                Confirmar Exclusão
                            </h3>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            Tem certeza que deseja excluir este serviço? Esta ação não pode ser desfeita.
                        </p>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button 
                            wire:click="cancelDelete"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg transition-colors duration-200"
                        >
                            Cancelar
                        </button>
                        <button 
                            wire:click="deleteService"
                            class="flex-1 bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200"
                        >
                            Excluir
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>