from selenium import webdriver
from selenium.webdriver.common.by import By
import time

driver = webdriver.Chrome()


driver.get("http://localhost:8989/projects/1")
time.sleep(3)

body_text = driver.find_element(By.TAG_NAME, "body").text

assert "teste editar" in body_text, "'teste editar' não encontrado no conteúdo do projeto"
print("'teste editar' está presente na descrição ou objetivos.")

driver.quit()
