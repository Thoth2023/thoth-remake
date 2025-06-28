import pytest
from selenium.webdriver.common.by import By
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

@pytest.mark.parametrize("input_id, input_desc, tipo_criterio, should_accept", [
    ("Criterio1", "Descrição do Critério 1", "Inclusão", True),
    ("", "Descrição do Critério 2", "Exclusão", False),
    ("Criterio3", "", "Inclusão", False),
    ("Criterio4", "Descrição do Critério 4", "Exclusão", True),
    ("Criterio5", "Descrição do Critério 5", "Inclusão", True),
    ("Criterio6", "Descrição do Critério 6", "Exclusão", True),
])

def test_input_criterios_validacao(sistema_logado, input_id, input_desc, tipo_criterio, should_accept):
    driver = sistema_logado
    menu = MenuLateralPage(driver)
    menu.acessar_meus_projetos()
    menu.abrir_primeiro_projeto()
    menu.acessar_aba_planejamento()
    menu.acessar_aba_criterios()
    planning = PlanningPage(driver)
    campo_id = planning.campo_criterios_id()
    campo_id.clear()
    campo_id.send_keys(input_id)
    campo_desc = planning.campo_criterios_descricao()
    campo_desc.clear()
    campo_desc.send_keys(input_desc)
    planning.selecionar_tipo_criterio(tipo_criterio)
    botao_salvar = planning.botao_salvar_criterios()
    botao_salvar.click()
    
    time.sleep(4)

    if should_accept:
        assert planning.criterio_esta_listado(input_id, input_desc), f"O critério '{input_id}' deveria ser aceito, mas não foi encontrado."
    else:
        if input_id == "" or input_desc == "":
            mensagem = driver.find_element(By.XPATH, "//span[contains(text(), 'O campo de descrição é obrigatório.')]")
            assert mensagem.is_displayed(), "A mensagem de campo obrigatório não apareceu."
        else:
            is_invalid = not driver.execute_script("return arguments[0].validity.valid;", campo_id)
            assert is_invalid, "O campo deveria estar inválido, mas não está."
            validation_message = driver.execute_script("return arguments[0].validationMessage;", campo_id)
            assert "formato corresponda ao exigido" in validation_message
