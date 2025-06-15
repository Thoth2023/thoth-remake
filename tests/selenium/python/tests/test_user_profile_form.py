from selenium.webdriver.common.by import By
import time

# Configurações
URL = "http://localhost:8989"
USER = "admin@admin.com"
PASSWORD = "password"

# Funções
def fazer_login_manual(driver):
    driver.get(f"{URL}/login")
    driver.find_element(By.NAME, "email").send_keys(USER)
    driver.find_element(By.NAME, "password").send_keys(PASSWORD)
    driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()
    time.sleep(30)

def acessar_pagina_perfil(driver):
    driver.get(f"{URL}/profile")
    time.sleep(30)

def habilitar_edicao_formulario(driver):
    botao_editar = driver.find_element(By.ID, "btn-editar")
    botao_editar.click()
    time.sleep(30)

def preencher_campo(driver, nome, valor):
    campo = driver.find_element(By.NAME, nome)
    campo.clear()
    campo.send_keys(valor)

def submeter_form(driver):
    driver.find_element(By.CSS_SELECTOR, "form button[type='submit']").click()
    time.sleep(30)

# Testes

def test_username_too_short(driver):
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)
    habilitar_edicao_formulario(driver)
    preencher_campo(driver, "username", "a")
    submeter_form(driver)
    assert "username" in driver.page_source

def test_firstname_invalid(driver):
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)
    habilitar_edicao_formulario(driver)
    preencher_campo(driver, "firstname", "123@!")
    submeter_form(driver)
    assert "O nome deve conter apenas letras" in driver.page_source

def test_lastname_invalid(driver):
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)
    habilitar_edicao_formulario(driver)
    preencher_campo(driver, "lastname", "456@#")
    submeter_form(driver)
    assert "O sobrenome deve conter apenas letras" in driver.page_source

def test_email_invalid_format(driver):
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)
    habilitar_edicao_formulario(driver)
    preencher_campo(driver, "email", "emailinvalido")
    submeter_form(driver)
    assert "email" in driver.page_source

def test_city_invalid(driver):
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)
    habilitar_edicao_formulario(driver)
    preencher_campo(driver, "city", "123$$")
    submeter_form(driver)
    assert "A cidade deve conter apenas letras" in driver.page_source

def test_country_invalid(driver):
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)
    habilitar_edicao_formulario(driver)
    preencher_campo(driver, "country", "!!123")
    submeter_form(driver)
    assert "O país deve conter apenas letras" in driver.page_source

def test_postal_letters(driver):
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)
    habilitar_edicao_formulario(driver)
    preencher_campo(driver, "postal", "ABCDE")
    submeter_form(driver)
    assert "O CEP deve conter apenas números" in driver.page_source

def test_occupation_invalid(driver):
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)
    habilitar_edicao_formulario(driver)
    preencher_campo(driver, "occupation", "Eng123!!")
    submeter_form(driver)
    assert "A ocupação deve conter apenas letras" in driver.page_source

def test_lattes_link_invalid(driver):
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)
    habilitar_edicao_formulario(driver)
    preencher_campo(driver, "lattes_link", "ht@p://lattes")
    submeter_form(driver)
    assert "O formato do link para o currículo Lattes é inválido" in driver.page_source

def test_habilitar_campos_apos_editar(driver):
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)
    habilitar_edicao_formulario(driver)

    inputs = driver.find_elements(By.CSS_SELECTOR, "form input, form select, form textarea")
    for input_element in inputs:
        assert input_element.is_enabled(), f"O campo {input_element.get_attribute('name')} deveria estar habilitado"

def test_botao_salvar_aparece_apos_editar(driver):
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)

    botao_salvar = driver.find_element(By.ID, "btn-salvar")
    assert not botao_salvar.is_displayed(), "Botão salvar não deveria aparecer antes de clicar em editar"

    habilitar_edicao_formulario(driver)
    assert botao_salvar.is_displayed(), "Botão salvar deveria aparecer após clicar em editar"

def test_formulario_bloqueado_inicialmente(driver):
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)

    inputs = driver.find_elements(By.CSS_SELECTOR, "form input, form select, form textarea")
    for input_element in inputs:
        assert not input_element.is_enabled(), f"O campo {input_element.get_attribute('name')} deveria estar desabilitado inicialmente"

def test_botao_editar_fica_desabilitado(driver):
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)

    botao_editar = driver.find_element(By.ID, "btn-editar")
    botao_editar.click()
    time.sleep(1)

    assert not botao_editar.is_enabled(), "O botão editar deveria estar desabilitado após o clique"

