import time
from pages.perfil import PerfilPage

def test_alternar_tema_multiplas_vezes(driver):
    """
    Testa se o sistema lida bem com múltiplas alternâncias rápidas entre modo claro e escuro.
    """
    pagina = PerfilPage(driver)
    pagina.acessar()
    time.sleep(2)

    body = pagina.body()
    cores = set()

    for _ in range(4):
        pagina.botao_toggle_tema().click()
        time.sleep(1)
        cor_atual = body.value_of_css_property("background-color")
        cores.add(cor_atual)

    assert len(cores) >= 2, "As alternâncias de tema não estão alterando a cor de fundo como esperado."


def test_estado_inicial_tema(driver):
    """
    Testa se a página inicia com o tema claro por padrão.
    """
    pagina = PerfilPage(driver)
    pagina.acessar()
    time.sleep(2)

    body = pagina.body()
    cor_fundo = body.value_of_css_property("background-color")

    # Dependendo do seu sistema, defina a cor exata que representa o modo claro
    cor_esperada_claro = "rgba(255, 255, 255, 1)"  # Exemplo: branco puro

    assert cor_fundo == cor_esperada_claro, "A página não iniciou no modo claro por padrão."


def test_selecao_cor_sidebar_depois_de_tema(driver):
    """
    Testa se, após mudar o tema global, ainda é possível alterar a cor da sidebar sem erros.
    """
    pagina = PerfilPage(driver)
    pagina.acessar()
    time.sleep(2)

    # Mudar o tema
    pagina.botao_toggle_tema().click()
    time.sleep(1)

    # Aplicar uma cor personalizada na sidebar
    pagina.botao_cor_personalizada("cor-3").click()
    time.sleep(1)

    cor_sidebar = pagina.barra_lateral().value_of_css_property("background-color")

    assert cor_sidebar is not None and cor_sidebar != "", "A cor da sidebar não foi aplicada corretamente após mudança de tema."


def test_tema_persiste_apos_reload(driver):
    """
    Testa se o tema selecionado (claro ou escuro) persiste após recarregar a página.
    Requer que o sistema use LocalStorage ou outra forma de persistência.
    """
    pagina = PerfilPage(driver)
    pagina.acessar()
    time.sleep(2)

    # Muda para o modo escuro
    pagina.botao_toggle_tema().click()
    time.sleep(1)
    cor_antes_reload = pagina.body().value_of_css_property("background-color")

    # Recarrega a página
    driver.refresh()
    time.sleep(2)
    cor_depois_reload = pagina.body().value_of_css_property("background-color")

    assert cor_antes_reload == cor_depois_reload, "O tema não persistiu após recarregar a página."


def test_sidebar_seguindo_tema_apos_reload(driver):
    """
    Testa se a cor da sidebar continua consistente com o tema global após um reload.
    """
    pagina = PerfilPage(driver)
    pagina.acessar()
    time.sleep(2)

    # Coloca em modo escuro e seleciona sidebar escura
    pagina.botao_toggle_tema().click()
    time.sleep(1)
    pagina.botao_sidebar_escura().click()
    time.sleep(1)

    cor_sidebar_antes = pagina.barra_lateral().value_of_css_property("background-color")

    # Recarrega a página
    driver.refresh()
    time.sleep(2)

    cor_sidebar_depois = pagina.barra_lateral().value_of_css_property("background-color")

    assert cor_sidebar_antes == cor_sidebar_depois, "A cor da sidebar não persistiu após reload no modo escuro."
