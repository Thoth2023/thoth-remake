import time
from pages.projects.conduction.quality_assessment import QualityAssessment
from pages.projects.conduction.data_extraction import DataExtraction
from utils.web_functions import login_with_credentials

# SeTC.010.1 - Aceitar estudos na avaliação de qualidade
def test_accept_study(driver):
    """
   # Verificar se o usuário pode aceitar estudos na avaliação de qualidade.
    """
    # Login no sistema
    login_with_credentials(driver, "email@teste.SeTC10.com", "SenhaTeste123")

    # Acessar a página de avaliação de qualidade
    quality_assessment_page = QualityAssessment(driver)
    quality_assessment_page.navigate_to_quality_assessment()

    # Aceitar o primeiro elemento da lista
    quality_assessment_page.accept_list_element(0)

    # Obter o status do primeiro elemento da lista
    status = quality_assessment_page.get_status(0)

    # Verificar se o status é "Accepted"
    assert status in ["Aceito", "Accepted"], f"Esperado 'Aceito' ou 'Accepted' como estado, mas obteve '{status}'"

# SeTC.000 - Preencher estudos na extração de dados
def test_fill_study(driver):
    """
    Verificar se o usuário pode preencher estudos na extração de dados.
    """
    # Login no sistema
    login_with_credentials(driver, "email@teste.SeTC10.com", "SenhaTeste123")

    # Acessar a página de extração de dados
    data_extraction_page = DataExtraction(driver)
    data_extraction_page.navigate_to_data_extraction()

    # Preencher o primeiro elemento da lista
    data_extraction_page.fill_study(0)

    # Obter o status do primeiro elemento da lista
    status = data_extraction_page.get_status(0)

    # Verificar se o status é "A Fazer"
    assert status in ["A Fazer", "Filled"], f"Esperado 'A Fazer' ou 'Filled' como estado, mas obteve '{status}'"

    # Aceitar o estado do primeiro elemento da lista
    data_extraction_page.accept_study(0)

    # Resetar o estado do primeiro elemento da lista
    data_extraction_page.reset_study(0)
