import pytest
from selenium.webdriver.common.by import By
from pages.my_projects import MyProjectsPage
from pages.project.index import ProjectPage
from pages.project.conducting.study_selection import StudySelectionPage
from pages.project.conducting.quality_assessment import QualityAssessmentPage
from utils.web_functions import login

def get_progress_value(driver):
    bar = driver.find_element(By.CSS_SELECTOR, 'div.progress-bar.bg-secondary')
    return float(bar.get_attribute('aria-valuenow'))

def go_to_study_selection(driver):
    login(driver)
    my_projects = MyProjectsPage(driver)
    project = ProjectPage(driver)
    selection = StudySelectionPage(driver)

    my_projects.load()
    my_projects.open_first_project()
    
    valor_inicial = get_progress_value(driver)
    
    project.open_conducting()
    selection.open_study_selection()

    return selection, project, valor_inicial

"""
    Testa se o progresso muda corretamente ao realizar ações de seleção de estudo
"""
@pytest.mark.parametrize("action,ss", [
    ("inclusion_criteria", True), # Estudo classificado como aceito
    ("inclusion_criteria", False), # Remoção da classificação anterior
    ("exclusion_criteria", True), # Estudo classificado como recusado
    ("exclusion_criteria", False), # Remoção da classificação anterior
    ("remove", True), # Estudo classificado como removido
    ("unclass", False), # Estudo volta ao estado de não classificado
])
def test_progress_study_selection_change(driver, action, ss):
    selection, project, valor_inicial = go_to_study_selection(driver)

    selection.open_unclassified_study()
    getattr(selection, action)()
    project.open_dashboard()
    valor_final = get_progress_value(driver)

    if ss:
        assert valor_final > valor_inicial, f"Progresso não aumentou como esperado"
    else:
        assert valor_final < valor_inicial, f"Progresso não diminuiu como esperado"

"""
    Testa se o progresso muda após ações na avaliação de qualidade
"""
@pytest.mark.parametrize("action,qa", [
    ("study_accepted", True), # Estudo classificado como aceito
    ("study_rejected", True), # Estudo classificado como recusado
])
def test_progress_quality_assessment_change(driver, action, qa):
    quality = QualityAssessmentPage(driver)
    selection, project, valor_inicial = go_to_study_selection(driver)

    selection.open_unclassified_study()
    selection.inclusion_criteria()
    
    quality.open_quality_assessment()
    quality.open_unclassified_study()
    getattr(quality, action)()
    
    project.open_dashboard()
    valor_final = get_progress_value(driver)
    
    project.open_conducting()
    selection.open_study_selection()
    selection.open_unclassified_study()
    selection.inclusion_criteria()
    project.open_dashboard()

    if qa:
        assert valor_final >= valor_inicial, f"Progresso não aumentou como esperado"
    else:
        assert valor_final < valor_inicial, f"Progresso não diminuiu como esperado"
    
"""
pytest tests\test_progress_conducting.py

"""