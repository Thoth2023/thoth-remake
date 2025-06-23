from selenium.webdriver.common.by import By
from utils.config import BASE_URL
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

class DataExtractionPage:
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

    def click_data_extraction_tab(self):
        """
        Acessa a aba Planejamento e depois 'Extração de Dados' dentro do projeto.
        """
        self.driver.find_element(By.LINK_TEXT, "Planejamento").click()
        self.driver.find_element(By.LINK_TEXT, "Extração de Dados").click()

    def scroll_to_element_and_click(self, xpath, timeout=50):
        """
        Aguarda até que o elemento esteja presente na página e faz scroll até ele e clica no botão de editar.
        """
        element = WebDriverWait(self.driver, timeout).until(
        EC.presence_of_element_located((By.XPATH, xpath)))

        self.driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", element)
        self.driver.execute_script("arguments[0].click();", element)

    def check_id_conflict_alert(self, timeout=50):
        """
        Verifica se o alerta de ID duplicado está visível na tela.
        Retorna True se estiver, False se não estiver.
        """
        alert = WebDriverWait(self.driver, timeout).until(
                EC.visibility_of_element_located((
                    By.XPATH,
                    "//*[contains(text(), 'Já existe uma questão com este ID')]"
                ))
            )
        return alert.is_displayed()
    
    def edit_question_description(self, new_description):
        """
        Edita o campo de descrição da questão atualmente aberta no formulário.
        """
        description_input = WebDriverWait(self.driver, 30).until(
        EC.element_to_be_clickable((
            By.XPATH,
            "/html[1]/body[1]/main[1]/div[1]/div[1]/div[2]/div[1]/div[1]/div[2]/div[8]/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[2]/input[1]"
        )))
        self.driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", description_input)
        self.driver.execute_script("arguments[0].click();", description_input)

        description_input.clear()
        description_input.send_keys(new_description)

        save_button = WebDriverWait(self.driver, 30).until(
        EC.element_to_be_clickable((By.XPATH, "//button[normalize-space()='Editar Pergunta']")))
        self.driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", save_button)
        save_button.click()
    
    def get_form_data(self):
        wait = WebDriverWait(self.driver, 50)

        wait.until(lambda driver: driver.find_element(
        By.XPATH, "//div[@class='form-group mt-3 d-flex flex-column gap-4']//input[@id='questionId']"
    ).get_attribute('value') != "")

        id_input = wait.until(EC.presence_of_element_located((
        By.XPATH, "//div[@class='form-group mt-3 d-flex flex-column gap-4']//input[@id='questionId']"
        )))

        description_input = wait.until(EC.presence_of_element_located((
            By.XPATH, "/html/body/main/div/div/div[2]/div/div/div[2]/div[8]/div/div/div/div[2]/form/div/div[2]/input"
        )))

        type_input = wait.until(EC.presence_of_element_located((
            By.XPATH, "/html/body/main/div/div/div[2]/div/div/div[2]/div[8]/div/div/div/div[2]/form/div/div[3]/div/div/div/div"
        )))

        return {
            "id": id_input.get_attribute("value").strip(),
            "descricao": description_input.get_attribute("value").strip(),
            "tipo": type_input.text.strip()
        }
    
    def save_question(self):
        """
        Clica no botão 'Adicionar Pergunta' para salvar uma nova questão.
        """
        save_button = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, "//button[normalize-space()='Adicionar Pergunta']"))
        )
        self.driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", save_button)
        save_button.click()

    
    def check_validation_error(self):
        """
        Verifica se aparece a mensagem 'Este campo é obrigatório' no formulário ao tentar enviar sem preencher os campos.
        """
        error_message = WebDriverWait(self.driver, 30).until(
            EC.visibility_of_element_located((
                By.XPATH,
                "//*[contains(text(), 'Este campo é obrigatório')]"
            ))
        )
        return error_message.is_displayed()
    
    def fill_question_form(self, question_id, description, question_type):
        id_input = WebDriverWait(self.driver, 10).until(
            EC.presence_of_element_located((
                By.XPATH, "//div[@class='form-group mt-3 d-flex flex-column gap-4']//input[@id='questionId']"
            ))
        )
        descricao_input = self.driver.find_element(
            By.XPATH, "/html/body/main/div/div/div[2]/div/div/div[2]/div[8]/div/div/div/div[2]/form/div/div[2]/input"
        )
        tipo_input = self.driver.find_element(
            By.XPATH, "/html/body/main/div/div/div[2]/div/div/div[2]/div[8]/div/div/div/div[2]/form/div/div[3]/div/div/div/div"
        )

        id_input.clear()
        id_input.send_keys(question_id)
        descricao_input.clear()
        descricao_input.send_keys(description)
        self.select_question_type(question_type)

    def select_question_type(self, question_type):
        """
        Seleciona o tipo da questão no dropdown.
        """
        # Clica no dropdown para abrir as opções
        dropdown_trigger = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((
                By.XPATH,
                "//div[@class='choices__item choices__item--selectable'][normalize-space()='Selecione um tipo']"
            ))
        )
        dropdown_trigger.click()

        # Aguarda as opções ficarem visíveis
        WebDriverWait(self.driver, 10).until(
            EC.presence_of_element_located((By.CLASS_NAME, "choices__list--dropdown"))
        )

        # Seleciona a opção correta
        option = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((
                By.XPATH,
                f"//div[@class='choices__list choices__list--dropdown is-active']//div[contains(@class, 'choices__item') and normalize-space()=\"{question_type}\"]"
            ))
        )
        self.driver.execute_script("arguments[0].scrollIntoView(true);", option)
        option.click()
        
    def get_question_data_by_id(self, question_id):
        id_element = self.driver.find_element(
            By.ID, f"question-id-{question_id}"
        )
        descricao_element = self.driver.find_element(
            By.ID, f"question-description-{question_id}"
        )
        tipo_element = self.driver.find_element(
            By.ID, f"question-type-{question_id}"
        )

        # Faz scroll até os elementos para garantir que estão visíveis
        self.driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", id_element)
        self.driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", descricao_element)
        self.driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", tipo_element)

        return {
            "id": id_element.text.strip(),
            "descricao": descricao_element.text.strip(),
            "tipo": tipo_element.text.strip()
    }