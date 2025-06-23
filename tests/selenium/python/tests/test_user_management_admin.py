import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

driver = webdriver.Chrome()
driver.get("http://localhost:8989/user-manager")  
wait = WebDriverWait(driver, 10)

try:
    add_user_button = wait.until(EC.element_to_be_clickable((By.LINK_TEXT, "Adicionar Usuário")))
    add_user_button.click()
    assert "/user/create" in driver.current_url.lower()
    print("Botão 'Adicionar Usuário' funcional.")

    driver.back()

    edit_buttons = wait.until(EC.presence_of_all_elements_located((By.XPATH, "//a[contains(text(),'Editar')]")))
    if edit_buttons:
        edit_buttons[0].click()
        assert "edit" in driver.current_url.lower()
        print("Botão 'Editar' funcionando.")
    else:
        print("Nenhum botão 'Editar' encontrado.")

    driver.back()

    toggle_buttons = wait.until(EC.presence_of_all_elements_located(
        (By.XPATH, "//a[contains(text(),'Ativar') or contains(text(),'Desativar')]")
    ))
    if toggle_buttons:
        toggle_buttons[0].click()
        print("Ativar/Desativar' funciona.")
    else:
        print("Nenhum botão 'Ativar/Desativar' encontrado.")

finally:
    time.sleep(2)
    driver.quit()
