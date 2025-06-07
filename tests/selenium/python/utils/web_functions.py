from selenium.webdriver.common.by import By
from pages.login import LoginPage
from utils.config import USER, PASSWORD

LOGOUT_BUTTON = (By.LINK_TEXT, 'Deslogar')

def login(driver):
    """
    Automatiza o processo de realizar login
    """
    login_page = LoginPage(driver)
    login_page.load()
    login_page.login(USER, PASSWORD)

def logout(driver):
    """
    Automatiza o processo de realizar logout
    """
    driver.find_element(*LOGOUT_BUTTON).click()
