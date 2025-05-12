from selenium.webdriver.common.by import By
from utils.config import BASE_URL
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

class ProjectPage:
    URL = BASE_URL + 'projects'

    def __init__(self, driver):
        self.driver = driver

    def load(self):
        """
        Carrega a página de projetos
        """
        self.driver.get(self.URL)

    def open_project(self):
        """
        Clica no botão "Abrir" do primeiro projeto listado.
        """
        self.driver.find_element(By.XPATH, "//tbody/tr[1]/td[4]/div[1]/div[1]/a[1]").click()

    def click_database_tab(self):
        """
        Acessa a aba Planejamento e depois 'Base de Dados' dentro do projeto.
        """
        self.driver.find_element(By.LINK_TEXT, "Planejamento").click()
        self.driver.find_element(By.LINK_TEXT, "Base de Dados").click()

    def add_database(self, db_name):
        """
        Adiciona uma base de dados ao projeto.
        """
        # Clica para selecionar uma opção
        dropdown_trigger = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((
                By.XPATH,
                "//div[@class='choices__item choices__item--selectable'][normalize-space()='Selecione uma Base de Dados']"
            ))
        )
        dropdown_trigger.click()

        # Aguarda as opções carregarem
        dropdown_active = WebDriverWait(self.driver, 10).until(
            EC.presence_of_element_located((By.CLASS_NAME, "choices__list--dropdown"))
        )

        # Seleciona uma opção
        target = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((
                By.XPATH, 
                f"//div[@class='choices__list choices__list--dropdown is-active']//div[contains(@class, 'choices__item') and normalize-space()=\"{db_name}\"]")))
        self.driver.execute_script("arguments[0].scrollIntoView(true);", target)
        target.click()

        # Adiciona a base de dados
        WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, "//button[@type='submit' and contains(@class, 'btn-success') and contains(., 'Adicionar Base de Dados')]"))
        ).click()

    def remove_database(self, db_name):
        """
        Remove uma base de dados associada ao projeto.
        """
         # Localiza o botão de exclusão da base
        delete_button = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((
                By.XPATH,
                f"//tr[td[contains(text(), \"{db_name}\")]]//button[contains(@class, 'btn-outline-danger')]")))
        delete_button.click()

        # Aguarda o popup aparecer e então confirma a remoção
        confirm_button = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((
                By.XPATH,
                "//button[contains(@class, 'bg-danger') and normalize-space(text())='Confirm']")))
        confirm_button.click()

        WebDriverWait(self.driver, 10).until_not(
            EC.presence_of_element_located((
                By.XPATH,
                f"//tr[td[contains(text(), \"{db_name}\")]]"
            ))
        )

    def is_database_present(self, db_name):
        """
        Verifica se a base de dados está visível na tabela.
        """
        rows = self.driver.find_elements(
            By.XPATH,
            f"//tr[td[contains(text(),'{db_name}')]]"
        )
        return len(rows) > 0