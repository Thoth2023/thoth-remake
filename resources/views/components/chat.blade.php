<div id="chat-container">
    <div id="chat-header">
        Chat do Projeto
        <span id="chat-notif">!</span>
    </div>
    <div id="chat-body">
        <div id="chat-messages"></div>
        <div id="chat-footer">
            <textarea id="chat-input" placeholder="Digite sua mensagem..."></textarea>
            <button id="chat-send">Enviar</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let chatOpen = false;

        const chatHeader = document.getElementById("chat-header");
        const chatBody = document.getElementById("chat-body");
        const chatNotif = document.getElementById("chat-notif");
        const chatSend = document.getElementById("chat-send");
        const chatInput = document.getElementById("chat-input");
        const chatMessages = document.getElementById("chat-messages");

        const projetoId = {{ $projeto_id ?? 1 }};
        const usuarioLogado = @json(Auth::user()->name);

        chatHeader.addEventListener("click", function() {
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
                            usuario: msg.usuario,
                            mensagem: msg.mensagem,
                            hora: formatarHora(dataMsg)
                        });
                    });

                    for (const data in mensagensAgrupadas) {
                        chatMessages.innerHTML += `<div class="chat-date-group">${data}</div>`;
                        mensagensAgrupadas[data].forEach(msg => {
                            chatMessages.innerHTML += `
                        <div class="chat-message">
                            <div class="chat-content">
                                <div class="chat-text">
                                    <strong>${msg.usuario}</strong><br>
                                    ${msg.mensagem}
                                </div>
                                <div class="chat-time">${msg.hora}</div>
                            </div>
                        </div>
                    `;
                        });
                    }

                    if (scrollForcado || estavaNoFinal) {
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    }
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
                carregarMensagens(true);
            });
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
</script>
