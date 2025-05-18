@props(['projeto_id'])
b

<div id="chat-container" style="position:fixed; bottom:20px; right:20px; width:320px; z-index:9999; font-family:inherit;">
    <div id="chat-header" style="display: flex;" class="bg-gradient-faded-dark text-white p-3 rounded-top shadow cursor-pointer d-flex justify-content-between align-items-center">
        <span>Chat do Projeto</span>
        <div class="d-flex align-items-center gap-2">
            <span id="chat-notif" class="bg-danger text-white px-2 py-1 rounded-circle d-none" style="margin-right: 8px;">!</span>
                <button id="resize-btn"
                    class="btn btn-sm btn-light text-dark d-flex justify-content-center align-items-center"
                    style="width: 32px; height: 32px; padding: 0; font-size: 20px; line-height: 1; margin-top: 8px">
                    ⤢
                </button>
        </div>
    </div>


    <div id="chat-body" class="bg-white border rounded-bottom shadow chat-small" style="display:none;">
        <div id="chat-box" class="p-3" style="overflow-y: auto; font-size:14px;"></div>
        <div id="chat-input-area" style="padding: 10px;">
            <div style="display: flex; gap: 5px; margin-top: 5px;">
                <textarea id="mensagem" placeholder="Digite sua mensagem..."
                    class="form-control"
                    style="flex: 1; height: 50px; resize: none;"></textarea>
                <button onclick="enviar()" class="btn btn-primary" style="height: 50px;">Enviar</button>
            </div>
        </div>
    </div>

</div>

<style>
    .chat-small {
        width: 320px;
        height: 250px;
    }

    .chat-large {
        width: 500px;
        height: 400px;
    }

    #chat-container {
        transition: width 0.3s ease;
    }
</style>

<script>
const projetoId = "{{ $projeto_id }}";

    let chatAberto = false;
    const chatHeader = document.getElementById('chat-header');
    const chatBody = document.getElementById('chat-body');
    const chatNotif = document.getElementById('chat-notif');
    const chatBox = document.getElementById('chat-box');

    chatHeader.addEventListener('click', function () {
        chatAberto = !chatAberto;
        chatBody.style.display = chatAberto ? 'block' : 'none';
        if (chatAberto) {
            chatNotif.classList.add('d-none');
            carregarMensagens();
            ajustarAlturaChatBox()
        }
    });

    async function carregarMensagens() {
        const res = await fetch(`/chat/${projetoId}/messages`);
        const data = await res.json();
        chatBox.innerHTML = '';
        data.forEach(msg => {
            chatBox.innerHTML += `<div><strong>${msg.usuario}</strong>: ${msg.mensagem} <small>(${msg.created_at})</small></div>`;
        });
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    async function enviar() {
        const mensagem = document.getElementById('mensagem').value.trim();
        if (!mensagem) return;

        await fetch(`/chat/${projetoId}/messages`, {
            method: 'POST',
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ mensagem })
        });

        document.getElementById('mensagem').value = '';
        carregarMensagens();
    }

    setInterval(() => {
        if (!chatAberto) {
            fetch(`/chat/${projetoId}/messages`)
                .then(resp => resp.json())
                .then(data => {
                    if (data.length > 0) {
                        chatNotif.classList.remove('d-none');
                    }
                });
        } else {
            carregarMensagens();
        }
    }, 5000);

    carregarMensagens();


    //Atalho Alt + C
    document.addEventListener('keydown', function(event) {
        if (event.altKey && event.key.toLowerCase() === 'c') {
            chatHeader.click();
        }
    });




    //Redimencionar janela
    const resizeBtn = document.getElementById('resize-btn');
    let isExpanded = false;

    resizeBtn.addEventListener('click', () => {
        const chatContainer = document.getElementById('chat-container');
        //const chatHeader = document.getElementById('chat-header');
        const chatBody = document.getElementById('chat-body');
        const chatBox = document.getElementById('chat-box');
        const mensagemInput = document.getElementById('mensagem');

        isExpanded = !isExpanded;

        if (isExpanded) {
            chatContainer.style.width = '500px';
            //charHeader.style.width = '500px';
            chatBody.classList.remove('chat-small');
            chatBody.classList.add('chat-large');
            chatBox.style.fontSize = '22px';
            mensagemInput.style.fontSize = '22px';
        } else {
            chatContainer.style.width = '320px';
            //charHeader.style.width = '320px';
            chatBody.classList.remove('chat-large');
            chatBody.classList.add('chat-small');
            chatBox.style.fontSize = '14px';
            mensagemInput.style.fontSize = '14px';
        }

        ajustarAlturaChatBox();
    });

    function ajustarAlturaChatBox() {
        const container = document.getElementById('chat-container');
        const header = document.getElementById('chat-header');
        const inputArea = document.getElementById('chat-input-area');
        const chatBox = document.getElementById('chat-box');

        // Altura total do container menos cabeçalho e campo de envio
        const alturaDisponivel = container.offsetHeight - header.offsetHeight - inputArea.offsetHeight;
        chatBox.style.height = `${alturaDisponivel}px`;
    }


</script>
