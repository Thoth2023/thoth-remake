import time
from pages.perfil import PerfilPage

def test_todas_cores_personalizadas_sidebar(driver):
    """
    Testa se todas as cores personalizadas da barra lateral são aplicadas corretamente
    e se cada botão realmente altera a cor da barra lateral de forma distinta.
    """
    pagina = PerfilPage(driver)
    pagina.acessar()
    time.sleep(2)

    botoes_cores = [
        "cor-1",  # Azul
        "cor-2",  # Vermelho
        "cor-3",  # Verde
        "cor-4",  # Amarelo
        "cor-5",  # Roxo
        "cor-6",  # Laranja
    ]

    cores_aplicadas = []

    for botao_id in botoes_cores:
        botao = pagina.botao_cor_personalizada(botao_id)
        botao.click()
        time.sleep(1)

        cor_atual = pagina.barra_lateral().value_of_css_property("background-color")
        cores_aplicadas.append(cor_atual)

    # Verifica se todas as cores são diferentes entre si
    assert len(set(cores_aplicadas)) == len(botoes_cores), "Nem todas as cores da barra lateral foram aplicadas corretamente."


def test_persistencia_cor_sidebar_apos_recarregar(driver):
    """
    Testa se a cor escolhida da barra lateral persiste após recarregar a página.
    """
    pagina = PerfilPage(driver)
    pagina.acessar()
    time.sleep(2)

    # Seleciona uma cor
    pagina.botao_cor_personalizada("cor-3").click()
    time.sleep(1)
    cor_antes = pagina.barra_lateral().value_of_css_property("background-color")

    # Recarrega a página
    driver.refresh()
    time.sleep(2)

    cor_depois = pagina.barra_lateral().value_of_css_property("background-color")

    assert cor_antes == cor_depois, "A cor da barra lateral não persistiu após recarregar a página."


def test_troca_rapida_entre_cores_sidebar(driver):
    """
    Testa se a interface lida corretamente com trocas rápidas entre diferentes cores personalizadas da barra lateral.
    """
    pagina = PerfilPage(driver)
    pagina.acessar()
    time.sleep(2)

    cores_trocadas = []

    for botao_id in ["cor-1", "cor-4", "cor-2", "cor-5", "cor-3"]:
        pagina.botao_cor_personalizada(botao_id).click()
        time.sleep(0.5)
        cor = pagina.barra_lateral().value_of_css_property("background-color")
        cores_trocadas.append(cor)

    assert len(set(cores_trocadas)) >= 3, "A troca rápida entre cores não refletiu em mudanças reais de cor."


def test_reset_cor_sidebar(driver):
    """
    Testa se, ao clicar no botão de reset (ou voltar para a cor padrão), a cor da barra lateral volta ao padrão inicial.
    """
    pagina = PerfilPage(driver)
    pagina.acessar()
    time.sleep(2)

    cor_padrao = pagina.barra_lateral().value_of_css_property("background-color")

    # Mudar para uma cor qualquer
    pagina.botao_cor_personalizada("cor-2").click()
    time.sleep(1)
    cor_alterada = pagina.barra_lateral().value_of_css_property("background-color")
    assert cor_padrao != cor_alterada, "A cor personalizada não foi aplicada antes do reset."

    # Reset para padrão
    pagina.botao_reset_cor().click()
    time.sleep(1)
    cor_depois_reset = pagina.barra_lateral().value_of_css_property("background-color")

    assert cor_depois_reset == cor_padrao, "A cor da barra lateral não voltou para o padrão após o reset."


def test_combinar_tema_escuro_com_cores_personalizadas(driver):
    """
    Testa se ao alternar para o modo escuro, ainda é possível aplicar uma cor personalizada na barra lateral.
    """
    pagina = PerfilPage(driver)
    pagina.acessar()
    time.sleep(2)

    # Alternar para modo escuro
    pagina.botao_toggle_tema().click()
    time.sleep(1)

    # Aplicar uma cor personalizada
    pagina.botao_cor_personalizada("cor-4").click()
    time.sleep(1)

    cor_sidebar = pagina.barra_lateral().value_of_css_property("background-color")
    assert cor_sidebar is not None, "A cor da sidebar não foi aplicada no modo escuro."
