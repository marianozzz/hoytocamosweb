<x-layouts::app :title="__('Dashboard')">
    <div class="d-flex flex-column gap-4 w-100">

        {{-- Fila superior: 3 tarjetas --}}
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-3">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center text-center py-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mb-3"
                             style="width: 56px; height: 56px;">
                            <i class="bi bi-broadcast text-primary fs-4"></i>
                        </div>
                        <h6 class="fw-semibold mb-1">Radio en vivo</h6>
                        <p class="text-muted small mb-0">Escucha la transmisión actual</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-3">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center text-center py-4">
                        <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mb-3"
                             style="width: 56px; height: 56px;">
                            <i class="bi bi-people text-success fs-4"></i>
                        </div>
                        <h6 class="fw-semibold mb-1">Comunidad</h6>
                        <p class="text-muted small mb-0">Conoce a otros oyentes</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-3">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center text-center py-4">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mb-3"
                             style="width: 56px; height: 56px;">
                            <i class="bi bi-chat-dots text-warning fs-4"></i>
                        </div>
                        <h6 class="fw-semibold mb-1">Interacción</h6>
                        <p class="text-muted small mb-0">Participa en el chat en vivo</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tarjeta grande inferior --}}
        <div class="card border-0 shadow-sm rounded-3 flex-grow-1">
            <div class="card-body d-flex flex-column align-items-center justify-content-center text-center" style="min-height: 320px;">
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-4"
                     style="width: 80px; height: 80px;">
                    <i class="bi bi-mic-fill text-secondary fs-1"></i>
                </div>
                <h4 class="fw-bold mb-2">Bienvenido a Radio Comunidad</h4>
                <p class="text-muted mb-4" style="max-width: 480px;">
                    Aquí aparecerá el reproductor de radio en vivo y las interacciones de la comunidad.
                    Por ahora estás en la fase inicial: portada y acceso.
                </p>
                <a href="#" class="btn btn-primary px-4">Explorar comunidad</a>
            </div>
        </div>

    </div>
</x-layouts::app>