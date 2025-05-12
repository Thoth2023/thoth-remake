@props(['projeto_id'])

<div id="chat-box" style="border:1px solid #ccc; height:300px; overflow:auto; margin-top: 20px;"></div>

<textarea id="mensagem" placeholder="Digite a mensagem"></textarea><br>
<button onclick="enviar()">Enviar</button>

<script>
    const projetoId = "{{ $projeto_id }}";

    async function carregarMensagens() {
        const res = await fetch(`/chat/${projetoId}/messages`);
        const data = await res.json();
        let chatBox = document.getElementById('chat-box');
        chatBox.innerHTML = '';
        data.forEach(msg => {
            chatBox.innerHTML += `<div><strong>${msg.usuario}</strong>: ${msg.mensagem} (${msg.created_at})</div>`;
        });
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    async function enviar() {
        const mensagem = document.getElementById('mensagem').value;

        await fetch(`/chat/${projetoId}/messages`, {
            method: 'POST',
            credentials: 'include', // <- importante para enviar os cookies
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ mensagem })
        });


        document.getElementById('mensagem').value = '';
        carregarMensagens();
    }

    carregarMensagens();
    setInterval(carregarMensagens, 3000);
</script>
