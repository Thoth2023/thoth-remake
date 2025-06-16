from pages.login import LoginPage
from pages.about import AboutPage
from pages.index import IndexPage
from utils.config import USER, PASSWORD
from selenium.webdriver.common.by import By
from utils.config import BASE_URL
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from utils.web_functions import login, logout
import time

class ChatPage:
    URL = BASE_URL + 'login'

    EMAIL_INPUT = (By.NAME, 'email')
    PASSWORD_INPUT = (By.NAME, 'password')
    LOGIN_BUTTON = (By.XPATH, "/html/body/main/section/div/div/div/div[1]/div/div[2]/form/div[4]/button")

    MY_PROJECTS_BUTOON = (By.XPATH, "/html/body/aside/div[2]/ul/li[2]/a")

    OPEN_CHAT = (By.XPATH, "/html/body/main/div/div/div[3]/div[1]")
    CHAT_TEXT_AREA = (By.XPATH, "/html/body/main/div/div/div[3]/div[2]/div[2]/div[2]/textarea")
    CHAT_SEND_BUTTON = (By.XPATH, "/html/body/main/div/div/div[3]/div[2]/div[2]/div[2]/button")

    CHAT_RESPOND_BUTTON = (By.XPATH, "/html/body/main/div/div/div[3]/div[2]/div[1]/div[7]/div/button")


    def __init__(self, driver):
        self.driver = driver
        login(driver)

    def open_project(self, name):
        """
        Entra em um projeto
        """

        self.driver.implicitly_wait(2)

        self.driver.find_element(*self.MY_PROJECTS_BUTOON).click()

        project_list_path = "/html/body/main/div/div[1]/div/div/div/div/div[2]/div/table/tbody/tr"

        project_rows = self.driver.find_elements(By.XPATH, project_list_path)

        for i in range(1, len(project_rows) + 1):
            project_name_xpath = f"{project_list_path}[{i}]/td[1]/div/div/h6"
            project_locator = (By.XPATH, project_name_xpath)

            try:
                name_element = self.driver.find_element(*project_locator)

                nome_do_projeto = name_element.text.strip()

                if nome_do_projeto.lower() == name.strip().lower():

                    project_open_button = f"{project_list_path}[{i}]/td[4]/div/div[1]/a[1]"
                    project_button_open_locator = (By.XPATH, project_open_button)

                    self.driver.find_element(*project_button_open_locator).click()
                    break

            except Exception as e:
                print(f"Erro ao acessar o projeto na linha {i}: {e}")

    def verify_open_chat(self):
        """
        Abre o chat
        """

        wait = WebDriverWait(self.driver, 10)

        wait.until(EC.element_to_be_clickable(self.OPEN_CHAT)).click()

        chat_text_area = wait.until(EC.visibility_of_element_located(self.CHAT_TEXT_AREA))

        elements = self.driver.find_elements(*self.CHAT_TEXT_AREA)

        return elements

    def verify_chat_closed(self):
        """
        Verifica se o chat está fechado
        """

        wait = WebDriverWait(self.driver, 10)

        wait.until(EC.invisibility_of_element_located(self.CHAT_TEXT_AREA))

        chat_area = self.driver.find_element(*self.CHAT_TEXT_AREA)
        return not chat_area.is_displayed()  # retorna True se estiver invisível


    def send_empty_message(self):
        """
        Faz o envio de uma mensagem vazia
        """
        wait = WebDriverWait(self.driver, 2)

        wait.until(EC.element_to_be_clickable(self.OPEN_CHAT)).click()

        chat_text_area = wait.until(EC.visibility_of_element_located(self.CHAT_TEXT_AREA))
        chat_text_area.clear()

        messages_before = self.driver.find_elements(By.XPATH, "//div[@class='chat-text']")
        num_before = len(messages_before)

        wait.until(EC.element_to_be_clickable(self.CHAT_SEND_BUTTON)).click()

        WebDriverWait(self.driver, 3).until(lambda driver: True)

        messages_after = self.driver.find_elements(By.XPATH, "//div[@class='chat-text']")
        num_after = len(messages_after)

        return num_before == num_after


    def send_long_message(self, message):
        """
        Envia uma mensagem com muitos caracteres
        """
        long_message = message * 15
        return self.send_message(long_message)


    def send_message(self, message):
        """
        Envia uma mensagem
        """

        wait = WebDriverWait(self.driver, 2)

        wait.until(EC.element_to_be_clickable(self.OPEN_CHAT)).click()

        chat_text_area = wait.until(EC.visibility_of_element_located(self.CHAT_TEXT_AREA))

        chat_text_area.send_keys(message)

        wait.until(EC.element_to_be_clickable(self.CHAT_SEND_BUTTON)).click()

        def message_appeared(driver):
            elements = driver.find_elements(By.XPATH, f"//div[@class='chat-text'][contains(., '{message}')]")
            return elements[-1] if elements else False

        last_message_element = WebDriverWait(self.driver, 10).until(message_appeared)
        return last_message_element.text


    def reply_message(self, message):
        """
        Responde a uma mensagem
        """
        wait = WebDriverWait(self.driver, 10)

        wait.until(EC.element_to_be_clickable(self.OPEN_CHAT)).click()

        wait.until(EC.element_to_be_clickable(self.CHAT_RESPOND_BUTTON)).click()

        chat_text_area = wait.until(EC.visibility_of_element_located(self.CHAT_TEXT_AREA))
        chat_text_area.send_keys(message)

        wait.until(EC.element_to_be_clickable(self.CHAT_SEND_BUTTON)).click()

        def message_appeared(driver):
            elements = driver.find_elements(By.XPATH, f"//div[contains(@class, 'chat-text')][contains(., '{message}')]")
            return elements[0] if elements else False

        response_element = WebDriverWait(self.driver, 10).until(message_appeared)

        return response_element.text

