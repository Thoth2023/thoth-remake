from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
import time

driver = webdriver.Chrome()

driver.get("http://localhost:8989/projects/1/add-member")
time.sleep(2)

driver.find_element(By.ID, "emailMemberInput").send_keys("colaborador@teste.com")
Select(driver.find_element(By.ID, "levelMemberSelect")).select_by_visible_text("Pesquisador")
driver.find_element(By.XPATH, "//button[contains(text(), 'Adicionar')]").click()

time.sleep(8)

page_text = driver.find_element(By.TAG_NAME, "body").text
assert "colaborador@teste.com" in page_text, "Colaborador não foi adicionado com sucesso"

print("Colaborador adicionado com sucesso!")

driver.quit()
