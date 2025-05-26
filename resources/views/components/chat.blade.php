<div id="chat-container" style="position:fixed; bottom:0; right:15px; width:300px; z-index:9999;">
    <div id="chat-header" style="background:#007bff;color:#fff;padding:8px;cursor:pointer;">
        Chat do Projeto
        <span id="chat-notif" style="float:right;background:red;padding:2px 5px;border-radius:10px;display:none;">!</span>
    </div>
    <div id="chat-body" style="border:1px solid #ccc;background:#fff;height:250px;overflow:auto;display:none;padding:10px;">
        <div id="chat-messages" style="height:150px; overflow-y: auto;"></div>
        <textarea id="chat-input" placeholder="Digite sua mensagem..." style="width:100%;height:50px;"></textarea>
        <button id="chat-send" style="width:100%;margin-top:5px;">Enviar</button>
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
