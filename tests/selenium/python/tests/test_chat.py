from utils.config import USER, PASSWORD
from utils.web_functions import login, logout
from pages.chat import ChatPage

import pytest
import time

@pytest.fixture(autouse=True)
def wait_between_tests():
    yield
    time.sleep(5)

START_MESSAGE = "⏳Iniciado teste de fechar o chat"
FINAL_MESSAGE = "✅ teste finalizado"


# Enviar mensagem
def test_chat_enviar_mensagem(driver):

    """Verificar se é possivel enviar"""

    print(START_MESSAGE)

    message_test = "ultima mensagem"
    project_name = "terceiro"

    chat_page = ChatPage(driver)
    chat_page.open_project(project_name)
    returned_message = chat_page.send_message(message_test)

    assert message_test in returned_message, "Message not sent."

    print(FINAL_MESSAGE)

# Responder Mensagem
def test_chat_responder_mensagem(driver):

    """Verificar se é possivel responder uma mensagem no chat"""

    print(START_MESSAGE)

    message_reply_test = "respondendo a ultima mensagem"
    project_name = "terceiro"

    chat_page = ChatPage(driver)
    chat_page.open_project(project_name)
    returned_message = chat_page.reply_message(message_reply_test)

    assert message_reply_test in returned_message, "Message not sent."

    print(FINAL_MESSAGE)

# Enviar Mensagem Com Muitos Caracteres
def test_send_long_message(driver):

    print(START_MESSAGE)

    project_name = "terceiro"

    chat_page = ChatPage(driver)
    chat_page.open_project(project_name)

    long_message = "Esta é uma mensagem muito longa "
    returned_message = chat_page.send_long_message(long_message)
    assert long_message in returned_message, "A mensagem longa enviada não corresponde à recebida."

    print(FINAL_MESSAGE)

# Enviar mensagem Com Conteudo Vazio
def test_send_empty_message(driver):

    print(START_MESSAGE)

    project_name = "terceiro"

    chat_page = ChatPage(driver)
    chat_page.open_project(project_name)

    result = chat_page.send_empty_message()
    assert result, "Mensagem vazia foi enviada, o que não deveria acontecer."

    print(FINAL_MESSAGE)

# Abrir o Chat
def test_open_chat(driver):
    chat_page = ChatPage(driver)
    chat_page.open_project("terceiro")

    print(START_MESSAGE)

    elements = chat_page.verify_open_chat()
    assert len(elements) > 0, "O chat não abriu corretamente."


    print(FINAL_MESSAGE)

# Fechar o Chat
def test_chat_closed(driver):
    chat_page = ChatPage(driver)
    chat_page.open_project("terceiro")

    print(START_MESSAGE)

    is_closed = chat_page.verify_chat_closed()
    assert is_closed, "O chat deveria estar fechado, mas foi encontrado aberto."

    print(FINAL_MESSAGE)


