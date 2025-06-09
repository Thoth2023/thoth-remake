# Importa o localizador 'By' da biblioteca Selenium, que permite identificar elementos por ID, TAG_NAME, CSS_SELECTOR etc.
from selenium.webdriver.common.by import By

class PerfilPage:
    """
    Classe que representa a página de perfil no sistema web.
    Fornece métodos para acessar a página e interagir com elementos da interface.
    """
    
    def __init__(self, driver):
        """
        Inicializa a página com o driver do Selenium e define a URL da página de perfil.
        """
        self.driver = driver
        self.url = "http://localhost:8000/perfil"

    def acessar(self):
        """
        Acessa a URL da página de perfil usando o driver do navegador.
        """
        self.driver.get(self.url)

    def botao_toggle_tema(self):
        """
        Retorna o elemento do botão que alterna entre os modos claro e escuro da interface.

        Retorna:
        WebElement: Elemento do botão de alternância de tema.
        """
        return self.driver.find_element(By.ID, 'modo-claro-escuro')

    def body(self):
        """
        Retorna o elemento da tag <body> da página.

        Retorna:
        WebElement: Elemento <body> da página.
        """
        return self.driver.find_element(By.TAG_NAME, 'body')

    def barra_lateral(self):
        """
        Retorna o elemento da barra lateral da interface (normalmente um <aside>).

        Retorna:
        WebElement: Elemento <aside> representando a barra lateral.
        """
        return self.driver.find_element(By.CSS_SELECTOR, 'aside')

    def botao_cor_personalizada(self, cor_id: str):
        """
        Retorna um botão de cor personalizada com base no ID fornecido.

        Parâmetros:
        cor_id (str): O ID do botão de cor desejado.

        Retorna:
        WebElement: Elemento do botão de cor correspondente.
        """
        return self.driver.find_element(By.ID, cor_id)
