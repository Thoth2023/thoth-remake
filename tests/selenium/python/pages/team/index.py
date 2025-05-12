import time
from selenium.webdriver.common.by import By
from utils.config import BASE_URL
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

class TeamPage:
    URL = BASE_URL + 'projects'

    # Localizadores
    ADD_MEMBER_BUTTON = (By.XPATH, "//tbody/tr[1]/td[4]/div[1]/div[1]/a[3]")
    confirm_button = (By.XPATH, "//button[normalize-space()='Adicionar']")
    EMAIL_INPUT = (By.ID, "//input[@id='emailMemberInput']")
    LEVEL_SELECT = (By.ID, "//select[@id='levelMemberSelect']")
    LEVEL_SELECT_OPTION_VIEWER = (By.XPATH, "//*[@id='levelMemberSelect']/option[2]")
    LEVEL_SELECT_OPTION_RESEARCHER = (By.XPATH, "/html/body/main/div[1]/div/div[2]/table/tbody/tr[2]/td[3]/form/div/div[1]/select/option[2]")
    ALTER_MEMBER_SELECT = (By.XPATH, "//select[@class='form-select levelMemberSelect2']")

    CONFIRM_ALTER_BUTTON = (By.XPATH, "//button[normalize-space()='Confirm']")
    DELETE_MEMBER_BUTTON = (By.XPATH, "//button[@type='button'][normalize-space()='Delete']")
    CONFIRM_DELETE_BUTTON = (By.XPATH, "//button[@type='submit'][normalize-space()='Delete']")

    def __init__(self, driver):
        self.driver = driver

    def load(self):
        """
        Abre a visualização de equipe
        """
        self.driver.get(self.URL)

    def open_add_member(self):
        """
        Abre a janela de adicionar membro
        """
        self.driver.find_element(*self.ADD_MEMBER_BUTTON).click()
        time.sleep(1)

    def add_member(self, email):
        """
        Adiciona um membro à equipe do projeto
        """
        self.driver.find_element(By.ID, "emailMemberInput").send_keys(email)
        time.sleep(1)  # Aguarda o carregamento do campo de email
        self.driver.find_element(By.ID, "levelMemberSelect").click()
        time.sleep(1)  # Aguarda o carregamento do seletor de nível
        self.driver.find_element(*self.LEVEL_SELECT_OPTION_VIEWER).click()
        time.sleep(1)
        self.driver.find_element(*self.confirm_button).click()
        time.sleep(1)

    def alter_member(self, email):
        """
        Altera o nível de um membro da equipe do projeto
        """
        self.driver.find_element(*self.ALTER_MEMBER_SELECT).click()
        time.sleep(1)  # Aguarda o carregamento do seletor de nível
        self.driver.find_element(*self.LEVEL_SELECT_OPTION_RESEARCHER).click()
        time.sleep(1)
        self.driver.find_element(*self.CONFIRM_ALTER_BUTTON).click()
        time.sleep(2)
        self.driver.find_element(*self.DELETE_MEMBER_BUTTON).click()
        self.driver.find_element(*self.CONFIRM_DELETE_BUTTON).click()
        time.sleep(1)
