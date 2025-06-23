import time
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.select import Select
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.action_chains import ActionChains
from utils.config import BASE_URL

class DataExtraction:
    URL_PATTERN = BASE_URL + 'project/{project_id}/conducting'
    DATA_EXTRACTION_TAB = (By.ID, "data-extraction-tab")

    LIST_ELEMENTS = [
        (By.XPATH, '//*[@id="data-extraction"]/div/div[3]/div/ul[2]/div[1]/div[2]'),
        (By.XPATH, '//*[@id="data-extraction"]/div/div[3]/div/ul[2]/div[2]/div[2]'),
        (By.XPATH, '//*[@id="data-extraction"]/div/div[3]/div/ul[2]/div/3/div[2]'),
        (By.XPATH, '//*[@id="data-extraction"]/div/div[3]/div/ul[2]/div/4/div[2]')
    ]

    LIST_ELEMENTS_STATUS = [
        (By.XPATH, '//*[@id="data-extraction"]/div/div[3]/div/ul[2]/div[1]/div[5]/b'),
        (By.XPATH, '//*[@id="data-extraction"]/div/div[3]/div/ul[2]/div/2/div[5]/b'),
        (By.XPATH, '//*[@id="data-extraction"]/div/div[3]/div/ul[2]/div/3/div[5]/b'),
        (By.XPATH, '//*[@id="data-extraction"]/div/div[3]/div/ul[2]/div/4/div[5]/b')
    ]

    def __init__(self, driver):
        self.driver = driver
        self.wait = WebDriverWait(driver, 10)

    def navigate_to_data_extraction(self, project_id=224):
        """
        Navega até a aba de condução e acessa a aba Data Extraction.
        """
        url = self.URL_PATTERN.format(project_id=project_id)
        self.driver.get(url)
        time.sleep(2)

        # Clica na aba Data Extraction
        de_tab = self.wait.until(EC.element_to_be_clickable(self.DATA_EXTRACTION_TAB))
        de_tab.click()
        time.sleep(2)

    def fill_study(self, driver, list_id=0):
        """
        Preenche os dados do estudo na aba Data Extraction, reabrindo o item após cada envio.
        """
        list_element = self.LIST_ELEMENTS[list_id]

        actions = ActionChains(self.driver)

        # Navega até a aba Data Extraction
        self.navigate_to_data_extraction()
        self.driver.find_element(*list_element).click()
        time.sleep(2)

        # Preenche os campos do modal
        editor = self.driver.find_element(By.CSS_SELECTOR, ".w-100:nth-child(2) .ql-editor")
        self.driver.execute_script(
            "if(arguments[0].contentEditable === 'true') { arguments[0].innerText = 'Texto de teste automatizado' }",
            editor
            )
        time.sleep(2)
        self.driver.find_element(By.XPATH, "//button[@class='btn']").click()
        time.sleep(2)
        #recarrega a página e reabre o item
        self.navigate_to_data_extraction()
        self.driver.find_element(*list_element).click()
        time.sleep(2)

        # seleciona o checkbox de preenchimento
        checkbox = self.driver.find_element(By.XPATH, f'//*[@id="paperModalExtraction"]/div/div/div[2]/ul/div[4]/label[1]')
        if not checkbox.is_selected():
            checkbox.click()
        time.sleep(2)

        #recarrega a página e reabre o item
        self.navigate_to_data_extraction()
        self.driver.find_element(*list_element).click()
        time.sleep(2)

        #clicar no selects de opções
        select_elements = self.driver.find_elements(By.XPATH, '//div[@class="choices__item choices__item--selectable"][normalize-space()="Opção 2"]')
        for select_element in select_elements:
            select_element.click()
            time.sleep(1)

        #recarrega a página e reabre o item
        self.navigate_to_data_extraction()
        self.driver.find_element(*list_element).click()
        time.sleep(2)


    def get_status(self, list_id=0):
        """
        Obtém o status do estudo na aba Data Extraction.
        """
        status_element = self.LIST_ELEMENTS_STATUS[list_id]
        status = self.driver.find_element(*status_element).text
        return status

    def reset_study(self, list_id=0):
        """
        Reseta os dados do estudo na aba Data Extraction.
        """
        self.navigate_to_data_extraction()

        # Reabre o modal do paper
        list_element = self.LIST_ELEMENTS[list_id]
        self.driver.find_element(*list_element).click()
        time.sleep(2)
        # Clica no botão de reset de status
        reset_button = self.driver.find_element(By.XPATH, f'//*[@id="paperModalExtraction"]/div/div/div[2]/div[2]/label[1]')
        reset_button.click()
        time.sleep(2)
        # Confirma o reset do status do paper
        confirm_button = self.wait.until(EC.element_to_be_clickable((By.XPATH, '//*[@id="successModalExtraction"]/div/div/div[3]/button')))
        confirm_button.click()
        time.sleep(2)

    def accept_study(self, list_id=0):
        """
        Aceita os dados do estudo na aba Data Extraction.
        """
        self.navigate_to_data_extraction()

        # Reabre o modal do paper
        list_element = self.LIST_ELEMENTS[list_id]
        self.driver.find_element(*list_element).click()
        time.sleep(2)
        # Clica no botão de aceitar status
        accept_button = self.driver.find_element(By.XPATH, f'//*[@id="paperModalExtraction"]/div/div/div[2]/div[2]/label[2]')
        accept_button.click()
        time.sleep(2)
        # Confirma a aceitação do status do paper
        confirm_button = self.wait.until(EC.element_to_be_clickable((By.XPATH, '//*[@id="successModalExtraction"]/div/div/div[3]/button')))
        confirm_button.click()
        time.sleep(2)

    def remove_study(self, list_id=0):
        """
        Remove o estudo na aba Data Extraction.
        """
        self.navigate_to_data_extraction()

        # Reabre o modal do paper
        list_element = self.LIST_ELEMENTS[list_id]
        self.driver.find_element(*list_element).click()
        time.sleep(2)
        # Clica no botão de remover status
        remove_button = self.driver.find_element(By.XPATH, f'//*[@id="paperModalExtraction"]/div/div/div[2]/div[2]/label[3]')
        remove_button.click()
        time.sleep(2)
        # Confirma a remoção do status do paper
        confirm_button = self.wait.until(EC.element_to_be_clickable((By.XPATH, '//*[@id="successModalExtraction"]/div/div/div[3]/button')))
        confirm_button.click()
        time.sleep(2)
