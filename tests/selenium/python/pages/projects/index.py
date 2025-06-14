import time
from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import WebDriverWait
from utils.config import BASE_URL

class ProjectsPage:
    URL = BASE_URL + 'projects'

    # Localizadores
    CREATE_PROJECT_BUTTON = (By.XPATH, '/html/body/main/div[1]/div[1]/div/div/div/div/div[1]/div/div[2]/a')
    PROJECT_ROWS = (By.CSS_SELECTOR, 'table.table tbody tr')
    PROJECT_TITLES = (By.CSS_SELECTOR, "table.table tbody tr td:nth-child(1) h6")

    def __init__(self, driver):
        self.driver = driver

    def load(self):
        """
        Carrega a página "Projetos"
        """
        self.driver.get(self.URL)
        time.sleep(1) # Pausa para garantir o carregamento completo

    def create_project(self):
        """
        Clica no botão de criar projeto
        """
        self.driver.find_element(*self.CREATE_PROJECT_BUTTON).click()
        time.sleep(1)

    def find_by_title(self, title):
        """
        Procura em todos os projetos por um título específico
        """
        try:
            titles = self.driver.find_elements(*self.PROJECT_TITLES)
            for t in titles:
                if t.text.strip() == title:
                    return True
            return False
        except Exception as e:
            print(f"[ERRO] Erro ao procurar título do projeto: {e}")
            return False

    def find_by_title_and_edit(self, title):
        """
        Procura em todos os projetos por um título específico e clica em editar
        """
        try:
            rows = self.driver.find_elements(*self.PROJECT_ROWS)
            for row in rows:
                title_element = row.find_element(By.CSS_SELECTOR, "td:nth-child(1) h6")
                if title_element.text.strip() == title:
                    edit_button = row.find_element(
                        By.XPATH,
                        ".//a[contains(@class, 'btn-outline-secondary') and contains(., 'Editar')]"
                    )
                    edit_button.click()
                    time.sleep(1)
                    return True
            print(f"[INFO] Projeto com título '{title}' não encontrado.")
            return False
        except Exception as e:
            print(f"[ERRO] Erro ao tentar clicar em 'Editar' para o projeto '{title}': {e}")
            return False

    def find_by_title_and_delete(self, title):
        """
        Encontra o projeto pelo título, clica no botão de deletar
        e confirma a deleção no modal.
        """
        try:
            rows = self.driver.find_elements(*self.PROJECT_ROWS)
            
            for row in rows:
                # Scroll para o elemento da linha antes de interagir
                self.driver.execute_script("arguments[0].scrollIntoView(true);", row)
                time.sleep(0.2)  # Pequena pausa para ajustar a posição do elemento

                title_element = row.find_element(By.CSS_SELECTOR, "td:nth-child(1) h6")
                if title_element.text.strip() == title:
                    delete_button = row.find_element(By.CSS_SELECTOR, "button[data-bs-toggle='modal']")
                    delete_button.click()
                    time.sleep(1)  # Pausa para o modal de confirmação aparecer

                    wait = WebDriverWait(self.driver, 2)
                    modal = wait.until(EC.visibility_of_element_located((By.CSS_SELECTOR, ".modal.show")))

                    confirm_button = modal.find_element(By.CSS_SELECTOR, "button.bg-danger")
                    confirm_button.click()
                    time.sleep(1)  # Pausa para a deleção ser processada
                    return True

            return False  # Não encontrou o projeto

        except Exception as e:
            print(f"[ERRO] Erro ao tentar deletar projeto '{title}': {e}")
            return False
