<link rel="stylesheet" href="{{ asset('css/chat.css') }}?v=1.0.1">
<div id="chat-container" class="minimizado">
    <div id="chat-header">
        <span class="chat-title">
    <img src="/img/bater-papo.png" alt="Chat" style="width: 32px; height: 32px;">
</span>
        <span id="chat-notif">!</span>
    </div>

    <div id="chat-body">
        <div id="chat-messages"></div>

        <div id="chat-footer">
            <div id="reply-preview">
                <div>
                    <strong id="reply-user"></strong>: <span id="reply-msg"></span>
                </div>
                <button id="cancel-reply">❌</button>
            </div>

            <textarea id="chat-input" placeholder="Digite sua mensagem..."></textarea>
            <button id="chat-send">Enviar</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let chatOpen = false;
        let mensagemRespondida = null;
        let mensagensCarregadas = [];

        const chatContainer = document.getElementById("chat-container");
        const chatHeader = document.getElementById("chat-header");
        const chatTitle = document.querySelector(".chat-title");
        const chatNotif = document.getElementById("chat-notif");
        const chatMessages = document.getElementById("chat-messages");
        const chatSend = document.getElementById("chat-send");
        const chatInput = document.getElementById("chat-input");
        const replyPreview = document.getElementById("reply-preview");
        const replyUser = document.getElementById("reply-user");
        const replyMessage = document.getElementById("reply-msg");
        const cancelReply = document.getElementById("cancel-reply");

        const projetoId = {{ $projeto_id ?? 1 }};
        const usuarioLogado = @json(Auth::user()->name);

        // Toggle do chat
        chatHeader.addEventListener("click", function () {
            chatOpen = !chatOpen;
            chatContainer.classList.toggle("minimizado", !chatOpen);
            chatTitle.innerHTML = chatOpen
                ? '<img src="/img/bater-papo.png" alt="Chat" style="width: 32px; height: 32px;"><span style="margin-left: 6px;">Chat do Projeto</span>'
                : '<img src="/img/bater-papo.png" alt="Chat" style="width: 32px; height: 32px;">';

            if (chatOpen) {
                chatNotif.style.display = "none";
                carregarMensagens(true);
            }
        });

        // Carregar mensagens
        function carregarMensagens(scrollForcado = false) {
            fetch(`/chat/${projetoId}/messages`)
                .then(resp => resp.json())
                .then(data => {
                    if (JSON.stringify(data) === JSON.stringify(mensagensCarregadas)) return;

                    mensagensCarregadas = data;
                    const estavaNoFinal = chatMessages.scrollTop + chatMessages.clientHeight >= chatMessages.scrollHeight - 20;
                    chatMessages.innerHTML = '';

                    const mensagensAgrupadas = {};
                    data.forEach(msg => {
                        const dataMsg = new Date(msg.created_at);
                        const dataFormatada = formatarDataGrupo(dataMsg);

                        if (!mensagensAgrupadas[dataFormatada]) mensagensAgrupadas[dataFormatada] = [];

                        mensagensAgrupadas[dataFormatada].push({
                            id: msg.id,
                            usuario: msg.usuario,
                            mensagem: msg.mensagem,
                            hora: formatarHora(dataMsg)
                        });
                    });

                    for (const data in mensagensAgrupadas) {
                        chatMessages.innerHTML += `<div class="chat-date-group">${data}</div>`;
                        mensagensAgrupadas[data].forEach(msg => {
                            let replyHtml = '';
                            if (msg.mensagem.startsWith('[reply]')) {
                                const partes = msg.mensagem.split('[/reply]');
                                const replyContent = partes[0].replace('[reply]', '').trim();
                                const realMessage = partes[1]?.trim() || '';
                                replyHtml = `<div class="chat-reply-box">${replyContent}</div>`;
                                msg.mensagem = realMessage;
                            }

                            chatMessages.innerHTML += `
                                <div class="chat-message">
                                    <div class="chat-content">
                                        <div class="chat-text">
                                            <strong>${msg.usuario}</strong><br>
                                            ${replyHtml}${msg.mensagem}
                                        </div>
                                        <div class="chat-time">${msg.hora}</div>
                                        <button class="chat-reply-btn" data-usuario="${msg.usuario}" data-mensagem="${msg.mensagem}">↩</button>
                                    </div>
                                </div>`;
                        });
                    }

                    if (scrollForcado || estavaNoFinal) {
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    }

                    chatMessages.querySelectorAll('.chat-reply-btn').forEach(btn => {
                        btn.addEventListener('click', () => {
                            mensagemRespondida = {
                                usuario: btn.dataset.usuario,
                                mensagem: btn.dataset.mensagem
                            };
                            replyUser.innerText = mensagemRespondida.usuario;
                            replyMessage.innerText = mensagemRespondida.mensagem;
                            replyPreview.style.display = 'flex';
                        });
                    });
                });
        }

        // Helpers
        function formatarDataGrupo(data) {
            const hoje = new Date();
            const ontem = new Date();
            ontem.setDate(hoje.getDate() - 1);
            if (data.toDateString() === hoje.toDateString()) return "Hoje";
            if (data.toDateString() === ontem.toDateString()) return "Ontem";
            return data.toLocaleDateString("pt-BR", {
                day: "2-digit", month: "long", year: "numeric"
            });
        }

        function formatarHora(data) {
            return data.toLocaleTimeString("pt-BR", {
                hour: "2-digit", minute: "2-digit"
            });
        }

        // Enviar mensagem
        chatSend.addEventListener('click', function () {
            let mensagem = chatInput.value.trim();
            if (!mensagem) return;

            if (mensagemRespondida) {
                const replyMarkup = `[reply]${mensagemRespondida.usuario}: ${mensagemRespondida.mensagem}[/reply]`;
                mensagem = `${replyMarkup}${mensagem}`;
            }

            fetch(`/chat/${projetoId}/messages`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ usuario: usuarioLogado, mensagem: mensagem })
            }).then(() => {
                chatInput.value = '';
                mensagemRespondida = null;
                replyPreview.style.display = 'none';
                carregarMensagens(true);
            });
        });

        // Cancelar resposta
        cancelReply.addEventListener('click', () => {
            mensagemRespondida = null;
            replyPreview.style.display = 'none';
        });

        // Inicial
        carregarMensagens();

        // Atualizar se fechado
        setInterval(() => {
            if (!chatOpen) {
                fetch(`/chat/${projetoId}/messages`)
                    .then(resp => resp.json())
                    .then(data => {
                        if (JSON.stringify(data) !== JSON.stringify(mensagensCarregadas)) {
                            chatNotif.style.display = "inline";
                        }
                    });
            } else {
                carregarMensagens();
            }
        }, 3000);
    });
</script>

