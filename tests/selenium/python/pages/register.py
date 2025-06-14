from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException

class RegisterPage:
    def __init__(self, driver):
        self.driver = driver
        self.url = "/register"

        self.nome_input = (By.XPATH, '/html/body/main/div/div[2]/div/div/div[3]/form/div[1]/input')
        self.sobrenome_input = (By.XPATH, '/html/body/main/div/div[2]/div/div/div[3]/form/div[2]/input')
        self.instituicao_input = (By.XPATH, '/html/body/main/div/div[2]/div/div/div[3]/form/div[3]/input')
        self.email_input = (By.XPATH, '/html/body/main/div/div[2]/div/div/div[3]/form/div[4]/input')
        self.username_input = (By.XPATH, '/html/body/main/div/div[2]/div/div/div[3]/form/div[5]/input')
        self.senha_input = (By.XPATH, '/html/body/main/div/div[2]/div/div/div[3]/form/div[6]/input')
        self.termos_checkbox = (By.XPATH, '/html/body/main/div/div[2]/div/div/div[3]/form/div[7]/input')
        self.botao_cadastrar = (By.XPATH, '/html/body/main/div/div[2]/div/div/div[3]/form/div[8]/button')

        self.erros = (By.CLASS_NAME, "invalid-feedback")
        self.sucesso = (By.CLASS_NAME, "alert-success")

    def carregar(self, base_url):
        self.driver.get(f"{base_url.rstrip('/')}{self.url}")

    def preencher(self, nome, sobrenome, instituicao, email, username, senha):
        self.driver.find_element(*self.nome_input).send_keys(nome)
        self.driver.find_element(*self.sobrenome_input).send_keys(sobrenome)
        self.driver.find_element(*self.instituicao_input).send_keys(instituicao)
        self.driver.find_element(*self.email_input).send_keys(email)
        self.driver.find_element(*self.username_input).send_keys(username)
        self.driver.find_element(*self.senha_input).send_keys(senha)

    def aceitar_termos(self, timeout=10):
        checkbox = self.driver.find_element(*self.termos_checkbox)
        self.driver.execute_script("arguments[0].scrollIntoView(true);", checkbox)
        try:
            WebDriverWait(self.driver, timeout).until(EC.element_to_be_clickable(self.termos_checkbox))
            try:
                checkbox.click()
            except Exception:
                self.driver.execute_script("arguments[0].click();", checkbox)
        except TimeoutException:
            raise Exception("Checkbox de termos não ficou clicável dentro do tempo esperado.")

    def submeter(self, timeout=10):
        botao = WebDriverWait(self.driver, timeout).until(EC.element_to_be_clickable(self.botao_cadastrar))
        self.driver.execute_script("arguments[0].scrollIntoView(true);", botao)
        try:
            botao.click()
        except Exception:
            self.driver.save_screenshot("erro_clique_submeter.png")
            self.driver.execute_script("arguments[0].click();", botao)

    def aceitar_modal_privacidade(self, timeout=10):
        try:
            botao_entendi = WebDriverWait(self.driver, timeout).until(
                EC.element_to_be_clickable((By.XPATH, '/html/body/main/div/div[2]/div/div/div[3]/button[1]'))
            )
            botao_entendi.click()
        except TimeoutException:
            # Modal não apareceu, ou já foi aceito
            print("Modal de privacidade não apareceu ou já foi aceito.")


    def obter_mensagens_erro(self):
        return [el.text for el in self.driver.find_elements(*self.erros)]

    def obter_mensagem_sucesso(self):
        try:
            return self.driver.find_element(*self.sucesso).text
        except:
            return None
