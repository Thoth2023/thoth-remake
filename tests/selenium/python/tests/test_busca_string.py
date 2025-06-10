import pytest
from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.options import Options
from pages.index import IndexPage
from utils.web_functions import login  # supõe que login já preenche e envia login

@pytest.fixture
def driver():
    options = Options()
    options.add_argument('--headless')  # pode tirar o headless pra debugar
    service = Service()
    driver = webdriver.Chrome(service=service, options=options)
    yield driver
    driver.quit()

def test_busca_por_termo(driver):
    driver.get("https://thoth-slr.com")

    # Login via função já existente que usa dados de config.py
    login(driver)

    pagina = IndexPage(driver)

    # Entrar em Projetos
    pagina.clicar_projetos()

    # Abrir projeto - pode ser o primeiro da lista ou pelo nome
    pagina.clicar_abrir_projeto()  # implemente no page object

    # Ir para aba Planejamento
    pagina.clicar_planejamento()

    # Clicar para abrir busca de termos
    pagina.clicar_busca_termos()

    # Escrever o termo que quer adicionar
    termo = "documento"
    pagina.escrever_termo(termo)

    # Clicar em adicionar termo
    pagina.clicar_adicionar_termo()

    # Verificação que o termo apareceu na lista (você pode adaptar)
    assert pagina.termo_aparece(termo), f"O termo '{termo}' não foi adicionado corretamente."
