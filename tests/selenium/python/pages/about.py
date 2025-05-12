from selenium.webdriver.common.by import By
from utils.config import BASE_URL

class AboutPage:
    URL = BASE_URL + 'about'

    # Localizadores
    ABOUT_US_TEXT = (By.XPATH, '/html/body/main/div[1]/div[2]/div[1]/div/div/h1')

    def __init__(self, driver):
        self.driver = driver

    def load(self):
        """
        Carrega a página "Sobre nós"
        """
        self.driver.get(self.URL)

    def get_about_us_text(self):
        """
        Obtém a mensagem do "Sobre nós" da página
        """
        return self.driver.find_element(*self.ABOUT_US_TEXT).text

