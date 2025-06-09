import time
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from utils.config import BASE_URL, NUMBER_PROJECT

class criteriaPage:
    URL = BASE_URL + 'project/' + NUMBER_PROJECT + '/planning'

    # Localizadores
    ID_CRITERIA_INPUT = (By.ID, 'criteriaId')
    DESCRIPTION_INPUT = (By.XPATH, '/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[6]/div/div[2]/form/div/div[1]/div[2]/div/input')
    CRITERIAS_SECTION = (By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[1]/ul/li[6]/a")
    TYPE_CRITERIA_SELECT = (By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[6]/div/div[2]/form/div/div[2]/div/div/div[1]")
    TABLE_CRITERIA = (By.TAG_NAME, "tr")
    CRITERIA_BUTTON = (By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[6]/div/div[2]/form/div/div[3]/button")
    RULE_CRITERIA_SELECT = (By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[6]/div/div[2]/div/div[1]/div[2]/div/div/div[1]/div")

    def __init__(self, driver):
        self.driver = driver

    def load(self):
        """
        Carrega a página de login
        """
        self.driver.get(self.URL)

    def click_criterias_section(self):
        """
        Clica na seção de critérios
        """
        self.driver.find_element(*self.CRITERIAS_SECTION).click()
        time.sleep(1)

    def create_criteria(self, id_criteria, description, type_criteria):
        """
        Clica no botão para criar um novo critério
        """
        self.click_criterias_section()

        self.driver.find_element(*self.ID_CRITERIA_INPUT).send_keys(id_criteria)
        self.driver.find_element(*self.DESCRIPTION_INPUT).send_keys(description)

        self.select_dropdown_option_by_value(self.TYPE_CRITERIA_SELECT, type_criteria)
        time.sleep(0.5)

        self.driver.find_element(*self.CRITERIA_BUTTON).click()
        time.sleep(1)

    def edit_criteria(self, id_criteria, new_id_criteria, new_description, new_type):
        """
        Clica no botão para editar um critério existente
        """
        self.click_criterias_section()
        criteria_row = self.find_criteria_by_id(id_criteria)

        if criteria_row:
            self.driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")

            time.sleep(1)
            criteria_row.find_element(By.XPATH, './td[4]/button[1]').click()
            time.sleep(1)

            self.driver.find_element(*self.ID_CRITERIA_INPUT).clear()
            self.driver.find_element(*self.ID_CRITERIA_INPUT).send_keys(new_id_criteria)

            self.driver.find_element(*self.DESCRIPTION_INPUT).clear()
            self.driver.find_element(*self.DESCRIPTION_INPUT).send_keys(new_description)

            self.select_dropdown_option_by_value(self.TYPE_CRITERIA_SELECT, new_type)
            time.sleep(0.5)

            self.driver.find_element(*self.CRITERIA_BUTTON).click()
            time.sleep(1)

    def delete_criteria(self, id_criteria):
        """
        Clica no botão para excluir um critério existente
        """
        self.click_criterias_section()

        criteria_row = self.find_criteria_by_id(id_criteria)

        if criteria_row:
            self.driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
            time.sleep(1)

            criteria_row.find_element(By.XPATH, './/td[4]/button[2]').click()
            time.sleep(1)

    def modify_criteria_rule(self, new_rule):
        """
        Modifica a regra de um critério existente
        """
        self.click_criterias_section()
        self.select_dropdown_option_by_value(self.RULE_CRITERIA_SELECT, new_rule)

    def verify_criteria_rule(self, expected_rule):
        """
        Verifica se a regra do critério foi modificada corretamente
        """
        dropdown = self.driver.find_element(*self.RULE_CRITERIA_SELECT)
        option = dropdown.find_element(By.XPATH, ".//div[@data-value]")

        time.sleep(0.5)

        current_rule = option.get_attribute("data-value")

        return current_rule == expected_rule

    def select_dropdown_option_by_value(self, dropdown_locator, option_value):
        """
        Seleciona uma opção de um dropdown pelo valor
        """
        self.driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")

        dropdown = self.driver.find_element(*dropdown_locator)
        time.sleep(0.5)
        dropdown.click()
        time.sleep(0.5)

        option = WebDriverWait(self.driver, 5).until(
            EC.element_to_be_clickable((By.XPATH, f"//div[contains(@role, 'option') and @data-value='{option_value}']"))
        )
        option.click()


    def find_criteria_by_id(self, id_criteria):
        """
        Encontra um critério pelo ID
        """
        rows = self.driver.find_elements(*self.TABLE_CRITERIA)
        for row in rows:
            if id_criteria in row.text:
                return row
        return None
