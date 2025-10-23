import time
from pages.projects.conduction.quality_assessment import QualityAssessment
from pages.projects.reporting.reporting_tabs import ReportingTabs
from utils.web_functions import login_with_credentials


def test_navigate_reporting(driver):
    """
    Testa a navegação para a aba de relatórios de um projeto específico.
    """
    # Login no sistema
    login_with_credentials(driver, "email@teste.SeTC10.com", "SenhaTeste123")

    reporting_tabs = ReportingTabs(driver)
    reporting_tabs.navigate_to_reporting(project_id=224)
    time.sleep(1)  # Aguarda o carregamento da aba de relatórios
    reporting_tabs.open_import_studies_tab()
    time.sleep(1)  # Aguarda o carregamento da aba de Import Studies
    reporting_tabs.open_study_selection_tab()
    time.sleep(1)  # Aguarda o carregamento da aba de Study Selection
    reporting_tabs.open_quality_assessment_tab()
    time.sleep(1)  # Aguarda o carregamento da aba de Quality Assessment
    reporting_tabs.open_data_extraction_tab()
    time.sleep(1)  # Aguarda o carregamento da aba de Data Extraction
    reporting_tabs.open_reliability_tab()
    time.sleep(1)  # Aguarda o carregamento da aba de Reliability
    reporting_tabs.open_snowballing_tab()
    time.sleep(1)  # Aguarda o carregamento da aba de Snowballing
