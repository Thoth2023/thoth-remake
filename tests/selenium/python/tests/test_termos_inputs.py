import pytest
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time
from pages.login import LoginPage
from pages.planning import PlanningPage, MenuLateralPage
from utils.config import USER, PASSWORD

@pytest.fixture(scope="function")
def sistema_logado(driver):
    login = LoginPage(driver)
    login.load()
    login.login(USER, PASSWORD)
    time.sleep(2)
    return driver

@pytest.mark.parametrize("input_val,should_accept", [
    ("PalavraChave", True),
    ("Teste123", True),
    ("Área de Estudo", True),
    ("áéíóú ç ãõ", True),
    ("", False),
    ("12345", False),
    ("Palavra-Chave!", False),
    ("Palavra_Chave", False),
    ("Palavra Chave, Exemplo", False),
    ("Palavra Chave.Exemplo", False),
    ("a"*21, False),
])

def test_termos_inputs(sistema_logado, input_val, should_accept):
    driver = sistema_logado
    menu = MenuLateralPage(driver)
    menu.acessar_meus_projetos()
    menu.abrir_primeiro_projeto()
    menu.acessar_aba_planejamento()
    planning = PlanningPage(driver)
    menu.acessar_aba_termos_busca()
    campo_termos = planning.campo_termos()
    campo_termos.clear()
    campo_termos.send_keys(input_val)
    botao_salvar = planning.botao_salvar_termos()
    botao_salvar.click()

    if should_accept:
        assert planning.termos_esta_listado(input_val), f"O termo '{input_val}' deveria ser aceito, mas não foi encontrado."
    else:
        is_invalid = not driver.execute_script("return arguments[0].validity.valid;", campo_termos)
        assert is_invalid, "O campo Termos de Busca deveria estar inválido, mas não está."
        validation_message = driver.execute_script("return arguments[0].validationMessage;", campo_termos)
        assert "formato corresponda ao exigido" in validation_message
