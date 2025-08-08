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

@pytest.mark.parametrize(
    "input_id, input_peso, input_desc, should_accept",
    [
        # Todos válidos
        ("abc123", "10", "Descricao123", True),
        ("A1B2C3", "5", "Descricao456", True),
        ("12345", "1", "Descricao789", True),
        ("abcde", "99", "Descricao0", True),
        # ID inválido
        ("abc!", "10", "Descricao123", False),
        ("abc_123", "10", "Descricao123", False),
        ("abc-123", "10", "Descricao123", False),
        ("abc.123", "10", "Descricao123", False),
        ("", "10", "Descricao123", False),
        ("a"*21, "10", "Descricao123", False),
        # Peso inválido
        ("abc123", "", "Descricao123", False),
        ("abc123", "dez", "Descricao123", False),
        ("abc123", "10.5", "Descricao123", False),
        ("abc123", "10kg", "Descricao123", False),
        ("abc123", "!", "Descricao123", False),
        # Descrição inválida
        ("abc123", "10", "Descricao!", False),
        ("abc123", "10", "Descricao_123", False),
        ("abc123", "10", "Descricao-123", False),
        ("abc123", "10", "Descricao.123", False),
        ("abc123", "10", "", False),
        ("abc123", "10", "a"*51, False),
    ]
)

def test_questao_qualidade_inputs(sistema_logado, input_id, input_peso, input_desc, should_accept):
    driver = sistema_logado
    menu = MenuLateralPage(driver)
    menu.acessar_meus_projetos()
    menu.abrir_primeiro_projeto()
    menu.acessar_aba_planejamento()
    planning = PlanningPage(driver)
    menu.acessar_aba_questao_qualidade()
    campo_id = planning.campo_questao_qualidade_id()
    campo_peso = planning.campo_questao_qualidade_peso()
    campo_desc = planning.campo_questao_qualidade_descricao()
    campo_id.clear()
    campo_id.send_keys(input_id)
    campo_peso.clear()
    campo_peso.send_keys(input_peso)
    campo_desc.clear()
    campo_desc.send_keys(input_desc)
    botao = planning.botao_salvar_questao_qualidade()
    botao.click()

    if should_accept:
        assert planning.questao_qualidade_esta_listada(input_id, input_desc), f"A questão '{input_id}' deveria ser aceita, mas não foi encontrada."
    else:
        mensagem = driver.find_element(By.XPATH, "//span[contains(text(), 'inválido') or contains(text(), 'obrigatório')]")
        assert mensagem.is_displayed(), "A mensagem de erro não apareceu."