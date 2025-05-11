<div id="chat-container" style="position:fixed; bottom:20px; right:20px; width:320px; z-index:9999; font-family:inherit;">
    <div id="chat-header" class="bg-gradient-faded-dark text-white p-3 rounded-top shadow cursor-pointer d-flex justify-content-between align-items-center">
        <span>Chat do Projeto</span>
        <span id="chat-notif" class="bg-danger text-white px-2 py-1 rounded-circle d-none">!</span>
    </div>

    <div id="chat-body" class="bg-white border rounded-bottom shadow" style="display:none;">
        <div id="chat-messages" class="p-3" style="height:180px; overflow-y: auto; font-size:14px;"></div>
        <textarea id="chat-input" class="form-control border-1" placeholder="Digite sua mensagem..." style="height:60px;"></textarea>
        <button id="chat-send" class="btn btn-primary w-100 mt-2 rounded-bottom">Enviar</button>
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function() {
    let chatOpen = false;

    const chatHeader = document.getElementById('chat-header');
    const chatBody = document.getElementById('chat-body');
    const chatNotif = document.getElementById('chat-notif');
    const chatSend = document.getElementById('chat-send');
    const chatInput = document.getElementById('chat-input');
    const chatMessages = document.getElementById('chat-messages');

    const projetoId = {{ $projeto_id ?? 1 }};
    const usuarioLogado = @json(Auth::user()->name);

    chatHeader.addEventListener('click', function() {
        alert('Clique detectado')
        console.log("Clique detectado");
        chatOpen = !chatOpen;
        chatBody.style.display = chatOpen ? 'block' : 'none';
        if (chatOpen) {
            chatNotif.style.display = 'none';
            carregarMensagens();
        }
    });

    function carregarMensagens() {
        fetch(`/chat/${projetoId}/messages`)
            .then(resp => resp.json())
            .then(data => {
                chatMessages.innerHTML = '';
                data.forEach(msg => {
                    chatMessages.innerHTML += `<div><strong>${msg.usuario}</strong>: ${msg.mensagem}</div>`;
                });
                chatMessages.scrollTop = chatMessages.scrollHeight;
            });
    }

    chatSend.addEventListener('click', function() {
        const mensagem = chatInput.value.trim();
        if (!mensagem) return;

        fetch(`/chat/${projetoId}/messages`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                usuario: usuarioLogado,
                mensagem: mensagem
            })
        }).then(() => {
            chatInput.value = '';
            carregarMensagens();
        });
    });

    carregarMensagens();

    setInterval(() => {
        if (!chatOpen) {
            fetch(`/chat/${projetoId}/messages`)
                .then(resp => resp.json())
                .then(data => {
                    if (data.length > 0) {
                        chatNotif.style.display = 'inline';
                    }
                });
        } else {
            carregarMensagens();
        }
    }, 5000);
});
</script>
