from selenium import webdriver
from selenium.webdriver.common.by import By
import time

URL = "http://localhost:8989/projects/create"

def iniciar_driver():
    driver = webdriver.Chrome()
    driver.get(URL)
    time.sleep(1.5)
    return driver

def finalizar_driver(driver):
    driver.quit()

def clicar_criar(driver):
    driver.find_element(By.XPATH, "//button[contains(text(), 'Create')]").click()
    time.sleep(1.5)

def existe_erro(driver, campo):
    try:
        erro = driver.find_element(By.XPATH, f"//input[@id='{campo}']/following-sibling::span[contains(@class, 'invalid-feedback')] | //textarea[@id='{campo}']/following-sibling::span[contains(@class, 'invalid-feedback')]")
        return erro.is_displayed()
    except:
        return False

def teste_todos_os_campos_vazios():
    driver = iniciar_driver()
    clicar_criar(driver)

    assert existe_erro(driver, "titleInput"), "Erro: mensagem de validação do título não apareceu"
    assert existe_erro(driver, "descriptionTextarea"), "Erro: mensagem de validação da descrição não apareceu"
    assert existe_erro(driver, "objectivesTextarea"), "Erro: mensagem de validação dos objetivos não apareceu"

    finalizar_driver(driver)

def teste_campo_vazio(campo_id, campo_nome):
    driver = iniciar_driver()

    driver.find_element(By.ID, "titleInput").send_keys("Título válido")
    driver.find_element(By.ID, "descriptionTextarea").send_keys("Descrição válida")
    driver.find_element(By.ID, "objectivesTextarea").send_keys("Objetivos válidos")
    driver.find_element(By.ID, "feature_review1").click()

    driver.find_element(By.ID, campo_id).clear()

    clicar_criar(driver)

    assert existe_erro(driver, campo_id), f"Erro: mensagem de validação de '{campo_nome}' não apareceu"

    finalizar_driver(driver)

if __name__ == "__main__":
    teste_todos_os_campos_vazios()
    teste_campo_vazio("titleInput", "Título")
    teste_campo_vazio("descriptionTextarea", "Descrição")
    teste_campo_vazio("objectivesTextarea", "Objetivos")