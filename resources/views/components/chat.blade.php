<div id="chat-container">
    <div id="chat-header">
        Chat do Projeto
        <span id="chat-notif">!</span>
    </div>
    <div id="chat-body">
        <div id="chat-messages"></div>

        <div id="chat-footer"">
            <div id="reply-preview" style="display: none; padding: 8px; background: #f1f1f1; border-left: 4px solid #007bff; margin-bottom: 5px; border-radius: 5px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="flex-grow: 1;">
                        <strong id="reply-user"></strong>: <span id="reply-msg"></span>
                    </div>
                    <button id="cancel-reply" style="margin-left: 10px; background: none; border: none; cursor: pointer;">❌</button>
                </div>
            </div>
            <div id="send" style="display: flex">
                <textarea id="chat-input" placeholder="Digite sua mensagem..." style="width: 80%; height: 60px; margin-bottom: 2px;"></textarea>
                <button id="chat-send" style="margin: 10px">Enviar</button>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let chatOpen = false;
        let mensagemRespondida = null;

        const chatHeader = document.getElementById("chat-header");
        const chatBody = document.getElementById("chat-body");
        const chatNotif = document.getElementById("chat-notif");
        const chatSend = document.getElementById("chat-send");
        const chatInput = document.getElementById("chat-input");
        const chatMessages = document.getElementById("chat-messages");
        const replyPreview = document.getElementById("reply-preview");
        const replyUser = document.getElementById("reply-user");
        const replyMessage = document.getElementById("reply-msg");
        const cancelReply = document.getElementById("cancel-reply");

        const projetoId = {{ $projeto_id ?? 1 }};
        const usuarioLogado = @json(Auth::user()->name);

        chatHeader.addEventListener("click", function () {
            chatOpen = !chatOpen;
            chatBody.classList.toggle("open", chatOpen);
            if (chatOpen) {
                chatNotif.style.display = "none";
                carregarMensagens();
            }
        });

        function carregarMensagens(scrollForcado = false) {
            fetch(`/chat/${projetoId}/messages`)
                .then(resp => resp.json())
                .then(data => {
                    const estavaNoFinal =
                        chatMessages.scrollTop + chatMessages.clientHeight >= chatMessages.scrollHeight - 20;

                    chatMessages.innerHTML = '';
                    const mensagensAgrupadas = {};

                    data.forEach(msg => {
                        const dataMsg = new Date(msg.created_at);
                        const dataFormatada = formatarDataGrupo(dataMsg);

                        if (!mensagensAgrupadas[dataFormatada]) {
                            mensagensAgrupadas[dataFormatada] = [];
                        }

                        mensagensAgrupadas[dataFormatada].push({
                            id: msg.id,
                            usuario: msg.usuario,
                            mensagem: msg.mensagem,
                            hora: formatarHora(dataMsg),
                            replyTo: msg.replyTo ?? null
                        });
                    });

                    for (const data in mensagensAgrupadas) {
                        chatMessages.innerHTML += `<div class="chat-date-group">${data}</div>`;
                        mensagensAgrupadas[data].forEach((msg) => {
                            let replyHtml = '';
                            if (msg.mensagem.startsWith('[reply]')) {
                                const partes = msg.mensagem.split('[/reply]');
                                const replyContent = partes[0].replace('[reply]', '').trim();
                                const realMessage = partes[1]?.trim() || '';

                                replyHtml = `
                                    <div class="chat-reply-box" style="background:#e9e9e9;padding:5px;border-left:3px solid #007bff;margin-bottom:5px;font-size:0.9em;color:#555;">
                                        ${replyContent}
                                    </div>`;

                                msg.mensagem = realMessage;
                            }

                            chatMessages.innerHTML += `
                                <div class="chat-message">
                                    <div class="chat-content">
                                        <div class="chat-text">
                                            <strong>${msg.usuario}</strong><br>
                                            ${replyHtml}
                                            ${msg.mensagem}
                                        </div>
                                        <div class="chat-time">${msg.hora}</div>
                                        <button class="chat-reply-btn" data-usuario="${msg.usuario}" data-mensagem="${msg.mensagem}" style="margin-left: 2px; border: None">↩</button>
                                    </div>
                                </div>
                            `;
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
                            replyPreview.style.display = 'block';
                        });
                    });
                });
        }

        function formatarDataGrupo(data) {
            const hoje = new Date();
            const ontem = new Date();
            ontem.setDate(hoje.getDate() - 1);

            if (data.toDateString() === hoje.toDateString()) {
                return "Hoje";
            } else if (data.toDateString() === ontem.toDateString()) {
                return "Ontem";
            } else {
                return data.toLocaleDateString("pt-BR", {
                    day: "2-digit",
                    month: "long",
                    year: "numeric"
                });
            }
        }

        function formatarHora(data) {
            return data.toLocaleTimeString("pt-BR", {
                hour: "2-digit",
                minute: "2-digit"
            });
        }

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
                body: JSON.stringify({
                    usuario: usuarioLogado,
                    mensagem: mensagem
                })
            }).then(() => {
                chatInput.value = '';
                mensagemRespondida = null;
                replyPreview.style.display = 'none';
                carregarMensagens(true);
            });
        });

        cancelReply.addEventListener('click', () => {
            mensagemRespondida = null;
            replyPreview.style.display = 'none';
        });

        carregarMensagens();

        setInterval(() => {
            if (!chatOpen) {
                fetch(`/chat/${projetoId}/messages`)
                    .then(resp => resp.json())
                    .then(data => {
                        if (data.length > 0) {
                            chatNotif.style.display = "inline";
                        }
                    });
            } else {
                carregarMensagens();
            }
        }, 5000);
    });
    
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
