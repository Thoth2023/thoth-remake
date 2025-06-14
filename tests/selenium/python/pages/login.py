import time
from selenium.webdriver.common.by import By
from utils.config import BASE_URL

class LoginPage:
    URL = BASE_URL + 'login'

    # Localizadores
    EMAIL_INPUT = (By.NAME, 'email')
    PASSWORD_INPUT = (By.NAME, 'password')
    LOGIN_BUTTON = (By.XPATH, "/html/body/main/section/div/div/div/div[1]/div/div[2]/form/div[4]/button")
    THOTH_DESCRIPTION_TEXT = (By.XPATH, "/html/body/main/section/div/div/div/div[2]/div/h4")

    def __init__(self, driver):
        self.driver = driver

    def load(self):
        """
        Carrega a página de login
        """
        self.driver.get(self.URL)

    def login(self, email, password):
        """
        Realiza o login
        """
        self.driver.find_element(*self.EMAIL_INPUT).send_keys(email)
        self.driver.find_element(*self.PASSWORD_INPUT).send_keys(password)
        self.driver.find_element(*self.LOGIN_BUTTON).click()
        time.sleep(1) # Pausa adicionada para aguardar o processamento do login

    def get_description_text(self):
        """
        Obtém a mensagem do "Thoth :: Ferramenta para RSL" da página
        """
        return self.driver.find_element(*self.THOTH_DESCRIPTION_TEXT).text
