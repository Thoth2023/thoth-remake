import time
from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import WebDriverWait

class SearchQuestionsPage:

    PROJECT_ROWS = (By.CSS_SELECTOR, "table.table tbody tr")
    PROJECT_TITLES = (By.CSS_SELECTOR, "table.table tbody tr td:nth-child(1) h6")

    PLANNING_TAB = (By.XPATH, "/html/body/main/div[1]/div/div[1]/div/div[2]/div/ul/li[2]/a",)
    SEARCH_QUESTIONS_TAB = (By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[1]/ul/li[2]/a",)

    INPUT_ID = (By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[2]/div/div[2]/form/div/div[1]/input",)
    INPUT_DESCRIPTION = (By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[2]/div/div[2]/form/div/div[2]/textarea",)
    SUBMIT_BUTTON = (By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[2]/div/div[2]/form/button",)
    
    QUESTIONS_ROWS = (By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[2]/div/div[2]/div")

    def __init__(self, driver):
        self.driver = driver

    def open_planning_tab(self):
        """
        Abre a aba de planejamento
        """
        try:
            self.driver.find_element(*self.PLANNING_TAB).click()
            time.sleep(1)  # Pausa para garantir que a aba seja aberta
        except Exception as e:
            print(f"[ERRO] Erro ao abrir a aba de planejamento: {e}")


    def open_search_questions_tab(self):
        """
        Abre a aba de questões de pesquisa
        """
        try:
            self.driver.find_element(*self.SEARCH_QUESTIONS_TAB).click()
            time.sleep(1)  # Pausa para garantir que a aba seja aberta
        except Exception as e:
            print(f"[ERRO] Erro ao abrir a aba de questões de pesquisa: {e}")


    def insert_search_question(self, question_id, description):
        """
        Insere uma nova questão de pesquisa
        """
        try:
            self.driver.find_element(*self.INPUT_ID).send_keys(question_id)
            self.driver.find_element(*self.INPUT_DESCRIPTION).send_keys(description)
            self.driver.find_element(*self.SUBMIT_BUTTON).click()
            print(f"[INFO] Questão de pesquisa '{question_id}' criada com sucesso.")
        except Exception as e:
            print(f"[ERRO] Erro ao inserir questão de pesquisa: {e}")


    def edit_search_question(self, new_question_id, new_description):
        """
        Edita uma questão de pesquisa existente
        """
        try:
            self.driver.find_element(*self.INPUT_ID).clear()
            self.driver.find_element(*self.INPUT_ID).send_keys(new_question_id)
            self.driver.find_element(*self.INPUT_DESCRIPTION).clear()
            self.driver.find_element(*self.INPUT_DESCRIPTION).send_keys(new_description)
            self.driver.find_element(*self.SUBMIT_BUTTON).click()
            print(f"[INFO] Questão de pesquisa editada para '{new_question_id}'.")
        except Exception as e:
            print(f"[ERRO] Erro ao editar questão de pesquisa: {e}")


    def check_search_question_exists(self, question_id):
        """
        Verifica se uma questão de pesquisa com o ID especificado já existe
        """
        try:
            rows = self.driver.find_elements(*self.QUESTIONS_ROWS)
            for row in rows:
                id_element = row.find_element(By.CSS_SELECTOR, "#research-questions > div > div.card-body > div > table > tbody > tr.px-4 > td:nth-child(1)")
                if id_element.text.strip() == question_id:
                    return True
            return False
        except Exception as e:
            print(f"[ERRO] Erro ao verificar existência da questão de pesquisa: {e}")
            return False
        
    def count_questions_with_id(self, question_id):
        """
        Conta quantas questões de pesquisa existem com o ID especificado
        """
        count = 0
        try:
            rows = self.driver.find_elements(*self.QUESTIONS_ROWS)
            for row in rows:
                try:
                    id_element = row.find_element(By.CSS_SELECTOR, "#research-questions > div > div.card-body > div > table > tbody > tr.px-4 > td:nth-child(1)")
                    if id_element.text.strip() == question_id:
                        count += 1
                except:
                    pass
            return count
        except Exception as e:
            print(f"[ERRO] Erro ao contar questões de pesquisa: {e}")
            return 0


    def find_by_title_and_open(self, title):
        """
        Procura em todos os projetos por um título específico e clica em abrir
        """
        try:
            rows = self.driver.find_elements(*self.PROJECT_ROWS)
            assert rows, "[ERRO] Nenhum projeto encontrado na página."
            for row in rows:
                title_element = row.find_element(By.CSS_SELECTOR, "td:nth-child(1) h6")
                if title_element.text.strip() == title:
                    open_button = row.find_element(
                        By.XPATH,
                        ".//a[contains(@class, 'btn-outline-success') and contains(., 'Abrir')]",
                    )
                    open_button.click()
                    time.sleep(1)
                    return True
            print(f"[INFO] Projeto com título '{title}' não encontrado.")
            return False
        except Exception as e:
            print(
                f"[ERRO] Erro ao tentar clicar em 'Editar' para o projeto '{title}': {e}"
            )
            return False
        
    def find_by_id_and_edit(self, id_search_question):
        """
        Procura em todas as questões de pesquisa por um ID específico e clica em editar
        """
        try:
            rows = self.driver.find_elements(*self.QUESTIONS_ROWS)
            for row in rows:
                id_element = row.find_element(By.CSS_SELECTOR, "#research-questions > div > div.card-body > div > table > tbody > tr.px-4 > td:nth-child(1)")
                if id_element.text.strip() == id_search_question:
                    edit_button = row.find_element(
                        By.XPATH,
                        ".//button[contains(@class, 'btn-outline-secondary')]"
                    )
                    edit_button.click()
                    time.sleep(1)
                    return True
            print(f"[INFO] Questão de pesquisa com ID '{id_search_question}' não encontrada.")
            return False
        except Exception as e:
            print(f"[ERRO] Erro ao tentar clicar em 'Editar' para a questão de pesquisa '{id_search_question}': {e}")
            return False
        
    def find_by_id_and_delete(self, id_search_question):
        """
        Procura em todas as questões de pesquisa por um ID específico e clica em excluir
        """
        try:
            rows = self.driver.find_elements(*self.QUESTIONS_ROWS)
            for row in rows:
                id_element = row.find_element(By.CSS_SELECTOR, "#research-questions > div > div.card-body > div > table > tbody > tr.px-4 > td:nth-child(1)")
                if id_element.text.strip() == id_search_question:
                    delete_button = row.find_element(
                        By.XPATH,
                        ".//button[contains(@class, 'btn-outline-danger')]"
                    )
                    delete_button.click()
                    time.sleep(1)
                    return True
            print(f"[INFO] Questão de pesquisa com ID '{id_search_question}' não encontrada.")
            return False
        except Exception as e:
            print(f"[ERRO] Erro ao tentar clicar em 'Excluir' para a questão de pesquisa '{id_search_question}': {e}")
            return False
