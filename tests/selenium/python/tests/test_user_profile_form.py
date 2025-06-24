from selenium.webdriver.common.by import By
import time

# Configurações de ambiente de teste
URL = "http://localhost:8989"  # URL base da aplicação
USER = "admin@admin.com"       # Usuário de teste
PASSWORD = "password"          # Senha de teste

# Funções auxiliares para manipular o navegador durante os testes

def fazer_login_manual(driver):
    """
    Realiza o login manual na aplicação.
    Navega até a página de login, preenche email e senha e envia o formulário.
    """
    driver.get(f"{URL}/login")
    driver.find_element(By.NAME, "email").send_keys(USER)
    driver.find_element(By.NAME, "password").send_keys(PASSWORD)
    driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()
    time.sleep(30)  # Aguarda carregamento da página (ajuste conforme necessário)

def acessar_pagina_perfil(driver):
    """
    Navega diretamente para a página de perfil do usuário.
    """
    driver.get(f"{URL}/profile")
    time.sleep(30)

def habilitar_edicao_formulario(driver):
    """
    Clica no botão 'Editar' para habilitar os campos do formulário.
    """
    botao_editar = driver.find_element(By.ID, "btn-editar")
    botao_editar.click()
    time.sleep(30)

def preencher_campo(driver, nome, valor):
    """
    Preenche um campo do formulário com o valor especificado.
    """
    campo = driver.find_element(By.NAME, nome)
    campo.clear()
    campo.send_keys(valor)

def submeter_form(driver):
    """
    Submete o formulário clicando no botão de submit.
    """
    driver.find_element(By.CSS_SELECTOR, "form button[type='submit']").click()
    time.sleep(30)

# ---------------------------
# Testes de validação de campos
# ---------------------------

def test_username_too_short(driver):
    """
    Testa envio de username com tamanho inválido (menor que 2 caracteres).
    Espera receber erro de validação.
    """
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)
    habilitar_edicao_formulario(driver)
    preencher_campo(driver, "username", "a")
    submeter_form(driver)
    assert "username" in driver.page_source

def test_firstname_invalid(driver):
    """
    Testa envio de firstname com caracteres inválidos (números e símbolos).
    """
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)
    habilitar_edicao_formulario(driver)
    preencher_campo(driver, "firstname", "123@!")
    submeter_form(driver)
    assert "O nome deve conter apenas letras" in driver.page_source

def test_lastname_invalid(driver):
    """
    Testa envio de lastname com caracteres inválidos.
    """
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)
    habilitar_edicao_formulario(driver)
    preencher_campo(driver, "lastname", "456@#")
    submeter_form(driver)
    assert "O sobrenome deve conter apenas letras" in driver.page_source

def test_email_invalid_format(driver):
    """
    Testa envio de e-mail em formato inválido.
    """
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)
    habilitar_edicao_formulario(driver)
    preencher_campo(driver, "email", "emailinvalido")
    submeter_form(driver)
    assert "email" in driver.page_source

def test_city_invalid(driver):
    """
    Testa envio de cidade com caracteres inválidos.
    """
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)
    habilitar_edicao_formulario(driver)
    preencher_campo(driver, "city", "123$$")
    submeter_form(driver)
    assert "A cidade deve conter apenas letras" in driver.page_source

def test_country_invalid(driver):
    """
    Testa envio de país com caracteres inválidos.
    """
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)
    habilitar_edicao_formulario(driver)
    preencher_campo(driver, "country", "!!123")
    submeter_form(driver)
    assert "O país deve conter apenas letras" in driver.page_source

def test_postal_letters(driver):
    """
    Testa envio de CEP com letras (deve aceitar apenas números).
    """
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)
    habilitar_edicao_formulario(driver)
    preencher_campo(driver, "postal", "ABCDE")
    submeter_form(driver)
    assert "O CEP deve conter apenas números" in driver.page_source

def test_occupation_invalid(driver):
    """
    Testa envio de ocupação com caracteres inválidos.
    """
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)
    habilitar_edicao_formulario(driver)
    preencher_campo(driver, "occupation", "Eng123!!")
    submeter_form(driver)
    assert "A ocupação deve conter apenas letras" in driver.page_source

def test_lattes_link_invalid(driver):
    """
    Testa envio de link inválido no campo lattes_link.
    """
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)
    habilitar_edicao_formulario(driver)
    preencher_campo(driver, "lattes_link", "ht@p://lattes")
    submeter_form(driver)
    assert "O formato do link para o currículo Lattes é inválido" in driver.page_source

# ---------------------------
# Testes de funcionalidade da interface (botões e estados)
# ---------------------------

def test_habilitar_campos_apos_editar(driver):
    """
    Verifica se todos os campos do formulário ficam habilitados após clicar no botão 'Editar'.
    """
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)
    habilitar_edicao_formulario(driver)

    inputs = driver.find_elements(By.CSS_SELECTOR, "form input, form select, form textarea")
    for input_element in inputs:
        assert input_element.is_enabled(), f"O campo {input_element.get_attribute('name')} deveria estar habilitado"

def test_botao_salvar_aparece_apos_editar(driver):
    """
    Verifica se o botão 'Salvar' só aparece após clicar em 'Editar'.
    """
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)

    botao_salvar = driver.find_element(By.ID, "btn-salvar")
    assert not botao_salvar.is_displayed(), "Botão salvar não deveria aparecer antes de clicar em editar"

    habilitar_edicao_formulario(driver)
    assert botao_salvar.is_displayed(), "Botão salvar deveria aparecer após clicar em editar"

def test_formulario_bloqueado_inicialmente(driver):
    """
    Garante que todos os campos do formulário estejam desabilitados ao abrir a página.
    """
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)

    inputs = driver.find_elements(By.CSS_SELECTOR, "form input, form select, form textarea")
    for input_element in inputs:
        assert not input_element.is_enabled(), f"O campo {input_element.get_attribute('name')} deveria estar desabilitado inicialmente"

def test_botao_editar_fica_desabilitado(driver):
    """
    Verifica se o botão 'Editar' fica desabilitado após ser clicado, evitando múltiplos cliques.
    """
    fazer_login_manual(driver)
    acessar_pagina_perfil(driver)

    botao_editar = driver.find_element(By.ID, "btn-editar")
    botao_editar.click()
    time.sleep(1)

    assert not botao_editar.is_enabled(), "O botão editar deveria estar desabilitado após o clique"
