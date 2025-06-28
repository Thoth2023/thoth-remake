from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

class PlanningPage:
    def __init__(self, driver):
        self.driver = driver

    def campo_dominio(self):
        return self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[1]/div[1]/div[2]/form/div[1]/div/input")

    def botao_salvar_dominio(self):
        return self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[1]/div[1]/div[2]/form/div[2]/button")

    def dominio_esta_listado(self, descricao):
        elementos = self.driver.find_elements(By.XPATH, "//span[contains(text(), '{}')]".format(descricao))
        return len(elementos) > 0
    
    def remover_dominio(self):
        try:
            botao_remover = self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[1]/div[1]/div[2]/div/div/div/button[2]/i")
            botao_remover.click()
            return True
        except Exception:
            return False

    def mensagem_erro_visivel(self):
        return bool(self.driver.find_elements(By.CLASS_NAME, "text-danger"))

    def selecionar_idioma(self, idioma):
            campo = self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[1]/div[2]/div[2]/form/div[1]/div/div/div[1]/div/div")
            campo.click()
            opcao = WebDriverWait(self.driver, 5).until(
                EC.visibility_of_element_located(
                    (By.XPATH, f"//div[contains(@class, 'choices__item--choice') and normalize-space(text())='{idioma}']")
                )
            )
            opcao.click()

    def botao_salvar_idioma(self):
        return self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[1]/div[2]/div[2]/form/div[2]/button")

    def idioma_esta_listado(self, idioma):
        return idioma in self.driver.page_source

    def remover_idioma(self):
        try:
            debugbar_btn = self.driver.find_element(By.CLASS_NAME, "phpdebugbar-maximize-btn")
            debugbar_btn.click()
            time.sleep(1)
        except Exception:
            pass
        botao_remover = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[1]/div[2]/div[2]/div/div/div/button/i"))
        )
        self.driver.execute_script("arguments[0].scrollIntoView();", botao_remover)
        time.sleep(0.5)
        botao_remover.click()

    def selecionar_tipo_estudo(self, tipo_estudo):
        campo = self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[1]/div[3]/div[2]/form/div[1]/div/div/div[1]/div/div")
        campo.click()
        opcao = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located(
                (By.XPATH, f"//div[contains(@class, 'choices__item--choice') and normalize-space(text())='{tipo_estudo}']")
            )
        )
        opcao.click()

    def botao_salvar_estudo(self):
        return self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[1]/div[3]/div[2]/form/div[2]/button")

    def tipo_estudo_esta_listado(self, tipo_estudo):
        return tipo_estudo in self.driver.page_source

    def remover_estudo(self):
        try:
            debugbar_btn = self.driver.find_element(By.CLASS_NAME, "phpdebugbar-maximize-btn")
            debugbar_btn.click()
            time.sleep(1)
        except Exception:
            pass
        botao_remover = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[1]/div[3]/div[2]/div/div/div/button/i"))
        )
        self.driver.execute_script("arguments[0].scrollIntoView();", botao_remover)
        time.sleep(0.5)
        botao_remover.click()

    def campo_palavra_chave(self):
        return self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[1]/div[4]/div[2]/form/div[1]/div/input")

    def botao_salvar_palavra_chave(self):
        return self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[1]/div[4]/div[2]/form/div[2]/button")

    def palavra_chave_esta_listada(self, descricao):
        return descricao in self.driver.page_source
    
    def remover_palavra_chave(self):
        try:
            debugbar_btn = self.driver.find_element(By.CLASS_NAME, "phpdebugbar-maximize-btn")
            debugbar_btn.click()
            time.sleep(1)
        except Exception:
            pass
        botao_remover = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[1]/div[4]/div[2]/div/div/div/button[2]/i"))
        )
        self.driver.execute_script("arguments[0].scrollIntoView();", botao_remover)
        time.sleep(0.5)
        botao_remover.click()

    def campo_data_inicio(self):
        return self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[2]/div/div[2]/form/div[1]/div[1]/input")

    def campo_data_termino(self):
        return self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[2]/div/div[2]/form/div[1]/div[2]/input")

    def botao_salvar_data(self):
        return self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[1]/div/div[2]/div/div[2]/form/div[2]/button")
    
    def campo_questao_pesquisa_id(self):
        return self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[2]/div/div[2]/form/div/div[1]/input")
    
    def campo_questao_pesquisa_descricao(self):
        return self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[2]/div/div[2]/form/div/div[2]/textarea")

    def botao_salvar_questao_pesquisa(self):
        return self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[2]/div/div[2]/form/button")
    
    def questao_pesquisa_esta_listada(self, descricao):
        return descricao in self.driver.page_source
    
    def remover_questao_pesquisa(self):
        try:
            debugbar_btn = self.driver.find_element(By.CLASS_NAME, "phpdebugbar-maximize-btn")
            debugbar_btn.click()
            time.sleep(1)
        except Exception:
            pass
        botao_remover = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[2]/div/div[2]/div/table/tbody/tr[1]/td[3]/button[2]/i"))
        )
        self.driver.execute_script("arguments[0].scrollIntoView();", botao_remover)
        time.sleep(0.5)
        botao_remover.click()
    
    def campo_termos(self):
        return self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[4]/div/div[1]/div[2]/form/div[1]/div/input")

    def botao_salvar_termos(self):
        return self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[4]/div/div[1]/div[2]/form/div[2]/button")
    
    def termos_esta_listado(self, descricao):
        elementos = self.driver.find_elements(By.XPATH, "//span[contains(text(), '{}')]".format(descricao))
        return len(elementos) > 0
    
    def remover_termos(self):
        botao_remover = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[4]/div/div[1]/div[2]/div[2]/table/tbody/tr[1]/td[3]/button[2]/i"))
        )
        self.driver.execute_script("arguments[0].scrollIntoView();", botao_remover)
        time.sleep(0.5)
        botao_remover.click()
    
    def campo_estrategia(self):
        return self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[5]/div/div[2]/form/div[1]/div/div[2]/div[1]/p")

    def botao_salvar_estrategia(self):
        return self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[5]/div/div[2]/form/div[2]/button")

    def estrategia_esta_listada(self, descricao):
        try:
            editor = self.driver.find_element(By.CSS_SELECTOR, ".ql-editor")
            return descricao in editor.text
        except Exception:
            return False
        
    def campo_criterios_id(self):
        return self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[6]/div/div[2]/form/div/div[1]/div[1]/div/input")

    def campo_criterios_descricao(self):
        return self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[6]/div/div[2]/form/div/div[1]/div[2]/div/input")

    def selecionar_tipo_criterio(self, tipo):
        campo = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, '/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[6]/div/div[2]/form/div/div[2]/div/div/div[1]/div/div'))
        )
        campo.click()
        opcao = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located(
                (By.XPATH, f"//div[contains(@class, 'choices__item--choice') and normalize-space(text())='{tipo}']")
            )
        )
        opcao.click()

    def botao_salvar_criterios(self):
        return self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[6]/div/div[2]/form/div/div[3]/button")

    def criterio_esta_listado(self, id_criterio, descricao):
        elementos = self.driver.find_elements(By.XPATH, "//td[contains(text(), '{}') and contains(text(), '{}')]".format(id_criterio, descricao))
        return len(elementos) > 0
    
    def remover_criteri(self):
        try:
            debugbar_btn = self.driver.find_element(By.CLASS_NAME, "phpdebugbar-maximize-btn")
            debugbar_btn.click()
            time.sleep(1)
        except Exception:
            pass
        botao_remover = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[6]/div/div[2]/div/div[1]/div[1]/table/tbody/tr/td[4]/button[2]"))
        )
        self.driver.execute_script("arguments[0].scrollIntoView();", botao_remover)
        time.sleep(0.5)
        botao_remover.click()
    
    def campo_questao_qualidade_id(self):
        return self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[3]/div/div[1]/div[1]/div[2]/form/div[1]/div[1]/div/input")

    def campo_questao_qualidade_peso(self):
        return self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[3]/div/div[1]/div[1]/div[2]/form/div[1]/div[2]/div/input")

    def campo_questao_qualidade_descricao(self):
        return self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[3]/div/div[1]/div[1]/div[2]/form/div[2]/textarea")

    def botao_salvar_questao_qualidade(self):
        return self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[3]/div/div[1]/div[1]/div[2]/form/button")

    def questao_qualidade_esta_listada(self, id_questao, descricao):
        elementos = self.driver.find_elements(By.XPATH, "//td[contains(text(), '{}') and contains(text(), '{}')]".format(id_questao, descricao))
        return len(elementos) > 0
    
    def remover_questao_qualidade(self):
        try:
            debugbar_btn = self.driver.find_element(By.CLASS_NAME, "phpdebugbar-maximize-btn")
            debugbar_btn.click()
            time.sleep(1)
        except Exception:
            pass
        botao_remover = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[3]/div/div[1]/div[1]/div[2]/div/div/div/button/i"))
        )
        self.driver.execute_script("arguments[0].scrollIntoView();", botao_remover)
        time.sleep(0.5)
        botao_remover.click()

    def selecionar_base_dados(self, base):
        campo = self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[3]/div/div[1]/div[2]/form/div/div/div[1]/div/div[1]/div/div")
        campo.click()
        opcao = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located(
                (By.XPATH, f"//div[contains(@class, 'choices__item--choice') and normalize-space(text())='{base}']")
            )
        )
        opcao.click()

    def botao_salvar_base_dados(self):
        return self.driver.find_element(By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[3]/div/div[1]/div[2]/form/div/div/div[2]/button")

    def remover_base_dados(self):
        botao_remover = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[3]/div/div[1]/div[3]/table/tbody/tr/td[3]/div/button/i"))
        )
        self.driver.execute_script("arguments[0].scrollIntoView();", botao_remover)
        time.sleep(0.5)
        botao_remover.click()

        botao_confirmar = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, "/html/body/main/div[1]/div/div[2]/div/div/div[2]/div[3]/div/div[1]/div[3]/table/tbody/tr/td[3]/div/div/div/div/div[3]/button[2]"))
        )
        self.driver.execute_script("arguments[0].scrollIntoView();", botao_confirmar)
        time.sleep(0.5)
        botao_confirmar.click()

class MenuLateralPage:
    ABA_MEUS_PROJETOS = (By.XPATH, "/html/body/aside/div[2]/ul/li[2]/a")

    def __init__(self, driver):
        self.driver = driver

    def acessar_meus_projetos(self):
        self.driver.find_element(*self.ABA_MEUS_PROJETOS).click()

    def abrir_primeiro_projeto(self):
        botao_abrir = self.driver.find_element(
            By.XPATH,
            "/html/body/main/div[1]/div[1]/div/div/div/div/div[2]/div/table/tbody/tr[1]/td[4]/div/div[1]/a[1]"
        )
        botao_abrir.click()

    def acessar_overview(self):
        self.driver.find_element(
            By.XPATH,
            "/html/body/main/div[1]/div/div[1]/div/div[2]/div/ul/li[1]/a"
        ).click()

    def acessar_aba_planejamento(self):
        self.driver.find_element(
            By.XPATH,
            "/html/body/main/div[1]/div/div[1]/div/div[2]/div/ul/li[2]/a"
        ).click()

    def acessar_aba_questoes_pesquisa(self):
        self.driver.find_element(
            By.XPATH,
            "/html/body/main/div[1]/div/div[2]/div/div/div[1]/ul/li[2]/a"
        ).click()

    def acessar_aba_termos_busca(self):
        self.driver.find_element(
            By.XPATH,
            "/html/body/main/div[1]/div/div[2]/div/div/div[1]/ul/li[4]/a"
        ).click()

    def acessar_aba_estrategia(self):
        self.driver.find_element(
            By.XPATH,
            "/html/body/main/div[1]/div/div[2]/div/div/div[1]/ul/li[5]/a"
        ).click()

    def acessar_aba_criterios(self):
        self.driver.find_element(
            By.XPATH,
            "/html/body/main/div[1]/div/div[2]/div/div/div[1]/ul/li[6]/a"
        ).click()

    def acessar_aba_questao_qualidade(self):
        self.driver.find_element(
            By.XPATH,
            "/html/body/main/div[1]/div/div[2]/div/div/div[1]/ul/li[7]/a"
        ).click()

    def acessar_aba_base_dados(self):
        self.driver.find_element(
            By.XPATH,
            "/html/body/main/div[1]/div/div[2]/div/div/div[1]/ul/li[3]/a"
        ).click()
