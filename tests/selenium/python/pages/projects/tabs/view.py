import time
from selenium.webdriver.common.by import By
from utils.config import BASE_URL
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

class ViewProjectPage:
    URL = BASE_URL + 'projects'

    # Localizadores
    TERM_INPUT = (By.CSS_SELECTOR, "input[placeholder='Digite o termo de busca']")
    TERM_SELECT = (By.XPATH, "//div[4]/div/div/div[2]/div/div/div/div/div/div/div")
    TERM_SELECT_OPTION = (By.XPATH, "//div[contains(@class, 'choices__item') and contains(text(), 'software erro')]")
    SYNONYMS_INPUT = (By.CSS_SELECTOR, "#synonym")

    OPEN_BUTTON = (By.CSS_SELECTOR, ".fas.fa-search-plus")
    TAB_PLANNING = (By.CSS_SELECTOR, ".fas.fa-calendar-alt")
    TAB_SEARCHSTRING = (By.CSS_SELECTOR, "#search-string-tab")
    ADD_TERM_BUTTON = (By.XPATH, "//*[@id='search-string']/div/div[1]/div[2]/form/div[2]/button")
    ADD_SYNONYMS_BUTTON = (By.XPATH, "//div[@class='d-flex gap-1']//div//i[@class='fa fa-plus']")


    def __init__(self, driver):
        self.driver = driver

    def load(self):
        """
        Abre a visualização de projetos
        """
        self.driver.get(self.URL)

    def open_project(self):
        """
        Abre o projeto
        """
        self.driver.find_element(*self.OPEN_BUTTON).click()
        time.sleep(1)

    def open_tab_planning(self):
        """
        Abre a aba de planejamento do projeto
        """
        self.driver.find_element(*self.TAB_PLANNING).click()
        time.sleep(1)

    def open_tab_searchstring(self):
        """
        Abre a aba de String de busca do projeto
        """
        self.driver.find_element(*self.TAB_SEARCHSTRING).click()
        time.sleep(1)

    def open_select_term(self):
        """
        Abre o seletor de termos na aba de String de busca
        """


    def write_search_term(self, term):
        """
        Escreve um termo de busca na aba de String de busca
        """
        term_input = self.driver.find_element(*self.TERM_INPUT)
        term_input.clear()
        term_input.send_keys(term)
        time.sleep(1)
        self.driver.find_element(*self.ADD_TERM_BUTTON).click()
        time.sleep(1)

    def write_synonyms(self, synonyms):
        """
        Escreve sinônimos na aba de String de busca
        """
        synonyms_input = self.driver.find_element(*self.SYNONYMS_INPUT)
        synonyms_input.clear()
        synonyms_input.send_keys(synonyms)
        time.sleep(1)
        self.driver.find_element(*self.ADD_SYNONYMS_BUTTON).click()
        time.sleep(1)

    def select_term(self, driver, term):
        """
        Seleciona um termo de busca na aba de String de busca
        """
        self.driver.find_element(*self.TERM_SELECT).click()
        time.sleep(1)
        # Espera até que o elemento esteja presente
        elemento = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.CSS_SELECTOR, ".choices.is-open")))
        assert elemento is not None
        self.driver.find_element(*self.TERM_SELECT_OPTION).click()
        time.sleep(1)

    def add_search_term(self):
        """
        Adiciona um termo e seus sinônimos na aba de String de busca
        """
        self.driver.find_element(*self.ADD_TERM_BUTTON).click()
        time.sleep(1)


    def add_synonyms(self):
        """
        Adiciona sinônimos na aba de String de busca
        """
        self.driver.find_element(*self.ADD_SYNONYMS_BUTTON).click()
        time.sleep(1)
