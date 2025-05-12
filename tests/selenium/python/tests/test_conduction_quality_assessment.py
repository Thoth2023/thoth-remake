import time
from pages.projects.conduction.quality_assessment import QualityAssessment
from utils.web_functions import login_with_credentials

# SeTC.010.1 - Aceitar estudos na avaliação de qualidade
def test_accept_study(driver):
    """
    Verificar se o usuário pode aceitar estudos na avaliação de qualidade.
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

    # Resetar o estado do primeiro elemento da lista
    quality_assessment_page.reject_list_element(0)


# SeTC.010.2 - Rejeitar estudos na avaliação de qualidade
def test_reject_study(driver):
    """
    Verificar se o usuário pode rejeitar estudos na avaliação de qualidade.
    """
    # Login no sistema
    login_with_credentials(driver, "email@teste.SeTC10.com", "SenhaTeste123")

    # Acessar a página de avaliação de qualidade
    quality_assessment_page = QualityAssessment(driver)
    quality_assessment_page.navigate_to_quality_assessment()

    # Rejeitar o segundo elemento da lista
    quality_assessment_page.reject_list_element(1)

    # Obter o status do segundo elemento da lista
    status = quality_assessment_page.get_status(1)

    # Verificar se o status é "Rejected"
    assert status in ["Rejeitado", "Rejected"], f"Esperado 'Rejeitado' ou 'Rejected' como estado, mas obteve '{status}'"

    # Resetar o estado do segundo elemento da lista
    quality_assessment_page.accept_list_element(1)


# SeTC.010.3 - Remover estudos da avaliação de qualidade
def test_remove_study(driver):
    """
    Verificar se o usuário pode remover estudos da avaliação de qualidade.
    """
    # Login no sistema
    login_with_credentials(driver, "email@teste.SeTC10.com", "SenhaTeste123")

    # Acessar a página de avaliação de qualidade
    quality_assessment_page = QualityAssessment(driver)
    quality_assessment_page.navigate_to_quality_assessment()

    # Remover o terceiro elemento da lista
    quality_assessment_page.remove_list_element(2)

    # Obter o status do terceiro elemento da lista
    status = quality_assessment_page.get_status(2)

    # Verificar se o status é "Removido"
    assert status in ["Removido", "Removed"], f"Esperado 'Removido' ou 'Removed' como estado, mas obteve '{status}'"

    # Resetar o estado do terceiro elemento da lista
    quality_assessment_page.reset_list_element(2)


# SeTC.010.4 - Marcar estudos como não classificados
def test_unclassified_study(driver):
    """
    Verificar se o usuário pode marcar estudos como não classificados na avaliação de qualidade.
    """
     # Login no sistema
    login_with_credentials(driver, "email@teste.SeTC10.com", "SenhaTeste123")

    # Acessar a página de avaliação de qualidade
    quality_assessment_page = QualityAssessment(driver)
    quality_assessment_page.navigate_to_quality_assessment()

    # Desclassificar o quarto elemento da lista
    quality_assessment_page.reset_list_element(3)

    # Obter o status do quarto elemento da lista
    status = quality_assessment_page.get_status(3)

    # Verificar se o status é "Não Classificado"
    assert status in ["Não Classificado", "Unclassified"], f"Esperado 'Não Classificado' ou 'Unclassified' como estado, mas obteve '{status}'"

    # Remover o quarto elemento da lista
    quality_assessment_page.remove_list_element(3)
