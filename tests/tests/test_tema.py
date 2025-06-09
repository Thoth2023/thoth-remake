import time
from pages.perfil import PerfilPage

# Testa se o tema claro/escuro muda após clicar no botão
def test_alterar_tema_claro_escuro(driver):
    pagina = PerfilPage(driver)
    pagina.acessar()
    time.sleep(2)  # Aguarda o carregamento da página

    # Captura a cor de fundo inicial da página
    body = pagina.body()
    bg_inicial = body.value_of_css_property("background-color")

    # Clica no botão para trocar o tema
    pagina.botao_toggle_tema().click()
    time.sleep(2)

    # Captura a cor de fundo após a troca de tema
    bg_final = body.value_of_css_property("background-color")

    # Verifica se a cor de fundo realmente mudou
    assert bg_inicial != bg_final, "O tema não foi alterado corretamente após o clique no botão de alternância."

# Testa se é possível voltar do modo escuro para o claro
def test_alterar_tema_escuro_para_claro(driver):
    pagina = PerfilPage(driver)
    pagina.acessar()
    time.sleep(2)

    # Pega o background atual da página
    body = pagina.body()
    bg_atual = body.value_of_css_property("background-color")

    # Clica no botão para garantir que está no modo escuro
    pagina.botao_toggle_tema().click()
    time.sleep(2)

    # Clica novamente para voltar ao modo claro
    pagina.botao_toggle_tema().click()
    time.sleep(2)

    # Captura a cor de fundo final
    bg_final = body.value_of_css_property("background-color")

    # Verifica se voltou ao modo claro
    assert bg_atual != bg_final, "O tema claro não foi aplicado corretamente após alternar do modo escuro."
