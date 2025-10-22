@if(session('show_protocol_warning_modal') && isset($project))
    <!-- Modal Protocol Warning -->
    <div class="modal fade" id="protocolWarningModal" tabindex="-1" aria-labelledby="protocolWarningModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content modal-transparent">
                <div class="modal-header">
                    <h5 class="modal-title text-warning" id="protocolWarningModalLabel">
                        <i class="fa-solid fa-triangle-exclamation me-1"></i>
                        {{ __("project/conducting.protocol_warning.title") }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('project/conducting.protocol_warning.cancel') }}"></button>
                </div>

                <div class="modal-body">
                    <p>{!! __("project/conducting.protocol_warning.message") !!}</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success fw-bold" onclick="acceptProtocolWarning({{ $project->id_project }})">
                        <i class="fa-solid fa-check"></i>
                        {{ __("project/conducting.protocol_warning.confirm") }}
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __("project/conducting.protocol_warning.cancel") }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @if(session('show_protocol_warning_modal'))
                console.log('Exibindo modal de protocolo...');
                var modal = new bootstrap.Modal(document.getElementById('protocolWarningModal'));
                modal.show();
                @endif
            });

            function acceptProtocolWarning(projectId) {
                console.log('Enviando requisição para aceitar protocolo do projeto ID:', projectId);

                fetch("{{ route('project.conducting.accept-protocol-warning', ['projectId' => $project->id_project]) }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ project_id: projectId }),
                })
                    .then(response => {
                        console.log('Status da resposta:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Resposta da API:', data);
                        if (data.success) {
                            var modal = bootstrap.Modal.getInstance(document.getElementById('protocolWarningModal'));
                            modal.hide();
                            console.log('Modal fechado e protocolo aceito com sucesso.');
                        } else {
                            console.warn('Falha ao aceitar protocolo.');
                        }
                    })
                    .catch(error => console.error('Erro na requisição fetch:', error));
            }
        </script>
    @endpush
@endif
