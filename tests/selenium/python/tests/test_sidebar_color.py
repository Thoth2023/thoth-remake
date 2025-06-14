import time
from pages.perfil import PerfilPage

# Testa se a cor da barra lateral muda corretamente no modo claro
def test_cor_barra_lateral_modo_claro(driver):
    pagina = PerfilPage(driver)
    pagina.acessar()
    time.sleep(2)  # Aguarda o carregamento da página

    # Garante que está no modo claro
    pagina.botao_toggle_tema().click()
    time.sleep(1)
    pagina.botao_toggle_tema().click()  # Volta para claro se já estiver escuro
    time.sleep(1)

    # Seleciona a barra lateral branca
    pagina.botao_sidebar_branca().click()
    time.sleep(1)
    cor_clara = pagina.barra_lateral().value_of_css_property("background-color")

    # Seleciona a barra lateral escura
    pagina.botao_sidebar_escura().click()
    time.sleep(1)
    cor_escura = pagina.barra_lateral().value_of_css_property("background-color")

    # Verifica se a cor da barra realmente mudou
    assert cor_clara != cor_escura, "A cor da barra lateral não mudou corretamente no modo claro."

# Testa se a cor da barra lateral muda corretamente no modo escuro
def test_cor_barra_lateral_modo_escuro(driver):
    pagina = PerfilPage(driver)
    pagina.acessar()
    time.sleep(2)

    # Ativa o modo escuro
    pagina.botao_toggle_tema().click()
    time.sleep(1)

    # Seleciona a barra lateral branca
    pagina.botao_sidebar_branca().click()
    time.sleep(1)
    cor_clara = pagina.barra_lateral().value_of_css_property("background-color")

    # Seleciona a barra lateral escura
    pagina.botao_sidebar_escura().click()
    time.sleep(1)
    cor_escura = pagina.barra_lateral().value_of_css_property("background-color")

    # Verifica se a cor da barra realmente mudou
    assert cor_clara != cor_escura, "A cor da barra lateral não mudou corretamente no modo escuro."
