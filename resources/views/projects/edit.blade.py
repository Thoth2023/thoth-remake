from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
import time

driver = webdriver.Chrome()

driver.get("http://localhost:8989/projects/1/edit")
time.sleep(7)

# Preenche os campos com "teste editar"
driver.find_element(By.ID, "titleInput").clear()
driver.find_element(By.ID, "titleInput").send_keys("teste editar")

driver.find_element(By.ID, "descriptionTextarea").clear()
driver.find_element(By.ID, "descriptionTextarea").send_keys("teste editar")

driver.find_element(By.ID, "objectivesTextarea").clear()
driver.find_element(By.ID, "objectivesTextarea").send_keys("teste editar")

select = Select(driver.find_element(By.ID, "copy_planning"))
select.select_by_visible_text("Nenhum")

driver.find_element(By.ID, "feature_review1").click()

driver.find_element(By.XPATH, "//button[contains(text(), 'Editar')]").click()

time.sleep(7)

assert "/projects" in driver.current_url, "Erro: Não redirecionou para a lista de projetos"


body_text = driver.find_element(By.TAG_NAME, "body").text
assert "teste editar" in body_text, "Erro: Projeto 'teste editar' não encontrado na lista"

print("Projeto criado e editado com sucesso!")
driver.quit()
