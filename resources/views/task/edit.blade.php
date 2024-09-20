
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h1 class="text-center mb-4 text-2xl font-bold">Editar Tarea</h1>

                <form action="{{ route('task.update', $task->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title" class="text-gray-700">Título</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $task->title }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description" class="text-gray-700">Descripción</label>
                                <input type="text" class="form-control" id="description" name="description" value="{{ $task->description }}">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="expiration_date" class="text-gray-700">Fecha de Vencimiento</label>
                                <input type="date" class="form-control" id="expiration_date" name="expiration_date" value="{{ $task->expiration_date }}" required>
                            </div>
                        </div>
                       
                    </div>
                   
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

