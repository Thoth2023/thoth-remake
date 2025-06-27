import pytest
import time
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from pages.login import LoginPage
from utils.config import USER, PASSWORD
from pages.planning import MenuLateralPage, PlanningPage

@pytest.fixture(scope="function")
def sistema_logado(driver):
    login = LoginPage(driver)
    login.load()
    login.login(USER, PASSWORD)
    time.sleep(2)
    return driver

def test_informacoes_progresso_atualiza_barra(sistema_logado):
    """
    Testa se ao preencher um domínio válido na tela de informações,
    a barra de progresso é atualizada corretamente ao retornar para a tela.
    """
    driver = sistema_logado
    menu = MenuLateralPage(driver)
    menu.acessar_meus_projetos()
    menu.abrir_primeiro_projeto()
    menu.acessar_aba_planejamento()

    planning = PlanningPage(driver)
    campo = planning.campo_dominio()
    campo.clear()
    campo.send_keys("DominioValido")
    botao = planning.botao_salvar_dominio()
    botao.click()
    time.sleep(4)

    # Voltar para a tela de overview/progresso
    menu.acessar_overview()

    # Esperar a barra de progresso aparecer e capturar o valor
    print("Aguardando barra de progresso aparecer...")
    barra = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.CSS_SELECTOR, ".progress-bar.bg-primary"))
    )
    print("Barra de progresso encontrada!")
    valor_progresso = barra.get_attribute("aria-valuenow")
    print(f"Valor da barra (aria-valuenow): {valor_progresso}")
    assert valor_progresso is not None, "O atributo 'aria-valuenow' não foi encontrado na barra de progresso."
    progresso = float(valor_progresso)
    print(f"Progresso numérico: {progresso}")

    # Verificar se o progresso foi atualizado (maior que zero)
    assert progresso > 0, f"O progresso deveria ser maior que zero após preencher o domínio, mas foi {progresso}."

    print("Aguardando texto 'Planejamento:' aparecer...")
    planejamento_info = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, "//span[contains(text(), 'Planejamento')]"))
    )
    texto = planejamento_info.text
    print(f"Texto encontrado: {texto}")

    import re
    match = re.search(r"Planejamento:\s*([\d.,]+)%", texto)
    assert match, "Não foi possível encontrar o valor de progresso de Planejamento."
    valor_planejamento = float(match.group(1).replace(",", "."))
    print(f"Valor de Planejamento extraído: {valor_planejamento}")

    assert valor_planejamento > 0, f"O progresso deveria ser maior que zero após preencher o domínio, mas foi {valor_planejamento}."
