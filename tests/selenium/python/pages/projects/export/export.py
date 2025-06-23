import time
from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import WebDriverWait

class ExportPage:

    # Localizadores
    EXPORT_BUTTON = (By.XPATH, '/html/body/main/div[1]/div/div[2]/div/div/div/div[1]/div[3]/button[2]')
    COPY_LATEX_BUTTON = (By.XPATH, '/html/body/main/div[1]/div/div[2]/div/div/div/div[1]/div[3]/button[1]')
    EXPORT_TAB = (By.XPATH, '/html/body/main/div[1]/div/div[1]/div/div[2]/div/ul/li[5]/a')
    PLANNING_INPUT = (By.XPATH, '/html/body/main/div[1]/div/div[2]/div/div/div/div[1]/div[2]/div/div[1]/label[1]/input')
    IMPORT_STUDIES_INPUT = (By.XPATH, '/html/body/main/div[1]/div/div[2]/div/div/div/div[1]/div[2]/div/div[1]/label[2]/input')
    STUDY_SELECTION_INPUT = (By.XPATH, '/html/body/main/div[1]/div/div[2]/div/div/div/div[1]/div[2]/div/div[1]/label[3]/input')
    QUALITY_ASSESSMENT_INPUT = (By.XPATH, '/html/body/main/div[1]/div/div[2]/div/div/div/div[1]/div[2]/div/div[1]/label[4]/input')
    SNOWBALLING_INPUT = (By.XPATH, '/html/body/main/div[1]/div/div[2]/div/div/div/div[1]/div[2]/div/div[1]/label[5]/input')
    PROJECT_ROWS = (By.CSS_SELECTOR, 'table.table tbody tr')

    def __init__(self, driver):
        self.driver = driver

    def click_export_section(self):
        """
        Clique na seção de planejamento
        """
        try:
            self.driver.find_element(*self.EXPORT_TAB).click()
            time.sleep(1)  # Pausa para garantir que a aba seja aberta
        except Exception as e:
            print(f"[ERRO] Erro ao abrir a aba de planejamento: {e}")

    def copy_latex_content(self):
        """
        Copia o conteúdo LaTeX do projeto
        """
        self.click_export_section()
        time.sleep(1)

        self.driver.find_element(*self.PLANNING_INPUT).click()
        self.driver.find_element(*self.IMPORT_STUDIES_INPUT).click()
        self.driver.find_element(*self.STUDY_SELECTION_INPUT).click()
        self.driver.find_element(*self.QUALITY_ASSESSMENT_INPUT).click()
        self.driver.find_element(*self.SNOWBALLING_INPUT).click()
        time.sleep(1)
        self.driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
        time.sleep(1)

        try:
            self.driver.find_element(*self.COPY_LATEX_BUTTON).click()
            time.sleep(1)
            return True
        except Exception as e:
            print(f"[ERRO] Erro ao tentar copiar o conteúdo LaTeX: {e}")
            return False

    def create_latex_project(self):
        """
        Cria um projeto LaTeX com as configurações padrão
        """
        self.click_export_section()
        time.sleep(1)

        self.driver.find_element(*self.PLANNING_INPUT).click()
        self.driver.find_element(*self.IMPORT_STUDIES_INPUT).click()
        self.driver.find_element(*self.STUDY_SELECTION_INPUT).click()
        self.driver.find_element(*self.QUALITY_ASSESSMENT_INPUT).click()
        self.driver.find_element(*self.SNOWBALLING_INPUT).click()
        time.sleep(1)
        self.driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
        time.sleep(1)
        self.driver.find_element(*self.EXPORT_BUTTON).click()

    def find_by_title_and_open(self, title):
        """
        Procura em todos os projetos por um título específico e clica em abrir
        """
        try:
            rows = self.driver.find_elements(*self.PROJECT_ROWS)
            assert rows, "[ERRO] Nenhum projeto encontrado na página."
            for row in rows:
                self.driver.execute_script("arguments[0].scrollIntoView(true);", row)
                time.sleep(0.2)
                title_element = row.find_element(By.CSS_SELECTOR, "td:nth-child(1) h6")
                if title_element.text.strip() == title:
                    open_button = row.find_element(
                        By.XPATH,
                        ".//a[contains(@class, 'btn py-1 px-3 btn-outline-success') and contains(., 'Abrir')]",
                    )
                    time.sleep(1)  # Pausa para o modal de confirmação aparecer
                    open_button.click()
                    time.sleep(1)
                    return True
            print(f"[INFO] Projeto com título '{title}' não encontrado.")
            return False
        except Exception as e:
            print(
                f"[ERRO] Erro ao tentar clicar em 'Abrir' para o projeto '{title}': {e}"
            )
            return False
