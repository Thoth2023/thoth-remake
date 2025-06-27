import pytest
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time
from pages.login import LoginPage
from pages.planning import PlanningPage, MenuLateralPage
from utils.config import USER, PASSWORD

@pytest.fixture
def driver():
    driver = webdriver.Chrome()
    yield driver
    driver.quit()

@pytest.fixture(scope="function")
def sistema_logado(driver):
    login = LoginPage(driver)
    login.load()
    login.login(USER, PASSWORD)
    time.sleep(2)
    return driver

@pytest.mark.parametrize("input_val,should_accept", [
    ("busca", True),
    ("Estratégia 2024", True),
    ("Revisão!", True),
    ("A+B+C", True),
    ("Estratégia de busca", True),
    ("Busca_1", True),
    ("áéíóú", True),
    ("Busca#2024!", True),
    ("", False),
    ("12345", False),
    ("!!!", False),
    ("123!@#", False),
    ("   ", False),
    ("123 456", False),
    ("!@# $%", False),
])

def test_estrategia_inputs(sistema_logado, input_val, should_accept):
    driver = sistema_logado
    menu = MenuLateralPage(driver)
    menu.acessar_meus_projetos()
    menu.abrir_primeiro_projeto()
    menu.acessar_aba_planejamento()
    planning = PlanningPage(driver)
    menu.acessar_aba_estrategia()
    estrategia_campo = planning.campo_estrategia()
    estrategia_campo.clear()
    estrategia_campo.send_keys(input_val)
    time.sleep(5)
    botao = planning.botao_salvar_estrategia()
    botao.click()

    if should_accept:
        assert planning.estrategia_esta_listada(input_val), f"A estratégia '{input_val}' deveria ser aceita, mas não foi encontrada."
    else:
        mensagem = driver.find_element(
            By.XPATH,
            "//span[contains(text(), 'A descrição deve conter pelo menos uma letra e não pode conter apenas caracteres especiais ou números.')]"
        )
        assert mensagem.is_displayed(), "A mensagem de erro da estratégia de busca não apareceu."
        