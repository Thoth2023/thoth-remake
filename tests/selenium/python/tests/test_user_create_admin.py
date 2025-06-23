import unittest
import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys

class UserRegistrationTest(unittest.TestCase):
    def setUp(self):
        self.driver = webdriver.Chrome()
        self.driver.get("http://localhost:8989/user/create")

    def test_empty_form_submission(self):
        driver = self.driver
        submit_button = driver.find_element(By.CSS_SELECTOR, "button[type='submit']")
        submit_button.click()
        time.sleep(1)

        error_elements = driver.find_elements(By.CLASS_NAME, "text-danger")
        self.assertTrue(any("usuário" in e.text.lower() or "obrigatório" in e.text.lower() for e in error_elements))

    def test_invalid_email_submission(self):
        driver = self.driver
        driver.find_element(By.NAME, "username").send_keys("usuario_teste")
        driver.find_element(By.NAME, "email").send_keys("emailinvalido")
        driver.find_element(By.NAME, "password").send_keys("Senha123!")
        driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()
        time.sleep(1)

        error_elements = driver.find_elements(By.CLASS_NAME, "text-danger")
        self.assertTrue(any("email" in e.text.lower() for e in error_elements))

    def test_valid_form_submission(self):
        driver = self.driver
        driver.find_element(By.NAME, "username").send_keys("usuario_teste")
        driver.find_element(By.NAME, "email").send_keys("usuario_teste@example.com")
        driver.find_element(By.NAME, "password").send_keys("SenhaSegura123!")
        driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()
        time.sleep(2)

        alert_div = driver.find_element(By.ID, "alert")
        self.assertIn("sucesso", alert_div.text.lower())

    def tearDown(self):
        self.driver.quit()

if __name__ == "__main__":
    unittest.main()
