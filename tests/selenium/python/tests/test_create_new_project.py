from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
import time

driver = webdriver.Chrome()

driver.get("http://localhost:8989/projects/create")
time.sleep(7)  

driver.find_element(By.ID, "titleInput").send_keys("teste criar")
driver.find_element(By.ID, "descriptionTextarea").send_keys("teste criar")
driver.find_element(By.ID, "objectivesTextarea").send_keys("teste criar")

driver.find_element(By.ID, "feature_review1").click()
driver.find_element(By.XPATH, "//button[contains(text(), 'Create')]").click()

time.sleep(8)

assert "/projects" in driver.current_url, "Erro: Não redirecionou para a lista de projetos"
body_text = driver.find_element(By.TAG_NAME, "body").text
assert "teste editar" in body_text, "Erro: Projeto 'teste editar' não encontrado na lista"

print("Projeto criado e validado com sucesso!")

driver.quit()
