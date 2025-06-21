from selenium.webdriver.common.by import By
from pages.login import LoginPage
from pages.projects.index import ProjectsPage
from pages.projects.create import CreateProjectPage
from utils.config import USER, PASSWORD

LOGOUT_BUTTON = (By.LINK_TEXT, 'Deslogar')

def login(driver):
    """
    Automatiza o processo de realizar login
    """
    login_page = LoginPage(driver)
    login_page.load()
    login_page.login(USER, PASSWORD)

def login_with_credentials(driver, user, password):
    """
    Automatiza o processo de realizar login com credenciais
    """
    login_page = LoginPage(driver)
    login_page.load()
    login_page.login(user, password)

def logout(driver):
    """
    Automatiza o processo de realizar logout
    """
    driver.find_element(*LOGOUT_BUTTON).click()

def create_project(driver, title, description, objectives):
    """
    Automatiza o processo de criação de projeto
    """
    projects_page = ProjectsPage(driver)
    projects_page.load()
    projects_page.create_project()

    create_project_page = CreateProjectPage(driver)
    create_project_page.create(title, description, objectives)
