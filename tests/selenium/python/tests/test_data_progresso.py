import pytest
import time
import re
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from pages.login import LoginPage
from utils.config import USER, PASSWORD
from pages.planning import MenuLateralPage, PlanningPage

@pytest.fixture(scope="function")
def sistema_logado(driver):
    login = LoginPage(driver)
    login.load()
    login.login(USER, PASSWORD)
    time.sleep(2)
    return driver

def test_progresso_aumenta_ao_adicionar_data(sistema_logado):
    driver = sistema_logado
    menu = MenuLateralPage(driver)
    menu.acessar_meus_projetos()
    menu.abrir_primeiro_projeto()
    menu.acessar_overview()

    barra = driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[2]/div/div/div[2]/div/div[1]/span")
    progresso_antes_text = barra.text
    match = re.search(r"([\d.,]+)%", progresso_antes_text)
    assert match, "Não foi possível extrair o valor do progresso da barra."
    progresso_antes = float(match.group(1).replace(",", "."))
    print(f"Progresso antes de adicionar data: {progresso_antes}")

    menu.acessar_aba_planejamento()
    planning = PlanningPage(driver)
    campo_inicio = planning.campo_data_inicio()
    campo_termino = planning.campo_data_termino()
    campo_inicio.clear()
    campo_inicio.send_keys("01/01/2025")
    campo_termino.clear()
    campo_termino.send_keys("31/12/2025")
    planning.botao_salvar_data().click()
    time.sleep(2)

    menu.acessar_overview()
    barra = driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[2]/div/div/div[2]/div/div[1]/span")
    progresso_depois_text = barra.text
    match = re.search(r"([\d.,]+)%", progresso_depois_text)
    assert match, "Não foi possível extrair o valor do progresso da barra."
    progresso_depois = float(match.group(1).replace(",", "."))
    print(f"Progresso após adicionar data: {progresso_depois}")

    assert progresso_depois > progresso_antes, (
        f"O progresso deveria aumentar após adicionar as datas, mas era {progresso_antes} e ficou {progresso_depois}."
    )
