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
    ("DomínioTeste", True),
    ("", False),
    ("12345", False),
    ("Domínio!@#", False),
    ("Teste123", False),
])
def test_input_dominio_validacao(sistema_logado, input_val, should_accept):
    driver = sistema_logado
    menu = MenuLateralPage(driver)
    menu.acessar_meus_projetos()
    menu.abrir_primeiro_projeto()
    menu.acessar_aba_planejamento()

    planning = PlanningPage(driver)
    campo = planning.campo_dominio()
    campo.clear()
    campo.send_keys(input_val)
    botao = planning.botao_salvar_dominio()
    botao.click()
    time.sleep(4)

    if should_accept:
        assert planning.dominio_esta_listado(input_val), f"O domínio '{input_val}' deveria ser aceito, mas não foi encontrado."
    else:
        if input_val == "":
            # Verifica mensagem de campo obrigatório no DOM
            mensagem = driver.find_element(By.XPATH, "//span[contains(text(), 'O campo de descrição é obrigatório.')]")
            assert mensagem.is_displayed(), "A mensagem de campo obrigatório não apareceu."
        else:
            # Verifica validação HTML5 (tooltip)
            is_invalid = driver.execute_script("return arguments[0].validity.valid;", campo) == False
            assert is_invalid, "O campo deveria estar inválido, mas não está."
            validation_message = driver.execute_script("return arguments[0].validationMessage;", campo)
            assert "formato corresponda ao exigido" in validation_message

@pytest.mark.parametrize("input_val,should_accept", [
    ("PalavraChave", True),
    ("", False),
    ("12345", False),
    ("Palavra!@#", False),
    ("Chave123", False),
])
def test_input_palavra_chave_validacao(sistema_logado, input_val, should_accept):
    driver = sistema_logado
    menu = MenuLateralPage(driver)
    menu.acessar_meus_projetos()
    menu.abrir_primeiro_projeto()
    menu.acessar_aba_planejamento()

    planning = PlanningPage(driver)
    campo = planning.campo_palavra_chave()
    campo.clear()
    campo.send_keys(input_val)
    botao = planning.botao_salvar_palavra_chave()
    botao.click()
    time.sleep(1)

    if should_accept:
        assert planning.palavra_chave_esta_listada(input_val), f"A palavra-chave '{input_val}' deveria ser aceita, mas não foi encontrada."
    else:
        if input_val == "":
            mensagem = driver.find_element(By.XPATH, "//span[contains(text(), 'O campo de descrição é obrigatório.')]")
            assert mensagem.is_displayed(), "A mensagem de campo obrigatório não apareceu."
        else:
            is_invalid = driver.execute_script("return arguments[0].validity.valid;", campo) == False
            assert is_invalid, "O campo deveria estar inválido, mas não está."
            validation_message = driver.execute_script("return arguments[0].validationMessage;", campo)
            assert "formato corresponda ao exigido" in validation_message

