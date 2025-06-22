import time
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.select import Select
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.action_chains import ActionChains
from utils.config import BASE_URL


class QualityAssessmentQualityScore:
    URL_PATTERN = BASE_URL + 'project/{project_id}/planning'
    QUALITY_ASSESSMENT_TAB = (By.ID, "quality-assessment-tab")

    # Localizadores
    SELECT_ELEMENT = (By.XPATH, '/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[7]/div/div[1]/div[2]/div/div[2]/form/div[1]/div[1]/div/div/div/div[1]')
    OPTION_QA01 = (By.XPATH, "//div[contains(@class, 'choices__item') and normalize-space(text())='QA01']")
    SCORE_INPUT = (By.ID, "score-rule")
    SCORE_SLIDER = (By.ID, "range-score")
    DESCRIPTION_INPUT = (By.XPATH, '/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[7]/div/div[1]/div[2]/div/div[2]/form/div[3]/textarea')
    SUBMIT_BUTTON = (By.XPATH, '//*[@id="quality-assessment"]/div/div[1]/div[2]/div/div[2]/form/button')
    TOGGLE_MENU_BUTTON = (By.XPATH, '/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[7]/div/div[2]/div[1]/div/table/tbody/tr[1]/td[1]/button')
    FIRST_TAB = (By.XPATH, '//*[@id="quality-assessment"]/div/div[2]/div[1]/div/table/tbody/tr[2]/td/table/tbody/tr[1]/td[1]/span')
    LAST_TAB = (By.XPATH, '//*[@id="quality-assessment"]/div/div[2]/div[1]/div/table/tbody/tr[2]/td/table/tbody/tr[5]/td[1]/span')
    FIRST_EDIT_BUTTON = (By.XPATH, '/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[7]/div/div[2]/div[1]/div/table/tbody/tr[2]/td/table/tbody/tr[1]/td[4]/div/button[1]')

    def __init__(self, driver):
        self.driver = driver
        self.wait = WebDriverWait(driver, 10)

    def navigate_to_quality_assessment(self, project_id=176):
        """
        Navega até a aba de planejamento e acessa a aba Quality Assessment.
        """
        url = self.URL_PATTERN.format(project_id=project_id)
        self.driver.get(url)
        time.sleep(2)  # Aguarda carregamento da página

        # Clica na aba Quality Assessment
        qa_tab = self.wait.until(EC.element_to_be_clickable(self.QUALITY_ASSESSMENT_TAB))
        qa_tab.click()
        time.sleep(2)  # Aguarda carregamento da aba

    def create_question_score(self, score_name, score, description):
        """
        Cria a question score, define o nome e ajusta o slider para o valor informado.
        """
        self.driver.find_element(*self.SELECT_ELEMENT).click()
        option = self.wait.until(EC.element_to_be_clickable(self.OPTION_QA01))

        actions = ActionChains(self.driver)
        actions.move_to_element(option).click().perform()

        # Preenche o nome do score
        score_input = self.driver.find_element(*self.SCORE_INPUT)
        score_input.send_keys(score_name)

        # Dá TAB para focar no slider
        ActionChains(self.driver).send_keys(Keys.TAB).perform()
        time.sleep(0.2)

        # Reseta o slider (começa em 50, queremos ir ao mínimo)
        for _ in range(10):
            ActionChains(self.driver).send_keys(Keys.ARROW_LEFT).perform()
            time.sleep(0.05)

        # Ajusta o valor final do slider conforme o score desejado (em múltiplos de 5)
        steps = int(score // 5)
        for _ in range(steps):
            ActionChains(self.driver).send_keys(Keys.ARROW_RIGHT).perform()
            time.sleep(0.05)

        # Preenche a descrição do score
        description_input = self.driver.find_element(*self.DESCRIPTION_INPUT)
        description_input.send_keys(description)

        # Envia os valores
        self.driver.find_element(*self.SUBMIT_BUTTON).click()


    def toggle_menu(self):
        description_input = self.driver.find_element(*self.DESCRIPTION_INPUT)
        description_input.send_keys('')
        ActionChains(self.driver).send_keys(Keys.TAB).perform()
        time.sleep(0.2)
        ActionChains(self.driver).send_keys(Keys.TAB).perform()
        ActionChains(self.driver).send_keys(Keys.ENTER).perform()

    def get_first_tab(self):
        return self.driver.find_element(*self.FIRST_TAB).text

    def get_last_tab(self):
        return self.driver.find_element(*self.LAST_TAB).text

    def open_edit(self):
        for i in range(4):
            ActionChains(self.driver).send_keys(Keys.TAB).perform()
            time.sleep(0.2)
        ActionChains(self.driver).send_keys(Keys.ENTER).perform()

    def delete_quality(self):
        for i in range(5):
            ActionChains(self.driver).send_keys(Keys.TAB).perform()
            time.sleep(0.2)
        ActionChains(self.driver).send_keys(Keys.ENTER).perform()

    def edit_question(self, score_name, score, description):
         # Preenche o nome do score
        score_input = self.driver.find_element(*self.SCORE_INPUT)
        score_input.clear()
        score_input.send_keys(score_name)

        # Dá TAB para focar no slider
        ActionChains(self.driver).send_keys(Keys.TAB).perform()
        time.sleep(0.2)

        # Reseta o slider (começa em 50, queremos ir ao mínimo)
        for _ in range(10):
            ActionChains(self.driver).send_keys(Keys.ARROW_LEFT).perform()
            time.sleep(0.05)

        # Ajusta o valor final do slider conforme o score desejado (em múltiplos de 5)
        steps = int(score // 5)
        for _ in range(steps):
            ActionChains(self.driver).send_keys(Keys.ARROW_RIGHT).perform()
            time.sleep(0.05)

        # Preenche a descrição do score
        description_input = self.driver.find_element(*self.DESCRIPTION_INPUT)
        description_input.clear()
        description_input.send_keys(description)

        # Envia os valores
        self.driver.find_element(*self.SUBMIT_BUTTON).click()
