import time
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

class qualityQuestionsPage:

    # Localizadores
    PROJECT_ROWS = (By.CSS_SELECTOR, "table.table tbody tr")
    INPUT_ID = (By.ID, "question-quality-id")
    INPUT_WEIGHT = (By.ID, "weight")
    TABLE_QA = (By.TAG_NAME, "tr")
    QUALITY_ASSESSMENT_SECTION = (By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[1]/ul/li[7]/a")
    INPUT_DESCRIPTION = (By.ID, "question")
    SUBMIT_BUTTON = (By.XPATH, "//div[@id='quality-assessment']/div/div/div/div[2]/form/button")
    PLANNING_TAB = (By.XPATH, "/html/body/main/div[1]/div/div[1]/div/div[2]/div/ul/li[2]/a",)

    def __init__(self, driver):
        self.driver = driver

    def click_planning_section(self):
        """
        Clique na seção de planejamento
        """
        try:
            self.driver.find_element(*self.PLANNING_TAB).click()
            time.sleep(1)  # Pausa para garantir que a aba seja aberta
        except Exception as e:
            print(f"[ERRO] Erro ao abrir a aba de planejamento: {e}")

    def click_QA_section(self):
        """
        Clica na seção de QA
        """
        self.driver.find_element(*self.QUALITY_ASSESSMENT_SECTION).click()
        time.sleep(1)

    def create_quality_question(self, id_question, description, weight):
        """
        Clica no botão para criar uma nova questão de qualidade
        """
        self.click_planning_section()
        time.sleep(1)
        self.click_QA_section()

        self.driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
        time.sleep(1)

        self.driver.find_element(*self.INPUT_ID).send_keys(id_question)
        self.driver.find_element(*self.INPUT_DESCRIPTION).send_keys(description)
        self.driver.find_element(*self.INPUT_WEIGHT).send_keys(weight)

        self.driver.find_element(*self.SUBMIT_BUTTON).click()
        time.sleep(1)

    def edit_quality_question(self, id_question, new_id_question, new_description, new_weight):
        """
        Clica no botão para editar uma questão de qualidade existente
        """
        self.click_planning_section()
        time.sleep(1)
        self.click_QA_section()

        self.driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
        time.sleep(1)

        question_row = self.find_qa_by_id(id_question)

        if question_row:
            self.driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
            time.sleep(1)
            question_row.find_element(By.XPATH, './td[6]/div/button[1]').click()
            time.sleep(1)

            self.driver.find_element(*self.INPUT_ID).clear()
            self.driver.find_element(*self.INPUT_ID).send_keys(new_id_question)

            self.driver.find_element(*self.INPUT_DESCRIPTION).clear()
            self.driver.find_element(*self.INPUT_DESCRIPTION).send_keys(new_description)

            self.driver.find_element(*self.INPUT_WEIGHT).clear()
            self.driver.find_element(*self.INPUT_WEIGHT).send_keys(new_weight)

            self.driver.find_element(*self.SUBMIT_BUTTON).click()
            time.sleep(1)

    def delete_quality_question(self, id_question):
        """
        Clica no botão para excluir uma questão de qualidade existente
        """
        self.click_planning_section()
        time.sleep(1)
        self.click_QA_section()

        self.driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
        time.sleep(1)

        question_row = self.find_qa_by_id(id_question)

        if question_row:
            self.driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
            time.sleep(1)
            question_row.find_element(By.XPATH, './td[6]/div/div/button[1]').click()
            time.sleep(1)

            modal = WebDriverWait(self.driver, 10).until(
                EC.visibility_of_element_located((By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[7]/div/div[2]/div[1]/div/table/tbody/tr[1]/td[6]/div/div/div/div/div"))
            )

            modal.find_element(By.XPATH, "./div[3]/button[2]").click()

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

    def find_qa_by_id(self, id_qa):
        """
        Encontra uma questão de qualidade pelo ID
        """
        rows = self.driver.find_elements(*self.TABLE_QA)
        for row in rows:
            if id_qa in row.text:
                return row
        return None
