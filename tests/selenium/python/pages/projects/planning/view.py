import time
from selenium.webdriver.common.by import By
from utils.config import BASE_URL
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

class ViewProjectPage:
    URL = BASE_URL + 'projects'

    # Localizadores
    TERM_INPUT = (By.CSS_SELECTOR, "input[placeholder='Digite o termo de busca']")
    TERM_SELECT = (By.XPATH, "//div[4]/div/div/div[2]/div/div/div/div/div/div/div")
    TERM_SELECT_OPTION = (By.XPATH, "//div[contains(@class, 'choices__item') and contains(text(), 'software erro')]")
    SYNONYMS_INPUT = (By.CSS_SELECTOR, "#synonym")

    OPEN_BUTTON = (By.CSS_SELECTOR, ".fas.fa-search-plus")
    TAB_PLANNING = (By.CSS_SELECTOR, ".fas.fa-calendar-alt")
    TAB_GENERAL_INFO = (By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[1]/ul/li[1]/a")
    TAB_SEARCHSTRING = (By.CSS_SELECTOR, "#search-string-tab")
    ADD_TERM_BUTTON = (By.XPATH, "//*[@id='search-string']/div/div[1]/div[2]/form/div[2]/button")
    ADD_SYNONYMS_BUTTON = (By.XPATH, "//div[@class='d-flex gap-1']//div//i[@class='fa fa-plus']")


    def __init__(self, driver):
        self.driver = driver

    def load(self):
        """
        Abre a visualização de projetos
        """
        self.driver.get(self.URL)

    def open_project(self, project_name):
        """
        Rola até o final da página e abre o projeto com o nome fornecido.
        """
        for _ in range(3):
            self.driver.execute_script("window.scrollBy(0, window.innerHeight);")
            time.sleep(1)

        wait = WebDriverWait(self.driver, 10)
        rows = wait.until(EC.presence_of_all_elements_located((By.XPATH, "//table/tbody/tr")))

        print(f"Encontradas {len(rows)} linhas na tabela.")  # Debug

        for row in rows:
            try:
                title_element = row.find_element(By.XPATH, "./td[1]/div/div/h6")
                title_text = title_element.text.strip()
                print(f"Projeto encontrado na linha: '{title_text}'")  # Debug

                if title_text == project_name:
                    open_button = row.find_element(By.XPATH, "./td[4]/div/div[1]/a[1]")
                    open_button.click()
                    time.sleep(1)
                    return True
            except Exception as e:
                print(f"[WARN] Erro ao ler linha: {e}")

        raise Exception(f"Projeto '{project_name}' não encontrado na tabela!")




    def open_tab_planning(self):
        """
        Abre a aba de planejamento do projeto
        """
        self.driver.find_element(*self.TAB_PLANNING).click()
        time.sleep(1)

    def open_tab_general_info(self):
        """
        Abre a aba de informações gerais do projeto
        """
        self.driver.find_element(*self.TAB_GENERAL_INFO).click()
        time.sleep(1)

    def open_tab_searchstring(self):
        """
        Abre a aba de String de busca do projeto
        """
        self.driver.find_element(*self.TAB_SEARCHSTRING).click()
        time.sleep(1)

    def open_select_term(self):
        """
        Abre o seletor de termos na aba de String de busca
        """

    

    def write_search_term(self, term):
        """
        Escreve um termo de busca na aba de String de busca
        """
        term_input = self.driver.find_element(*self.TERM_INPUT)
        term_input.clear()
        term_input.send_keys(term)
        time.sleep(1)
        self.driver.find_element(*self.ADD_TERM_BUTTON).click()
        time.sleep(1)

    def write_synonyms(self, synonyms):
        """
        Escreve sinônimos na aba de String de busca
        """
        synonyms_input = self.driver.find_element(*self.SYNONYMS_INPUT)
        synonyms_input.clear()
        synonyms_input.send_keys(synonyms)
        time.sleep(1)
        self.driver.find_element(*self.ADD_SYNONYMS_BUTTON).click()
        time.sleep(1)

    def select_term(self, driver, term):
        """
        Seleciona um termo de busca na aba de String de busca
        """
        self.driver.find_element(*self.TERM_SELECT).click()
        time.sleep(1)
        # Espera até que o elemento esteja presente
        elemento = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.CSS_SELECTOR, ".choices.is-open")))
        assert elemento is not None
        self.driver.find_element(*self.TERM_SELECT_OPTION).click()
        time.sleep(1)

    def add_search_term(self):
        """
        Adiciona um termo e seus sinônimos na aba de String de busca
        """
        self.driver.find_element(*self.ADD_TERM_BUTTON).click()
        time.sleep(1)


    def add_synonyms(self):
        """
        Adiciona sinônimos na aba de String de busca
        """
        self.driver.find_element(*self.ADD_SYNONYMS_BUTTON).click()
        time.sleep(1)

    def write_domain(self, domain):
        """
        Escreve um domínio na aba de planejamento do projeto e verifica se ele aparece.
        """

        # Scroll para garantir visibilidade
        for _ in range(2):
            self.driver.execute_script("window.scrollBy(0, window.innerHeight);")
            time.sleep(0.3)

        # Preenche o domínio
        domain_input = self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[1]/div[1]/div[2]/form/div[1]/div/input")
        domain_input.clear()
        domain_input.send_keys(domain)
        time.sleep(1)

        # Clica no botão para salvar
        self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[1]/div[1]/div[2]/form/div[2]/button").click()
        time.sleep(1)

        # Verifica se o domínio aparece em algum dos elementos listados
        displayed_domains = self.driver.find_elements(
            By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[1]/div[1]/div[2]/div/div/span"
        )

        found = False
        for elem in displayed_domains:
            if elem.text.strip() == domain:
                found = True
                break

        assert found, f"Domínio '{domain}' não foi encontrado entre: {[e.text.strip() for e in displayed_domains]}"

    def select_language(self, language):

        # Scroll para garantir visibilidade
        for _ in range(1):
            self.driver.execute_script("window.scrollBy(0, window.innerHeight);")
            time.sleep(0.3)

        # Seleciona o idioma
        language_select = self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[1]/div[2]/div[2]/form/div[1]/div/div/div[1]/div/div")
        language_select.click()
        time.sleep(1)

        # Espera até que o elemento esteja presente
        elemento = WebDriverWait(self.driver, 10).until(EC.presence_of_element_located((By.CSS_SELECTOR, ".choices.is-open")))
        assert elemento is not None, "O seletor de idiomas não está visível."

        # Seleciona o idioma desejado
        language_option = self.driver.find_element(By.XPATH, f"//div[contains(@class, 'choices__item') and contains(text(), '{language}')]")
        language_option.click()
        time.sleep(1)
        # Clica no botão para salvar
        self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[1]/div[2]/div[2]/form/div[2]/button").click()
        time.sleep(1)
        
        #Verifica se o idioma aparece em algum dos elementos listados
        
        displayed_languages = self.driver.find_elements(
            By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[1]/div[2]/div[2]/div/div/span"
        )
        found = False
        for elem in displayed_languages:
            if elem.text.strip() == language:
                found = True
                break

        assert found, f"Idioma '{language}' não foi encontrado entre: {[e.text.strip() for e in displayed_languages]}"

    def select_study_type(self, study_type):
        """
        Seleciona um tipo de estudo na aba de planejamento do projeto.
        """
        # Scroll para garantir visibilidade
        for _ in range(2):
            self.driver.execute_script("window.scrollBy(0, window.innerHeight);")
            time.sleep(0.3)

        # Seleciona o tipo de estudo
        study_type_select = self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[1]/div[3]/div[2]/form/div[1]/div/div/div[1]/div/div")
        study_type_select.click()
        time.sleep(1)

        # Espera até que o elemento esteja presente
        elemento = WebDriverWait(self.driver, 10).until(EC.presence_of_element_located((By.CSS_SELECTOR, ".choices.is-open")))
        assert elemento is not None, "O seletor de tipos de estudo não está visível."

        # Seleciona o tipo de estudo desejado
        study_type_option = self.driver.find_element(By.XPATH, f"//div[contains(@class, 'choices__item') and contains(text(), '{study_type}')]")
        study_type_option.click()
        time.sleep(1)

        # Clica no botão para salvar
        self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[1]/div[3]/div[2]/form/div[2]/button").click()
        time.sleep(1)
        
        #Verifica se o tipo de estudo aparece em algum dos elementos listados
        
        displayed_study_types = self.driver.find_elements(
            By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[1]/div[3]/div[2]/div/div/span"
        )
        found = False
        for elem in displayed_study_types:
            if elem.text.strip() == study_type:
                found = True
                break
        assert found, f"Tipo de estudo '{study_type}' não foi encontrado entre: {[e.text.strip() for e in displayed_study_types]}"

    def write_keywords(self, keywords):
        """
        Escreve palavras-chave na aba de planejamento do projeto.
        """
        # Scroll para garantir visibilidade
        for _ in range(2):
            self.driver.execute_script("window.scrollBy(0, window.innerHeight);")
            time.sleep(0.3)

        # Preenche as palavras-chave
        keywords_input = self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[1]/div[4]/div[2]/form/div[1]/div/input")
        keywords_input.clear()
        keywords_input.send_keys(keywords)
        time.sleep(1)

        # Clica no botão para salvar
        self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[1]/div[4]/div[2]/form/div[2]/button").click()
        time.sleep(1)

        # Verifica se as palavras-chave aparecem em algum dos elementos listados
        displayed_keywords = self.driver.find_elements(
            By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[1]/div[4]/div[2]/div/div/span"
        )
        found = False
        for elem in displayed_keywords:
            if elem.text.strip() == keywords:
                found = True
                break
        assert found, f"Palavra-chave '{keywords}' não foi encontrada entre: {[e.text.strip() for e in displayed_keywords]}"

    def select_date(self, date, final_date):
        """
        Seleciona uma data na aba de planejamento do projeto.
        """
        # Scroll para garantir visibilidade
        for _ in range(3):
            self.driver.execute_script("window.scrollBy(0, window.innerHeight);")
            time.sleep(0.3)

        # Preenche a data
        date_input = self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[2]/div/div[2]/form/div[1]/div[1]/input")
        date_input.clear()
        date_input.send_keys(date)
        time.sleep(1)

        # Preenche a data de término
        end_date_input = self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[2]/div/div[2]/form/div[1]/div[2]/input")
        end_date_input.clear()
        end_date_input.send_keys(final_date)
        time.sleep(1)

        # Clica no botão para salvar
        self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[2]/div/div[2]/form/div[2]/button").click()
        time.sleep(1)
