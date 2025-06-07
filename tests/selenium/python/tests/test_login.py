from pages.login import LoginPage
from pages.about import AboutPage
from pages.index import IndexPage
from utils.config import USER, PASSWORD
from utils.web_functions import login, logout

# SeTC002.1 - Realizar Login
def test_login(driver):
    """
    Verificar se é possível realizar login a partir de um usuário fixo.
    """
    login_page = LoginPage(driver)
    login_page.load()
    login_page.login(USER, PASSWORD)

    # Resultado esperado: Uma sessão do usuário exemplo é iniciada no sistema.
    about_page = AboutPage(driver)
    message = about_page.get_about_us_text()
    assert "Sobre nós" in message, "Login failed or welcome message not found."

# SeTC002.2 - Realizar Logout
def test_logout(driver):
    """
    Verificar se é possível realizar logout do sistema.
    """
    login(driver)
    logout(driver)

    # Resultado esperado: A sessão do usuário é encerrada
    index_page = IndexPage(driver)
    message = index_page.get_welcome_text()
    assert "Bem-vindo!" in message, "Logout failed or welcome message not found."
