import time
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.select import Select
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.action_chains import ActionChains
from utils.config import BASE_URL

class ReportingTabs:
    URL_PATTERN = BASE_URL + 'project/{project_id}/reporting'
    OVERVIEW_TAB = (By.XPATH, "//a[@id='overview-tab']")
    IMPORT_STUDIES_TAB = (By.XPATH, "//a[@id='import-studies-tab']")
    STUDY_SELECTION_TAB = (By.XPATH, "//a[@id='study-selection-tab']")
    QUALITY_ASSESSMENT_TAB = (By.XPATH, "//a[@id='quality-assessment-tab']")
    DATA_EXTRACTION_TAB = (By.XPATH, "//a[@id='data-extraction-tab']")
    RELIABILITY_TAB = (By.XPATH, "//a[@id='reliability-tab']")
    SNOWBALLING_TAB = (By.XPATH, "//a[@id='snowballing-tab']")

    def __init__(self, driver):
        self.driver = driver
        self.wait = WebDriverWait(driver, 10)

    def navigate_to_reporting(self, project_id=224):
        """
        Navega até a aba de relatórios.
        """
        url = self.URL_PATTERN.format(project_id=project_id)
        self.driver.get(url)
        time.sleep(2)  # Aguarda carregamento da página

        # Clica na aba Overview
        overview_tab = self.driver.find_element(*self.OVERVIEW_TAB)
        overview_tab.click()
        time.sleep(2)  # Aguarda carregamento da aba

        # Scroll para baixo e para cima para garantir que a aba esteja visível
        self.driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
        time.sleep(2)
        self.driver.execute_script("window.scrollTo(0, 0);")
        # Verifica se a aba Overview está ativa
        assert overview_tab.get_attribute("class") == "nav-link text-secondary active active-tab", "Aba Overview não está ativa."

    def open_import_studies_tab(self):
        """
        Abre a aba de Import Studies.
        """
        import_studies_tab = self.driver.find_element(*self.IMPORT_STUDIES_TAB)
        import_studies_tab.click()
        time.sleep(2)  # Aguarda carregamento da aba

        # Scroll para baixo e para cima para garantir que a aba esteja visível
        self.driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
        time.sleep(2)
        self.driver.execute_script("window.scrollTo(0, 0);")

        # Verifica se a aba Import Studies está ativa
        assert import_studies_tab.get_attribute("class") == "nav-link text-secondary active active-tab", "Aba Import Studies não está ativa."

    def open_quality_assessment_tab(self):
        """
        Abre a aba de Quality Assessment.
        """
        quality_assessment_tab = self.driver.find_element(*self.QUALITY_ASSESSMENT_TAB)
        quality_assessment_tab.click()
        time.sleep(2)  # Aguarda carregamento da aba

        # Scroll para baixo e para cima para garantir que a aba esteja visível
        self.driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
        time.sleep(2)
        self.driver.execute_script("window.scrollTo(0, 0);")

        # Verifica se a aba Quality Assessment está ativa
        assert quality_assessment_tab.get_attribute("class") == "nav-link text-secondary active active-tab", "Aba Quality Assessment não está ativa."

    def open_study_selection_tab(self):
        """
        Abre a aba de Study Selection.
        """
        study_selection_tab = self.driver.find_element(*self.STUDY_SELECTION_TAB)
        study_selection_tab.click()
        time.sleep(2)  # Aguarda carregamento da aba

        # Scroll para baixo e para cima para garantir que a aba esteja visível
        self.driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
        time.sleep(2)
        self.driver.execute_script("window.scrollTo(0, 0);")

        # Verifica se a aba Study Selection está ativa
        assert study_selection_tab.get_attribute("class") == "nav-link text-secondary active active-tab", "Aba Study Selection não está ativa."

    def open_data_extraction_tab(self):
        """
        Abre a aba de Data Extraction.
        """
        data_extraction_tab = self.driver.find_element(*self.DATA_EXTRACTION_TAB)
        data_extraction_tab.click()
        time.sleep(2)  # Aguarda carregamento da aba

        # Scroll para baixo e para cima para garantir que a aba esteja visível
        self.driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
        time.sleep(2)
        self.driver.execute_script("window.scrollTo(0, 0);")

        # Verifica se a aba Data Extraction está ativa
        assert data_extraction_tab.get_attribute("class") == "nav-link text-secondary active active-tab", "Aba Data Extraction não está ativa."

    def open_reliability_tab(self):
        """
        Abre a aba de Reliability.
        """
        reliability_tab = self.driver.find_element(*self.RELIABILITY_TAB)
        reliability_tab.click()
        time.sleep(2)  # Aguarda carregamento da aba

        # Scroll para baixo e para cima para garantir que a aba esteja visível
        self.driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
        time.sleep(2)
        self.driver.execute_script("window.scrollTo(0, 0);")

        # Verifica se a aba Reliability está ativa
        assert reliability_tab.get_attribute("class") == "nav-link text-secondary active active-tab", "Aba Reliability não está ativa."

    def open_snowballing_tab(self):
        """
        Abre a aba de Snowballing.
        """
        snowballing_tab = self.driver.find_element(*self.SNOWBALLING_TAB)
        snowballing_tab.click()
        time.sleep(2)  # Aguarda carregamento da aba

        # Scroll para baixo e para cima para garantir que a aba esteja visível
        self.driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
        time.sleep(2)
        self.driver.execute_script("window.scrollTo(0, 0);")

        # Verifica se a aba Snowballing está ativa
        assert snowballing_tab.get_attribute("class") == "nav-link text-secondary active active-tab", "Aba Snowballing não está ativa."