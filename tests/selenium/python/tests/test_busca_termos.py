import pytest
from selenium import webdriver
from utils import config
from pages.login import LoginPage
from pages.index import ProjetoPage

@pytest.fixture
def driver():
    driver = webdriver.Chrome()
    driver.maximize_window()
    yield driver
    driver.quit()

def test_termo_de_busca(driver):
    login_page = LoginPage(driver)
    projeto_page = ProjetoPage(driver)

    # 1. Login
    login_page.acessar(config.base_url)
    login_page.preencher_email(config.user_email)
    login_page.preencher_senha(config.user_password)
    login_page.clicar_entrar()

    # 2. Acessar Projeto → Abrir → Planejamento
    projeto_page.entrar_em_projetos()
    projeto_page.clicar_em_abrir()
    projeto_page.clicar_em_planejamento()

    # 3. Testar termos de busca
    termos = ["teste", "automação", "Selenium", "exemplo"]

    for termo in termos:
        projeto_page.escrever_termo_de_busca(termo)
        projeto_page.clicar_em_adicionar_termo()
        
