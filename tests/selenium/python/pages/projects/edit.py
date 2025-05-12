import time
from selenium.webdriver.common.by import By
from utils.config import BASE_URL

class EditProjectPage:
    URL = BASE_URL + 'projects' + '/edit'

    # Localizadores
    TITLE_INPUT = (By.NAME, 'title')
    DESCRIPTION_INPUT = (By.NAME, 'description')
    OBJECTIVES_INPUT = (By.NAME, 'objectives')
    EDIT_BUTTON = (By.XPATH, "/html/body/main/div[1]/div/div/form/div[8]/button")

    def __init__(self, driver):
        self.driver = driver

    def load(self):
        """
        Carrega a página de edição de projeto
        """
        self.driver.get(self.URL)

    def edit(self, title, description, objectives):
        """
        Edita o projeto com base nos parâmetros
        """
        title_input = self.driver.find_element(*self.TITLE_INPUT)
        title_input.clear()
        title_input.send_keys(title)

        description_input = self.driver.find_element(*self.DESCRIPTION_INPUT)
        description_input.clear()
        description_input.send_keys(description)

        objectives_input = self.driver.find_element(*self.OBJECTIVES_INPUT)
        objectives_input.clear()
        objectives_input.send_keys(objectives)

        self.driver.find_element(*self.EDIT_BUTTON).click()
        time.sleep(1) # Pausa para aguardar o processamento e redirecionamento
