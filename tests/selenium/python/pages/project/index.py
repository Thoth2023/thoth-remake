import time
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

class ProjectPage:
    CONDUCTING_BUTTON = (By.XPATH, "/html/body/main/div[1]/div/div[1]/div/div[2]/div/ul/li[3]/a")
    DASHBOARD_BUTTON = (By.XPATH, "/html/body/main/div[1]/div/div[1]/div/div[2]/div/ul/li[1]/a")
    
    def __init__(self, driver):
        self.driver = driver

    def load(self):
        self.driver.get(self.URL)
        
    def open_conducting(self):
        self.driver.find_element(*self.CONDUCTING_BUTTON).click()
        
    def open_dashboard(self):
        body = self.driver.find_element(By.TAG_NAME, 'body')

        for _ in range(5):
            body.send_keys(Keys.PAGE_UP)
            time.sleep(0.2)

        wait = WebDriverWait(self.driver, 10)
        dashboard_button = wait.until(EC.element_to_be_clickable(self.DASHBOARD_BUTTON))

        dashboard_button.click()