import pytest
import time
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException
from pages.register import RegisterPage
from utils import config

def test_criar_conta_email_existente(driver):
    """
    Verificar se o sistema rejeita email já cadastrado
    """
    pagina = RegisterPage(driver)
    pagina.carregar(config.BASE_URL)

    pagina.preencher(
        nome="Teste Usuário",
        sobrenome="Sobrenome Teste",
        instituicao="Instituição Teste",
        email="superuser@superuser.com",  # Email já existente
        username="usuario_teste",
        senha="SenhaForte123"
    )

    pagina.aceitar_termos()
    pagina.submeter()

    erro_email = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, '//p[contains(@class, "error-message")]'))
    )
    assert "email já está sendo utilizado" in erro_email.text.lower()

def test_campos_obrigatorios_nao_preenchidos(driver):
    """
    Verificar se o sistema rejeita criação de conta com campos obrigatórios vazios
    """
    pagina = RegisterPage(driver)
    pagina.carregar(config.BASE_URL)

    pagina.preencher(
        nome="",
        sobrenome="",
        instituicao="",
        email="",
        username="",
        senha=""
    )

    pagina.aceitar_termos()
    pagina.submeter()

    erro = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, '//p[contains(@class, "error-message")]'))
    )
    assert "campos obrigatórios" in erro.text.lower()

def test_senha_fraca(driver):
    """
    Verificar se o sistema rejeita senhas fracas
    """
    pagina = RegisterPage(driver)
    pagina.carregar(config.BASE_URL)

    pagina.preencher(
        nome="Teste Usuário",
        sobrenome="Sobrenome Teste",
        instituicao="Instituição Teste",
        email="teste@exemplo.com",
        username="usuario_teste",
        senha="123"  # Senha fraca
    )

    pagina.aceitar_termos()
    pagina.submeter()

    erro = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, '//p[contains(@class, "error-message")]'))
    )
    assert "senha fraca" in erro.text.lower()

def test_criar_conta_sem_aceitar_termos(driver):
    """
    Verificar se o sistema rejeita criação de conta sem aceitar os termos
    """
    pagina = RegisterPage(driver)
    pagina.carregar(config.BASE_URL)

    pagina.preencher(
        nome="Teste Usuário",
        sobrenome="Sobrenome Teste",
        instituicao="Instituição Teste",
        email="teste@exemplo.com",
        username="usuario_teste",
        senha="SenhaForte123"
    )

    # Não aceita os termos
    pagina.submeter()

    erro = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, '//p[contains(@class, "error-message")]'))
    )
    assert "termos e condições" in erro.text.lower() 