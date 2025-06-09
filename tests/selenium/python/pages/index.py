from selenium.webdriver.common.by import By
from utils.config import BASE_URL

class IndexPage:
    # Localizadores
    WELCOME_TEXT = (By.XPATH, '/html/body/div[3]/div[1]/div/div/h1')

    def __init__(self, driver):
        self.driver = driver

    def load(self):
        """
        Carrega a página "Bem vindo"
        """
        self.driver.get(self.URL)

    def get_welcome_text(self):
        """
        Obtém a mensagem do "Bem vindo" da página
        """
        return self.driver.find_element(*self.WELCOME_TEXT).text

