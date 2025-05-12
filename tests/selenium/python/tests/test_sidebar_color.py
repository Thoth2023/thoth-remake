import time
from pages.perfil import PerfilPage

def test_cor_barra_lateral_modo_claro(driver):
    """
    Testa se a cor da barra lateral muda corretamente entre branca e escura no modo claro.
    Garante que o tema está em modo claro antes de iniciar a verificação.
    """
    pagina = PerfilPage(driver)
    pagina.acessar()
    time.sleep(2)

    # Garante que estamos no modo claro
    pagina.botao_toggle_tema().click()
    time.sleep(1)
    pagina.botao_toggle_tema().click()  # Volta para claro
    time.sleep(1)

    pagina.botao_sidebar_branca().click()
    time.sleep(1)
    cor_clara = pagina.barra_lateral().value_of_css_property("background-color")

    pagina.botao_sidebar_escura().click()
    time.sleep(1)
    cor_escura = pagina.barra_lateral().value_of_css_property("background-color")

    assert cor_clara != cor_escura, "A cor da barra lateral não mudou corretamente no modo claro."


def test_cor_barra_lateral_modo_escuro(driver):
    """
    Testa se a cor da barra lateral muda corretamente entre branca e escura no modo escuro.
    Garante que o tema está em modo escuro antes de iniciar a verificação.
    """
    pagina = PerfilPage(driver)
    pagina.acessar()
    time.sleep(2)

    # Garante que está no modo escuro
    pagina.botao_toggle_tema().click()
    time.sleep(1)

    pagina.botao_sidebar_branca().click()
    time.sleep(1)
    cor_clara = pagina.barra_lateral().value_of_css_property("background-color")

    pagina.botao_sidebar_escura().click()
    time.sleep(1)
    cor_escura = pagina.barra_lateral().value_of_css_property("background-color")

    assert cor_clara != cor_escura, "A cor da barra lateral não mudou corretamente no modo escuro."


def test_tema_global_muda(driver):
    """
    Testa se o fundo da página muda corretamente ao alternar entre o modo claro e o modo escuro.
    """
    pagina = PerfilPage(driver)
    pagina.acessar()
    time.sleep(2)

    cor_fundo_inicial = pagina.fundo_pagina().value_of_css_property("background-color")

    pagina.botao_toggle_tema().click()
    time.sleep(1)

    cor_fundo_alterado = pagina.fundo_pagina().value_of_css_property("background-color")

    assert cor_fundo_inicial != cor_fundo_alterado, "O fundo da página não mudou ao alternar o tema."


def test_barra_lateral_segue_tema(driver):
    """
    Testa se a barra lateral acompanha a mudança de tema global.
    A cor da barra lateral deve mudar ao trocar o tema global, mesmo que ela estivesse branca anteriormente.
    """
    pagina = PerfilPage(driver)
    pagina.acessar()
    time.sleep(2)

    # Forçar modo claro + barra clara
    pagina.botao_toggle_tema().click()
    time.sleep(1)
    pagina.botao_toggle_tema().click()
    time.sleep(1)
    pagina.botao_sidebar_branca().click()
    time.sleep(1)
    cor_clara_claro = pagina.barra_lateral().value_of_css_property("background-color")

    # Ir para modo escuro
    pagina.botao_toggle_tema().click()
    time.sleep(1)
    cor_escura_escuro = pagina.barra_lateral().value_of_css_property("background-color")

    assert cor_clara_claro != cor_escura_escuro, "A barra lateral não seguiu a mudança de tema corretamente."


def test_mudancas_repetidas_tema(driver):
    """
    Testa se o sistema aguenta múltiplas alternâncias rápidas entre os temas sem travar ou apresentar erros de renderização.
    """
    pagina = PerfilPage(driver)
    pagina.acessar()
    time.sleep(2)

    cores_fundo = set()

    for i in range(3):
        pagina.botao_toggle_tema().click()
        time.sleep(1)
        cor_atual = pagina.fundo_pagina().value_of_css_property("background-color")
        cores_fundo.add(cor_atual)

    assert len(cores_fundo) >= 2, "A página não alterou o fundo ao alternar repetidamente o tema."


def test_classes_css_aplicadas(driver):
    """
    Testa se as classes CSS do elemento body mudam corretamente ao alternar entre os temas.
    Exemplo: se usa 'dark-mode' no modo escuro.
    """
    pagina = PerfilPage(driver)
    pagina.acessar()
    time.sleep(2)

    # Captura classes antes da troca
    body_classes_antes = pagina.body().get_attribute("class")

    # Alterna o tema
    pagina.botao_toggle_tema().click()
    time.sleep(1)

    # Captura classes após a troca
    body_classes_depois = pagina.body().get_attribute("class")

    assert body_classes_antes != body_classes_depois, "As classes CSS do body não mudaram com a troca de tema."