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

def test_informacoes_progresso_reduz_barra_ao_remover_dominio(sistema_logado):
    """
    Testa se ao remover um domínio na tela de informações,
    a barra de progresso de planejamento é reduzida corretamente ao retornar para a tela.
    """
    driver = sistema_logado
    menu = MenuLateralPage(driver)
    menu.acessar_meus_projetos()
    menu.abrir_primeiro_projeto()

    barra = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.CSS_SELECTOR, ".progress-bar.bg-primary"))
    )
    progresso_antes_str = barra.get_attribute("aria-valuenow")
    progresso_antes = float(progresso_antes_str) if progresso_antes_str is not None else 0.0
    print(f"Progresso antes de remover o domínio: {progresso_antes}")

    menu.acessar_aba_planejamento()
    planning = PlanningPage(driver)
    planning.remover_dominio()
    time.sleep(2)

    menu.acessar_overview()
    barras = driver.find_elements(By.CSS_SELECTOR, ".progress-bar.bg-primary")
    if not barras:
        print("Barra de progresso não encontrada após remoção (progresso zerado).")
        progresso_depois = 0.0
    else:
        progresso_depois_str = barras[0].get_attribute("aria-valuenow")
        progresso_depois = float(progresso_depois_str) if progresso_depois_str is not None else 0.0
        print(f"Progresso após remover o domínio: {progresso_depois}")

    assert progresso_depois < progresso_antes, (
        f"O progresso deveria ser reduzido após remover o domínio, mas era {progresso_antes} e ficou {progresso_depois}."
    )