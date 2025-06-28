import time
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

class QualityAssessmentPage:
    QUALITY_ASSESSMENT_BUTTON = (By.XPATH, "//*[@id='quality-assessment-tab']")
    STUDY = (By.XPATH, "//*[@id='quality-assessment']/div/div[3]/div/ul[2]/div[1]/div[2]/span")
    SUCCESS_OK_BUTTON = (By.XPATH, "//*[@id='successModalQuality']/div/div/div[3]/button")
    CLOSE_BUTTON = (By.XPATH, "//*[@id='paperModalQuality']/div/div/div[1]/button")
    DROPBOX = (By.XPATH, "//*[@id='paperModalQuality']/div/div/div[2]/ul[2]/div[1]/div[4]/span/div/div")

    def __init__(self, driver):
        self.driver = driver
        self.wait = WebDriverWait(driver, 10)

    def click(self, locator):
        self.wait.until(EC.element_to_be_clickable(locator)).click()

    def scroll_down(self, times=2):
        for _ in range(times):
            self.driver.find_element(By.TAG_NAME, 'body').send_keys(Keys.PAGE_DOWN)
            
    def scroll_up(self, times=1):
        for _ in range(times):
            self.driver.find_element(By.TAG_NAME, 'body').send_keys(Keys.PAGE_UP)

    def open_quality_assessment(self):
        self.scroll_up(5)
        self.click(self.QUALITY_ASSESSMENT_BUTTON)
        
    def select_data_value(self, value):
        dropdown = self.wait.until(EC.element_to_be_clickable(self.DROPBOX))
        dropdown.click()

        if value == 1:
            dropdown.send_keys(Keys.ARROW_UP)
        if value == 2:
            dropdown.send_keys(Keys.ARROW_DOWN)
            
        dropdown.send_keys(Keys.ENTER)

    def open_unclassified_study(self):
        self.scroll_down()
        self.click(self.STUDY)

    def study_accepted(self):
        self.select_data_value(2)
        time.sleep(2)
        self.click(self.SUCCESS_OK_BUTTON)
        time.sleep(1)
        self.click(self.CLOSE_BUTTON)

    def study_rejected(self):
            self.select_data_value(1)
            time.sleep(2)
            self.click(self.SUCCESS_OK_BUTTON)
            time.sleep(1)
            self.click(self.CLOSE_BUTTON)