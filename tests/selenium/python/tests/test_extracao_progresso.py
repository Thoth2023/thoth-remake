import pytest
import time
import re
from selenium.webdriver.common.by import By
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

def test_progresso_aumenta_ao_adicionar_pergunta_extracao(sistema_logado):
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
    print(f"Progresso antes de adicionar pergunta de extração: {progresso_antes}")

    menu.acessar_aba_planejamento()
    menu.acessar_aba_extracao()
    planning = PlanningPage(driver)
    campo_id = planning.campo_extracao_id()
    campo_descricao = planning.campo_extracao_descricao()
    campo_id.clear()
    campo_id.send_keys("2")
    campo_descricao.clear()
    campo_descricao.send_keys("Pergunta de extração de teste")
    planning.selecionar_extracao_tipo("Text")
    planning.botao_salvar_extracao().click()
    time.sleep(2)

    menu.acessar_overview()
    barra = driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[2]/div/div/div[2]/div/div[1]/span")
    progresso_depois_text = barra.text
    match = re.search(r"([\d.,]+)%", progresso_depois_text)
    assert match, "Não foi possível extrair o valor do progresso da barra."
    progresso_depois = float(match.group(1).replace(",", "."))
    print(f"Progresso após adicionar pergunta de extração: {progresso_depois}")

    assert progresso_depois > progresso_antes, (
        f"O progresso deveria aumentar após adicionar pergunta de extração, mas era {progresso_antes} e ficou {progresso_depois}."
        )
