import time
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.select import Select
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.action_chains import ActionChains
from utils.config import BASE_URL


class QualityAssessment:
    URL_PATTERN = BASE_URL + 'project/{project_id}/conducting'
    QUALITY_ASSESSMENT_TAB = (By.ID, "quality-assessment-tab")

    LIST_ELEMENTS = [
        (By.XPATH, '//*[@id="quality-assessment"]/div/div[3]/div/ul[2]/div[1]/div[2]'),
        (By.XPATH, '//*[@id="quality-assessment"]/div/div[3]/div/ul[2]/div[2]/div[2]'),
        (By.XPATH, '//*[@id="quality-assessment"]/div/div[3]/div/ul[2]/div[3]/div[2]'),
        (By.XPATH, '//*[@id="quality-assessment"]/div/div[3]/div/ul[2]/div[4]/div[2]')
        ]

    LIST_ELEMENTS_STATUS = [
        (By.XPATH, '//*[@id="quality-assessment"]/div/div[3]/div/ul[2]/div[1]/div[5]/b'),
        (By.XPATH, '//*[@id="quality-assessment"]/div/div[3]/div/ul[2]/div[2]/div[5]/b'),
        (By.XPATH, '//*[@id="quality-assessment"]/div/div[3]/div/ul[2]/div[3]/div[5]/b'),
        (By.XPATH, '//*[@id="quality-assessment"]/div/div[3]/div/ul[2]/div[4]/div[5]/b')
        ]
    UNCLASSIFIED_OPTION = (By.XPATH, '//*[@id="paperModalQuality"]/div/div/div[2]/div[3]/label[1]')
    REMOVE_OPTION = (By.XPATH, '//*[@id="paperModalQuality"]/div/div/div[2]/div[3]/label[2]')

    def __init__(self, driver):
        self.driver = driver
        self.wait = WebDriverWait(driver, 10)

    def navigate_to_quality_assessment(self, project_id=224):
        """
        Navega até a aba de condução e acessa a aba Quality Assessment.
        """
        url = self.URL_PATTERN.format(project_id=project_id)
        self.driver.get(url)
        time.sleep(2)  # Aguarda carregamento da página

        # Clica na aba Quality Assessment
        qa_tab = self.wait.until(EC.element_to_be_clickable(self.QUALITY_ASSESSMENT_TAB))
        qa_tab.click()
        time.sleep(2)  # Aguarda carregamento da aba

    def reject_list_element(self, list_id=0):
        """
        Reject Quality Assessment preenchendo as respostas com ENTER após navegar pelas opções usando TAB.
        """
        list_element = self.LIST_ELEMENTS[list_id]

        self.navigate_to_quality_assessment()
        self.driver.find_element(*list_element).click()
        time.sleep(2)

        # Número de interações necessárias (5 a 9 TABs)
        for tab_count in range(5, 10):
            # Envia TABs
            for _ in range(tab_count):
                ActionChains(self.driver).send_keys(Keys.TAB).perform()
                time.sleep(0.2)
            # Confirma a seleção
            ActionChains(self.driver).send_keys(Keys.ENTER).perform()
            time.sleep(0.2)
            ActionChains(self.driver).send_keys(Keys.ENTER).perform()
            time.sleep(0.2)

            # Recarrega a página e reabre o item
            self.navigate_to_quality_assessment()
            self.driver.find_element(*list_element).click()
            time.sleep(2)


    def accept_list_element(self, list_id=1):
            """
            Accept Quality Assessment preenchendo as respostas com ENTER após navegar pelas opções usando TAB.
            """
            list_element = self.LIST_ELEMENTS[list_id]

            self.navigate_to_quality_assessment()
            self.driver.find_element(*list_element).click()
            time.sleep(2)

            # Número de interações necessárias (5 a 9 TABs)
            for tab_count in range(5, 10):
                # Envia TABs
                for _ in range(tab_count):
                    ActionChains(self.driver).send_keys(Keys.TAB).perform()
                    time.sleep(0.2)

                # Confirma a seleção
                ActionChains(self.driver).send_keys(Keys.ENTER).perform()
                time.sleep(0.2)

                for _ in range(4):
                    ActionChains(self.driver).send_keys(Keys.ARROW_DOWN).perform()
                    time.sleep(0.2)

                ActionChains(self.driver).send_keys(Keys.ENTER).perform()
                time.sleep(0.2)

                # Recarrega a página e reabre o item
                self.navigate_to_quality_assessment()
                self.driver.find_element(*list_element).click()
                time.sleep(2)


    def remove_list_element(self, list_id=3):
        """
        Remove um elemento da lista de avaliação de qualidade.
        """
        list_element = self.LIST_ELEMENTS[list_id]

        self.navigate_to_quality_assessment()
        self.driver.find_element(*list_element).click()
        time.sleep(2)

        self.driver.find_element(*self.REMOVE_OPTION).click()
        time.sleep(1)


    def reset_list_element(self, list_id=3):
        """
        Reseta o estado do elemento da lista de avaliação de qualidade.
        """
        list_element = self.LIST_ELEMENTS[list_id]

        self.navigate_to_quality_assessment()
        self.driver.find_element(*list_element).click()
        time.sleep(2)

        self.driver.find_element(*self.UNCLASSIFIED_OPTION).click()
        time.sleep(1)


    def get_status(self, list_id=0):
        """
        Obtém o status do elemento da lista.
        """
        status_element = self.LIST_ELEMENTS_STATUS[list_id]
        status = self.wait.until(EC.visibility_of_element_located(status_element)).text
        return status
