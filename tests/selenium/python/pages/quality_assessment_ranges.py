from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.action_chains import ActionChains
from utils.config import BASE_URL
import time

class QualityAssessmentRangesPage:
    URL_PATTERN = BASE_URL + 'project/{project_id}/planning'
    QUALITY_ASSESSMENT_TAB = (By.ID, "quality-assessment-tab")
    
    def __init__(self, driver):
        self.driver = driver
        self.wait = WebDriverWait(driver, 10)

    def navigate_to_quality_assessment_ranges(self, project_id=114):
        """
        Navega para a página de planejamento e acessa a aba Quality Assessment
        """
        url = self.URL_PATTERN.format(project_id=project_id)
        self.driver.get(url)
        time.sleep(3)  # Aguarda carregamento da página
        
        # Clica na aba Quality Assessment
        qa_tab = self.wait.until(EC.element_to_be_clickable(self.QUALITY_ASSESSMENT_TAB))
        qa_tab.click()
        time.sleep(2)  # Aguarda carregamento da aba
        
        # Scroll para baixo para ver a seção dos intervalos
        self.driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
        time.sleep(1)

    def get_max_input(self, index):
        """
        Obtém o elemento input Max pelo índice usando wire:model
        """
        css_selector = f'input[wire\\:model="items.{index}.end"]'
        return self.wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, css_selector)))

    def get_min_input(self, index):
        """
        Obtém o elemento input Min pelo índice usando wire:model
        """
        css_selector = f'input[wire\\:model="items.{index}.start"]'
        return self.wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, css_selector)))

    def get_description_input(self, index):
        """
        Obtém o elemento input Description pelo índice usando wire:model
        """
        css_selector = f'input[wire\\:model="items.{index}.description"]'
        return self.wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, css_selector)))

    def set_max_value(self, index, value):
        """
        Define um valor no campo Max e dispara o evento blur (updateMax)
        """
        max_input = self.get_max_input(index)
        max_input.clear()
        max_input.send_keys(str(value))
        # Dispara o blur event que chama updateMax conforme descoberto
        max_input.send_keys(Keys.TAB)
        time.sleep(2)  # Aguarda processamento do Livewire

    def get_max_value(self, index):
        """
        Obtém o valor atual do campo Max
        """
        max_input = self.get_max_input(index)
        return max_input.get_attribute('value')

    def try_insert_invalid_char_in_max(self, index, char):
        """
        Tenta inserir um caractere inválido no campo Max
        O x-on:keydown deve prevenir a inserção
        """
        max_input = self.get_max_input(index)
        max_input.click()
        
        # Simula exatamente o keydown event
        actions = ActionChains(self.driver)
        actions.send_keys_to_element(max_input, char)
        actions.perform()
        time.sleep(0.5)

    def try_insert_invalid_char_in_min(self, index, char):
        """
        Tenta inserir um caractere inválido no campo Min
        O x-on:keydown deve prevenir a inserção
        """
        min_input = self.get_min_input(index)
        min_input.click()
        
        # Simula exatamente o keydown event
        actions = ActionChains(self.driver)
        actions.send_keys_to_element(min_input, char)
        actions.perform()
        time.sleep(0.5)

    def set_min_value(self, index, value):
        """
        Define um valor no campo Min
        """
        min_input = self.get_min_input(index)
        min_input.clear()
        min_input.send_keys(str(value))
        time.sleep(1)

    def get_min_value(self, index):
        """
        Obtém o valor atual do campo Min
        """
        min_input = self.get_min_input(index)
        return min_input.get_attribute('value')

    def set_description_value(self, index, value):
        """
        Define um valor no campo Description
        """
        desc_input = self.get_description_input(index)
        desc_input.clear()
        desc_input.send_keys(str(value))

    def get_description_value(self, index):
        """
        Obtém o valor atual do campo Description
        """
        desc_input = self.get_description_input(index)
        return desc_input.get_attribute('value')

    def click_save_description(self, index):
        """
        Clica no botão de salvar descrição usando wire:click
        """
        css_selector = f'button[wire\\:click="updateLabel({index})"]'
        save_button = self.wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR, css_selector)))
        save_button.click()
        time.sleep(2)  # Aguarda processamento