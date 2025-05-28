<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Chat Projeto {{ $projeto_id }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div id="chat-box" style="border:1px solid #ccc; height:300px; overflow:auto;"></div>

    <input type="text" id="usuario" placeholder="Seu nome"><br>
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
            const usuario = document.getElementById('usuario').value;
            const mensagem = document.getElementById('mensagem').value;

            await fetch(`/chat/${projetoId}/messages`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ usuario, mensagem })
            });

            document.getElementById('mensagem').value = '';
            carregarMensagens();
        }

        carregarMensagens();
        setInterval(carregarMensagens, 3000);
    </script>
</body>
</html>
