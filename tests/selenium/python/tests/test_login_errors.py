from pages.login import LoginPage
from pages.about import AboutPage
from pages.index import IndexPage
from utils.config import USER, PASSWORD
from utils.web_functions import login, logout
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.by import By

def test_login_invalid_credentials(driver):
    """
    Verificar se o sistema rejeita login com credenciais inválidas
    """
    login_page = LoginPage(driver)
    login_page.load()
    login_page.login("email_inexistente@teste.com", "senha_incorreta")

    # Resultado esperado: Mensagem de erro de credenciais inválidas
    error_message = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, '//p[contains(@class, "text-danger")]'))
    ).text
    assert "não está cadastrado" in error_message.lower()

def test_login_empty_fields(driver):
    """
    Verificar se o sistema rejeita login com campos vazios
    """
    login_page = LoginPage(driver)
    login_page.load()
    login_page.login("", "")

    # Resultado esperado: Mensagens de erro de campos obrigatórios
    error_messages = driver.find_elements(By.XPATH, '//p[contains(@class, "text-danger")]')
    error_texts = [msg.text.lower() for msg in error_messages]
    
    assert any("o campo email é obrigatório" in text for text in error_texts)
    assert any("o campo senha é obrigatório" in text for text in error_texts)

def test_login_xss_attempt(driver):
    """
    Verificar se o sistema está protegido contra tentativas de XSS
    """
    login_page = LoginPage(driver)
    login_page.load()
    login_page.login("script.alert.xss@test.com", "<script>alert('xss')</script>")

    # Resultado esperado: Login não deve ser bem-sucedido e o script não deve ser executado
    error_message = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, '//p[contains(@class, "text-danger")]'))
    ).text
    assert "não está cadastrado" in error_message.lower()

def test_login_brute_force_protection(driver):
    """
    Verificar se o sistema tem proteção contra tentativas múltiplas de login
    """
    login_page = LoginPage(driver)
    login_page.load()
    
    # Tentar login várias vezes (aumentado para 10 tentativas)
    for _ in range(10):
        login_page.login("test_user@test.com", "wrong_password")
        
    # Resultado esperado: Mensagem de bloqueio temporário ou captcha
    error_message = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, '//p[contains(@class, "text-danger")]'))
    ).text
    assert any(msg in error_message.lower() for msg in ["bloqueado", "temporariamente", "captcha", "muitas tentativas"])