import pytest
from selenium import webdriver

@pytest.fixture
def driver():
    # Inicializa o driver do Chrome
    driver = webdriver.Chrome()
    driver.implicitly_wait(10) # Espera implícita de 10 segundos
    driver.maximize_window()

    # Passa o controle para o teste
    yield driver

    # Fecha o navegador após o teste
    driver.quit()
