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
    ("12345", True),
    ("abcde", True),
    ("ABC123", True),
    ("a1b2c3", True),
    ("", False),
    ("abc!", False),
    ("123 456", False),
    ("abc_123", False),
    ("abc-123", False),
    ("abc.123", False),
    ("a"*21, False),
])

def test_questao_id(sistema_logado, input_val, should_accept):
    driver = sistema_logado
    menu = MenuLateralPage(driver)
    menu.acessar_meus_projetos()
    menu.abrir_primeiro_projeto()
    menu.acessar_aba_planejamento()
    
    planning = PlanningPage(driver)
    menu.acessar_aba_questoes_pesquisa()
    campo_id = planning.campo_questao_pesquisa_id()
    campo_id.clear()
    campo_id.send_keys(input_val)
    campo_descricao = planning.campo_questao_pesquisa_descricao()
    campo_descricao.clear()
    campo_descricao.send_keys("Descrição válida")
    botao = planning.botao_salvar_questao_pesquisa()
    botao.click()

    if should_accept:
        assert planning.questao_pesquisa_esta_listada(input_val), f"O ID '{input_val}' deveria ser aceito, mas não foi encontrado."
    else:
        mensagem = driver.find_element(By.XPATH, "//span[contains(text(), 'O campo ID deve conter apenas letras e números.')]")
        assert mensagem.is_displayed(), "A mensagem de erro para o campo ID não apareceu."


@pytest.mark.parametrize("input_val,should_accept", [
    ("Pesquisa", True),
    ("Área", True),
    ("Estudo de Caso", True),
    ("áéíóú ç ãõ", True),
    ("", False),
    ("12345", False),
    ("Domínio123", False),
    ("Domínio!", False),
    ("Teste, exemplo", False),
    ("Teste-exemplo", False),
    ("Teste_exemplo", False),
])

def test_questao_descricao(sistema_logado, input_val, should_accept):
    driver = sistema_logado
    menu = MenuLateralPage(driver)
    menu.acessar_meus_projetos()
    menu.abrir_primeiro_projeto()
    menu.acessar_aba_planejamento()
    
    planning = PlanningPage(driver)
    campo_id = planning.campo_questao_pesquisa_id()
    campo_id.clear()
    campo_id.send_keys("IDvalido123")
    campo_descricao = planning.campo_questao_pesquisa_descricao()
    campo_descricao.clear()
    campo_descricao.send_keys(input_val)
    botao = planning.botao_salvar_questao_pesquisa()
    botao.click()

    if should_accept:
        assert planning.questao_pesquisa_esta_listada(input_val), f"A descrição '{input_val}' deveria ser aceita, mas não foi encontrada."
    else:
        mensagem = driver.find_element(By.XPATH, "//span[contains(text(), 'A descrição deve conter apenas letras e espaços.')]")
        assert mensagem.is_displayed(), "A mensagem de erro para a descrição não apareceu."
        