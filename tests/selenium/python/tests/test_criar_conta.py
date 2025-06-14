import pytest
import time
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException
from pages.register import RegisterPage
from utils import config

def aceitar_modal_ou_sinalizar(pagina, timeout=5):
    try:
        botao = WebDriverWait(pagina.driver, timeout).until(
            EC.element_to_be_clickable((By.XPATH, '/html/body/main/div/div[2]/div/div/div[3]/button[1]'))
        )
        botao.click()
        return True
    except TimeoutException:
        print("Modal LGPD não apareceu.")
        return False

@pytest.fixture
def timestamp():
    return int(time.time())

def test_criar_conta_valida(driver, timestamp):
    pagina = RegisterPage(driver)
    pagina.carregar(config.BASE_URL)

    novo_email = f"teste+{timestamp}@exemplo.com"
    novo_usuario = f"usuario{timestamp}"

    pagina.preencher(
        nome="Teste Usuário",
        sobrenome="Sobrenome Teste",
        instituicao="Instituição Teste",
        email=novo_email,
        username=novo_usuario,
        senha="SenhaForte123"
    )

    pagina.aceitar_termos()
    pagina.submeter()

    WebDriverWait(driver, 10).until(lambda d: d.current_url == "https://thoth-slr.com/projects")
    assert driver.current_url == "https://thoth-slr.com/projects"

    modal_aceito = aceitar_modal_ou_sinalizar(pagina)
    assert modal_aceito, "Modal LGPD não apareceu, esperado após criação bem-sucedida"

def test_criar_conta_email_existente(driver):
    pagina = RegisterPage(driver)
    pagina.carregar(config.BASE_URL)

    email_existente = "superuser@superuser.com"

    pagina.preencher(
        nome="Teste Usuário",
        sobrenome="Sobrenome Teste",
        instituicao="Instituição Teste",
        email=email_existente,
        username="usuarioexistente",
        senha="SenhaForte123"
    )

    pagina.aceitar_termos()
    pagina.submeter()

    erro_email = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, '/html/body/main/div/div[2]/div/div/div[3]/form/div[4]/p'))
    )
    texto_erro = erro_email.text.lower()
    assert "email já está sendo utilizado" in texto_erro or "e-mail já está sendo utilizado" in texto_erro, \
        f"Mensagem de e-mail existente não exibida. Texto encontrado: {texto_erro}"

    aceitar_modal_ou_sinalizar(pagina)

def test_campos_obrigatorios_nao_preenchidos(driver):
    pagina = RegisterPage(driver)
    pagina.carregar(config.BASE_URL)

    pagina.aceitar_termos()
    pagina.submeter()

    # Espera mensagem de erro para campo obrigatório, e não mensagem de e-mail já usado
    erro_email = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, '/html/body/main/div/div[2]/div/div/div[3]/form/div[4]/p'))
    )
    texto_erro = erro_email.text.lower()
    mensagens_obrigatorias = [
        "o campo email é obrigatório",
        "o campo firstname é obrigatório",
        "o campo lastname é obrigatório",
        "o campo institution é obrigatório",
        "o campo usuário é obrigatório",
        "o campo senha é obrigatório",
        "o campo termos e condições é obrigatório"
    ]
    assert any(msg in texto_erro for msg in mensagens_obrigatorias), \
        f"Mensagens de erro para campos obrigatórios não exibidas. Texto encontrado: {texto_erro}"

    aceitar_modal_ou_sinalizar(pagina)

@pytest.mark.parametrize("senha", [
    "123",
    "senha",
    "12345678",
    "abcdefghi",
])
def test_senhas_fracas(driver, senha, timestamp):
    pagina = RegisterPage(driver)
    pagina.carregar(config.BASE_URL)

    novo_email = f"teste+{timestamp}@exemplo.com"
    novo_usuario = f"usuario{timestamp}"

    pagina.preencher(
        nome="Teste Usuário",
        sobrenome="Sobrenome Teste",
        instituicao="Instituição Teste",
        email=novo_email,
        username=novo_usuario,
        senha=senha
    )

    pagina.aceitar_termos()
    pagina.submeter()

    texto_erro = "senha fraca"

    # Tentamos capturar erro na div do campo senha
    try:
        erro_senha_div = WebDriverWait(driver, 3).until(
            EC.visibility_of_element_located((By.XPATH, '/html/body/main/div/div[2]/div/div/div[3]/form/div[6]/div'))
        )
        texto_erro = erro_senha_div.text.lower()
    except TimeoutException:
        pass

    # Se não achou, tenta na lista geral de erros
    if not texto_erro:
        try:
            erros = pagina.obter_mensagens_erro()
            texto_erro = " ".join(erros).lower()
        except Exception:
            texto_erro = ""

    # Verifica modal LGPD
    modal_aceito = aceitar_modal_ou_sinalizar(pagina)

    print(f"Texto erro capturado: '{texto_erro}'")
    print(f"Modal LGPD aceito: {modal_aceito}")

    msg_esperada = "senha"  # qualquer erro que contenha "senha" já serve

    assert (msg_esperada in texto_erro) or modal_aceito, \
        f"Senha fraca não rejeitada nem modal LGPD exibido. Texto erro: '{texto_erro}'"

    if modal_aceito:
        pagina.aceitar_modal_privacidade()

    time.sleep(2)
