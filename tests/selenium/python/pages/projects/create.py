import time
from selenium.webdriver.common.by import By
from utils.config import BASE_URL

class CreateProjectPage:
    URL = BASE_URL + 'projects' + '/create'

    # Localizadores
    TITLE_INPUT = (By.NAME, 'title')
    DESCRIPTION_INPUT = (By.NAME, 'description')
    OBJECTIVES_INPUT = (By.NAME, 'objectives')
    PLANNING_SELECT = (By.ID, 'feature_review1')
    CREATE_BUTTON = (By.XPATH, "/html/body/main/div[1]/div/div/form/div[8]/button")

    def __init__(self, driver):
        self.driver = driver

    def load(self):
        """
        Carrega a criação de projeto
        """
        self.driver.get(self.URL)

    def create(self, title, description, objectives):
        """
        Cria o projeto com base nos parâmetros
        """
        self.driver.find_element(*self.TITLE_INPUT).send_keys(title)
        self.driver.find_element(*self.DESCRIPTION_INPUT).send_keys(description)
        self.driver.find_element(*self.OBJECTIVES_INPUT).send_keys(objectives)
        self.driver.find_element(*self.PLANNING_SELECT).click()
        self.driver.find_element(*self.CREATE_BUTTON).click()
        time.sleep(1) # Pausa para aguardar o processamento e redirecionamento
