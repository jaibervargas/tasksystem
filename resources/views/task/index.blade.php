<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-7 space-y-6">
            
            <div class="flex justify-between items-center mb-3">
                <h1 class="text-2xl font-bold">Tareas Pendientes</h1>
                <a href="{{ route('task.create') }}" class="btn btn-dark">Crear Tarea</a>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        

            <div class="table-responsive">
                <table id="tasksTable" class="table table-striped table-bordered ">
                    <thead class="thead-dark">
                        <tr>
                            <th>Título</th>
                            <th>Descripcion</th>
                            <th>Fecha de Vencimiento</th>
                            <th>Completar</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr data-id="{{ $task->id }}">
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->description }}</td>
                                <td>{{ $task->expiration_date }}</td>
                                <td ><input type="checkbox" class="complete-checkbox" data-url="{{ route('task.complete', $task->id) }}" {{ $task->is_completed ? 'checked' : '' }}></td>
                                <td>
                                    <button class="btn btn-dark edit-btn" data-url="{{ route('task.edit', $task->id) }}">Editar</button>
                                    <button class="btn btn-danger delete-btn  g-red-700 hover:bg-red-800" data-url="{{ route('task.destroy', $task->id) }}">Eliminar</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

   
    <script>
        $(document).ready(function() {
            var table = $('#tasksTable').DataTable({
                order: [[1, 'asc']],
                destroy: true
            });

            $('#tasksTable').on('click', '.edit-btn', function() {
                const editUrl = $(this).data('url');
                window.location.href = editUrl;
            });

            
            $('#tasksTable').on('click', '.delete-btn', function() {
                const deleteUrl = $(this).data('url');
                const row = $(this).closest('tr');

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡Esta tarea será eliminada permanentemente!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: deleteUrl,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                table.row(row).remove().draw();
                                Swal.fire(
                                    'Eliminado!',
                                    'La tarea ha sido eliminada.',
                                    'success'
                                );
                            },
                            error: function() {
                                Swal.fire(
                                    'Error!',
                                    'No se pudo eliminar la tarea. Inténtalo de nuevo.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

            $('.complete-checkbox').on('change', function() {
                const completeUrl = $(this).data('url');
                const isChecked = $(this).is(':checked');

                $.ajax({
                    url: completeUrl,
                    type: 'PATCH',
                    data: {
                        _token: '{{ csrf_token() }}',
                        is_completed: isChecked
                    },
                    success: function(response) {
                        
                        Swal.fire(
                                    'Estado!',
                                    'La tarea ha sido actualizada.',
                                    'success'
                                );

                                window.location.href = window.location.href;
                    },
                    error: function(xhr) {
                        
                        Swal.fire(
                                    'Error!',
                                    'Error al actualizar el estado. ' + xhr.responseText,
                                    'error'
                                );
                    }
                });
            });

            setTimeout(function() {
                const successAlert = document.getElementById('successAlert');
                const errorAlert = document.getElementById('errorAlert');
                
                if (successAlert) {
                    successAlert.style.display = 'none';
                }
                if (errorAlert) {
                    errorAlert.style.display = 'none';
                }
            }, 3000);
        });
    </script>
</x-app-layout>
